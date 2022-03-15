@extends('layouts.app')

@section('header')
    <h1 class="text-green-800 font-bold text-5xl">Patboard</h1>
@endsection

@section('body')
    <div class="m-8">
    <a href="projects/create" class="font-semibold text-indigo-600">Create New Project</a>
    </div>

    <div class="ml-10 pt-3 flex">
        @forelse($projects as $project)
            <div class="bg-white mr-4 rounded shadow">
                <h3>{{ $project->title }}</h3>

                <div>{{ $project->description }}</div>
            </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </div>
@endsection

