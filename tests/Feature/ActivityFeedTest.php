<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectTaskFactory;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function creating_a_project_records_activity()
    {
        $project = ProjectTaskFactory::create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity->first()->description);
    }

    /** @test */
    public function updating_a_project_records_activity()
    {
        $project = ProjectTaskFactory::create();

        $project->update(['title' => 'changed']);
        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->description);
    }

    /** @test */
    public function creating_a_new_task_records_project_activity()
    {
        $project = ProjectTaskFactory::withTasks(1)->create();

        $this->assertCount(2, $project->activity);
        $this->assertEquals('created task', $project->activity->last()->description);
    }

    /** @test */
    public function completing_a_task_records_project_activity()
    {
        $project = ProjectTaskFactory::withTasks(1)->create();

        $this->actingAs($project->user)
            ->patch($project->tasks->first()->path(), [
                'body' => 'foobar',
                'completed' => true
            ]);

        $this->assertCount(3, $project->activity);

//        $this->assertCount(2, $project->activity);
//        $this->assertEquals('created task', $project->activity->last()->description);
    }
}
