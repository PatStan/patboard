<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects;
        //auth()->user()->projects()->orderByDesc('updated_at')->get() DB query, eloquent builder instance
        //auth()->user()->projects->sortByDesc('updated_at') sorts collection at PHP level

        return view('projects.index', compact('projects'));
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Project $project)
    {
        $this->authorize('update', $project);
//        if (auth()->user()->isNot($project->user))
//        {
//            abort(403);
//        }

        return view('projects.show', ['project' => $project]);
    }

    public function create()
    {
        return view('project.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required|max:100', //TODO: come back to the max:100
            'notes' => 'min:3'
        ]);

        $project = auth()->user()->projects()->create($attributes);

        return redirect($project->path());
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Project $project)
    {
        $this->authorize('update', $project);
//        if (auth()->user()->isNot($project->user))
//        {
//            abort(403);
//        }

        $project->update(request(['notes']));

        return redirect($project->path());
    }
}
