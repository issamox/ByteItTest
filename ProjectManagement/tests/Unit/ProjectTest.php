<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_requires_a_title()
    {
        $project = new Project([
            'description' => 'Test description',
            'start_date' => now(),
            'end_date' => now()->addDays(5),
        ]);

        $this->assertFalse($project->save());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_be_created_with_valid_data()
    {
        $user = User::factory()->create();

        $project = Project::create([
            'title' => 'Test Project',
            'description' => 'Test description',
            'start_date' => now(),
            'end_date' => now()->addDays(5),
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('projects', [
            'title' => 'Test Project',
        ]);
    }
}
