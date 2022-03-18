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
        $project = Project::factory()->create();
        $task = $project->addTask($this->faker->sentence());

        $this->patch($task->path(), ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);

    }

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
    public function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );

        $task = $project->addTask($this->faker->sentence());

        $this->patch($project->path() . '/tasks/' . $task->id, [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks',[
           'body' => 'changed',
           'completed' => true
        ]);
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
