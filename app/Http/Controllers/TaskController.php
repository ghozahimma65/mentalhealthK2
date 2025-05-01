<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('task.index', compact('tasks'));
    }

    public function store(TaskRequest $request)
    {
        $validatedData = $request->validated();
        Task::create($validatedData);

        return redirect('/task'); // Redirect ke halaman daftar task
    }

    public function show(Task $task)
    {
        return view('task.show', compact('task'));
    }

    public function edit(Task $task)
    {
        return view('task.edit', compact('task'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validatedData = $request->validated();
        $task->update($validatedData);
        
        return redirect()->route('task.show', $task->id);
    }
    public function delete(Task $task)
    {
    $task->delete();
    return redirect()->route('task.index')->with('success', 'Task berhasil dihapus!');
    }
}
