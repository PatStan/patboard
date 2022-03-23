<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectTaskFactory;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_add_tasks_to_projects()
    {
        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    /** @test */
    public function only_the_owner_of_a_project_can_add_tasks()
    {
        $this->signIn();
        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', ['body' => $body = $this->faker->sentence()])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => $body]);

    }

    /** @test */
    public function only_the_owner_of_a_project_can_update_a_task()
    {
        $this->signIn();
        $project = ProjectTaskFactory::withTasks(1)->create();

        $this->patch($project->tasks->first()->path(), ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);

    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        $project = ProjectTaskFactory::create();

        $this->actingAs($project->user)
            ->post($project->path() . '/tasks', ['body' => $body = $this->faker->sentence()]);

        $this->get($project->path())
            ->assertSee($body);
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $project = ProjectTaskFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        //here you can chain actingAs($project->user) instead of ownedBy
        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed'
        ]);

        $this->assertDatabaseHas('tasks',[
           'body' => 'changed'
        ]);
    }

    /** @test */
    public function a_task_can_be_completed()
    {
        $project = ProjectTaskFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        //here you can chain actingAs($project->user) instead of ownedBy
        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks',[
            'body' => 'changed',
            'completed' => true
        ]);
    }

    /** @test */
    public function a_task_can_be_marked_as_incomplete()
    {
        $project = ProjectTaskFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        //here you can chain actingAs($project->user) instead of ownedBy
        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed',
            'completed' => false
        ]);

        $this->assertDatabaseHas('tasks',[
            'body' => 'changed',
            'completed' => false
        ]);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $project = ProjectTaskFactory::create();

        $attributes = Task::factory()->raw(['body' => '']);

        $this->actingAs($project->user)
            ->post($project->path() . '/tasks', $attributes)
            ->assertSessionHasErrors('body');
    }

}
