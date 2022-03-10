<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        return view('projects.show', ['project' => $project]);
    }

    public function store()
    {
        //validate
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        
        auth()->user()->projects()->create($attributes);

        //redirect
        return redirect('/projects');
    }
}
