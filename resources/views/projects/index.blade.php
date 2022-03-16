@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between">
        <h2 class="text-slate-600 font-bold text-2xl text-opacity-80">My Projects</h1>
        <div class="">
            <a href="/projects/create" class="button">New Project</a>
        </div>
    </div>
@endsection

@section('body')

    <div class="lg:flex lg:flex-wrap -mx-3">
        @forelse($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                <div class="bg-white p-5 rounded-lg shadow" style="height: 200px">
                    <h3 class="text-xl py-4 -ml-5 mb-3 border-l-4 border-slate pl-4">
                        <a href="{{ $project->path() }}">{{ $project->title }}</a>
                    </h3>

                    <div class="text-gray-400">{{ Illuminate\Support\Str::limit($project->description, 100) }}</div>
                </div>
            </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </div>
@endsection

