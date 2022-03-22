@extends('layouts.app')
@section('body')
    <form
        method="POST"
        action="/projects"
        class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow"
    >
        @include('projects.form', ['project' => new App\Models\Project(), 'title' => 'Create Your Project'])
    </form>
@endsection

