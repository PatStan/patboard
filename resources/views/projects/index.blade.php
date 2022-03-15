@extends('layouts.app')

@section('header')
    <h1 class="text-green-800 font-bold text-5xl">Patboard</h1>
@endsection

@section('body')
    <div class="m-8">
    <a href="projects/create" class="font-semibold text-indigo-600">Create New Project</a>
    </div>

    <div class="ml-10 flex">
        @forelse($projects as $project)
            <div class="bg-white p-5 mr-4 rounded shadow w-1/3" style="height: 200px">
                <h3 class="text-xl py-4">{{ $project->title }}</h3>

                <div class="text-gray-400">{{ Illuminate\Support\Str::limit($project->description, 100) }}</div>
            </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </div>
@endsection

