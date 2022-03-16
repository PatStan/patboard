@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between">
        <h2 class="text-slate-400 font-bold text-2xl text-opacity-80">
            <a class="hover:text-slate-500" href="/projects">My Projects</a> / {{ $project->title }}
        </h2>
        <div class="">
            <a href="/projects/create" class="button">New Project</a>
        </div>
    </div>
@endsection

@section('body')
    <div class="lg:flex -mx-3">
        <div class="lg:w-3/4 px-3 mb-6">
            {{--tasks--}}
            <div class="mb-8">
                <h2 class="text-lg font-normal text-slate-400 text-opacity-80 mb-3">Tasks</h2>
                <div class="card mb-3">test test test</div>
                <div class="card mb-3">test test test</div>
                <div class="card mb-3">test test test</div>
                <div class="card">test test test</div>
            </div>

            {{--notes--}}
            <div>
                <h2 class="text-lg font-normal text-slate-400 text-opacity-80 mb-3">General Notes</h2>
                <textarea class="card w-full" style="min-height: 200px">test test test</textarea>
            </div>
        </div>

        <div class="lg:w-1/4 px-3 pt-10">
            @include('projects.card')
        </div>
    </div>
@endsection
