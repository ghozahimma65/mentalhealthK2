@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Task</h1>

    <form method="POST" action="{{ route('task.store') }}">
        @csrf <!-- Cross-Site Request Forgery protection -->

        <label for="name">Name</label>
        <input type="text" name="name" id="name" required>
        <br>

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10"></textarea>
        <br>

        <button type="submit">Create Task</button>
    </form>

    <a href="{{ url('/task') }}">Back To Task</a>
</div>
@endsection
