@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Task List</h1>

        <a href="{{ route('task.create') }}" class="btn btn-primary">Tambah Task</a>

        @forelse ($tasks as $task)
            <div class="task-item">
                <strong>Name: {{ $task->name }}</strong>
                <p>Description: {{ $task->description }}</p>
                
                <a href="{{ route('task.show', $task->id) }}" class="view-link">View</a>
                <a href="{{ route('task.edit', $task->id) }}" class="edit-link">Edit</a>

                <form action="{{ route('task.delete', $task->id) }}" method="POST" class="delete-form">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Yakin ingin menghapus task ini?')">Delete</button>
</form>
            </div>
        @empty
            <p>Tidak ada task yang tersedia.</p>
        @endforelse
    </div>
@endsection
