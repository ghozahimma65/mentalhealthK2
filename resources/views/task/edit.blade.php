@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Tasks</h1>
    <form method="POST" action="{{ url("/task/{$task->id}") }}">
        @method("PUT")
        @csrf <!-- Cross-site request forgery -->

        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $task->name) }}">
        <br>

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10">{{ old('description', $task->description) }}</textarea>
        <br>

        <button type="submit">Edit Task</button>
    </form>

    <a href="{{ url('/task') }}">Back To Task</a>
</div>
@endsection
