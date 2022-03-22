@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between">
        <h2 class="text-slate-700 font-bold text-2xl text-opacity-80">
            <a class="hover:text-slate-800" href="/projects">My Projects</a> / {{ $project->title }}
        </h2>
        <div class="">
            <a href="{{ $project->path().'/edit' }}" class="button">Edit Project</a>
        </div>
    </div>
@endsection

@section('body')
    <div class="lg:flex -mx-3">
        <div class="lg:w-3/4 px-3 mb-6">
            {{--tasks--}}
            <div class="mb-8">
                <h2 class="text-lg font-normal text-slate-500 text-opacity-80 mb-3">Tasks</h2>

                @foreach($project->tasks as $task)
                    <div class="card mb-3">
                        <form method="POST" action="{{ $task->path() }}">
                            @method('PATCH')
                            @csrf

                            <div class="flex items-center">
                                <input name="body" value="{{ $task->body }}" class="w-full {{ $task->completed ? 'text-gray-400' : '' }}"/>
                                <input name="completed" type="checkbox" onChange="this.form.submit()" {{ $task->completed ? 'checked' : ''}}>
                            </div>
                        </form>
                    </div>
                @endforeach

                <div class="card mb-3">
                    <form action="{{ $project->path() . '/tasks' }}" method="POST">
                        @csrf
                        <input placeholder="Add a new task..." class="w-full" name="body">
                    </form>
                </div>
            </div>

            {{--notes--}}
            <div>
                <h2 class="text-lg font-normal text-slate-500 text-opacity-80 mb-3">General Notes</h2>
                <form method ="POST" action="{{ $project->path() }}">
                    @csrf
                    @method('PATCH')
                    <textarea
                        name="notes"
                        class="card w-full mb-4"
                        style="min-height: 200px"
                        placeholder="Write something...">{{ $project->notes }}</textarea>

                    <button type="submit" class="button">Save</button>
                </form>

                @if ($errors->any())
                    <div class="field mt-4">
                        @foreach($errors->all() as $error)
                            <li class="text-sm text-red-500">{{ $error }}</li>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>

        <div class="lg:w-1/4 px-3 pt-10">
            @include('projects.card')
        </div>
    </div>
@endsection
