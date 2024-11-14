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
     * Display a listing of the resource.
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
