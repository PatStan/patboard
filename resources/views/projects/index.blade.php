@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between">
        <h2 class="text-slate-400 font-bold text-2xl text-opacity-80">My Projects</h2>
        <div class="">
            <a href="/projects/create" class="button">New Project</a>
        </div>
    </div>
@endsection

@section('body')

    <div class="lg:flex lg:flex-wrap -mx-3">
        @forelse($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                @include('projects.card')
            </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </div>
@endsection

