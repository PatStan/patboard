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

        return view('projects.show', ['project' => $project]);
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store()
    {
        $attributes = $this->validateProjectRequest();

        $project = auth()->user()->projects()->create($attributes);

        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit', ['project' => $project]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Project $project)
    {
        $this->authorize('update', $project);

        $attributes = $this->validateProjectRequest();

        $project->update($attributes);

        return redirect($project->path());
    }

    /**
     * @return array
     */
    public function validateProjectRequest(): array
    {
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required|max:100', //TODO: come back to the max:100
            'notes' => 'nullable'
        ]);
    }
}
