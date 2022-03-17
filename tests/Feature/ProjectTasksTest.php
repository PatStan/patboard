<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->actingAs(User::factory()->create());

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        $this->post($project->path() . '/tasks', ['body' => $body = $this->faker->sentence()]);

        $this->get($project->path())
            ->assertSee($body);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();

        $project = Project::factory()->create(['user_id' => auth()->id()]);
        $attributes = Task::factory()->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }

}
