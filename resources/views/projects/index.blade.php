@extends('layouts.app')

@section('header')
    <h1 class="text-green-600 font-bold text-xl">Patboard</h1>
@endsection

@section('content')
    <div class="flex items-center">
        <a href="/projects/create" class="font-semibold">Create New Project</a>
    </div>

    <ul>
        @forelse($projects as $project)
            <li>
                <a href="{{ $project->path() }}">{{ $project->title }}</a>
            </li>
        @empty
            <li>No projects yet.</li>
        @endforelse
    </ul>
@endsection
