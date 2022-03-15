@extends('layouts.app')

@section('body')
<h1>{{ $project->title }}</h1>
<div>
    {{ $project->description }}
</div>
@endsection
