<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('update', $project);
//        if (auth()->user()->isNot($project->user))
//        {
//            abort(403);
//        }
        request()->validate(['body' => 'required']);
        $project->addTask(request('body'));

        return redirect($project->path());
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Project $project, Task $task)
    {
        $this->authorize('update', $task->project);

        request()->validate(['body' => 'required']);

        $task->update(['body' => request('body')]);

        if (request()->has('completed')) {
            $task->complete();
        }

        return redirect($project->path());
    }
}
