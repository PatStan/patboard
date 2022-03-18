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

    public function show(Project $project)
    {
        if (auth()->user()->isNot($project->user))
        {
            abort(403);
        }

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
            'description' => 'required'
        ]);

        $project = auth()->user()->projects()->create($attributes);

        //redirect
        return redirect($project->path());
    }
}
