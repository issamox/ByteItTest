<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    use  AuthorizesRequests;

    /**
     * @OA\Info(title="My First API", version="0.1")
     */


    public function search(Request $request)
    {
        $title = $request->get('title');
        $description = $request->get('description');

        $query = Project::query();


        if ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        }

        if ($description) {
            $query->where('description', 'like', '%' . $description . '%');
        }

        $projects = $query->paginate(10);

        if ($projects->isEmpty()) {
            return response()->json(['message' => 'No projects found'], 404);
        }

        return ProjectResource::collection($projects);
    }

    /**
     * @OA\Schema(
     *      schema="Project",
     *      type="object",
     *      required={"id", "title", "start_date", "user_id"},
     *      @OA\Property(property="id", type="integer"),
     *      @OA\Property(property="title", type="string"),
     *      @OA\Property(property="description", type="string", nullable=true),
     *      @OA\Property(property="start_date", type="string", format="date-time"),
     *      @OA\Property(property="end_date", type="string", format="date-time", nullable=true),
     *      @OA\Property(property="user_id", type="integer"),
     *  )
     * @OA\Get(
     *     path="/api/projects",
     *     summary="Get a list of projects for the authenticated user",
     *     tags={"Projects"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         description="Bearer token",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A list of projects for the authenticated user",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/Project")
     *             ),
     *             @OA\Property(property="first_page_url", type="string"),
     *             @OA\Property(property="last_page_url", type="string"),
     *             @OA\Property(property="next_page_url", type="string", nullable=true),
     *             @OA\Property(property="prev_page_url", type="string", nullable=true),
     *             @OA\Property(property="total", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Server error")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $projects = Cache::remember("projects_user_".auth()->id(), 60, function() {
            return Project::where('user_id', auth()->id())->with('tasks')->orderBy('start_date', 'asc')->paginate(10);
        });
        return ProjectResource::collection($projects);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] =  auth()->id();

        $project = Project::create($data);
        return new ProjectResource($project);

    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);
         $project->load('tasks');
        return new ProjectResource($project);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {

        $this->authorize('update', $project);
        $project->update($request->validated());
        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully.'], 200);

    }
}
