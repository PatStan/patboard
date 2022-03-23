<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectTaskFactory;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function creating_a_project()
    {
        $project = ProjectTaskFactory::create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity->first()->description);
    }

    /** @test */
    public function updating_a_project()
    {
        $project = ProjectTaskFactory::create();

        $project->update(['title' => 'changed']);
        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->description);
    }

    /** @test */
    public function creating_a_new_task()
    {
        $project = ProjectTaskFactory::withTasks(1)->create();

        $this->assertCount(2, $project->activity);
        $this->assertEquals('created task', $project->activity->last()->description);
    }

    /** @test */
    public function completing_a_task()
    {
        $project = ProjectTaskFactory::withTasks(1)->create();

        $this->actingAs($project->user)
            ->patch($project->tasks->first()->path(), [
                'body' => 'foobar',
                'completed' => true
            ]);

        $this->assertCount(3, $project->activity);
        $this->assertEquals('completed task', $project->activity->last()->description);
    }

    /** @test */
    public function incompleting_a_task()
    {
        $project = ProjectTaskFactory::withTasks(1)->create();

        $this->actingAs($project->user)
            ->patch($project->tasks->first()->path(), [
                'body' => 'foobar',
                'completed' => true
            ]);

        $this->assertCount(3, $project->activity);

        $this->actingAs($project->user)
            ->patch($project->tasks->first()->path(), [
                'body' => 'foobar',
                'completed' => false
            ]);

        $project->refresh();
        $this->assertCount(4, $project->activity);
        $this->assertEquals('uncompleted task', $project->activity->last()->description);
    }

    /** @test */
    public function deleting_a_task()
    {
        $project = ProjectTaskFactory::withTasks(1)->create();

        $project->tasks->first()->delete();

        $this->assertCount(3, $project->activity);
    }
}
