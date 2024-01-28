<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
            'can'   => [
                'createTask' => auth()->user()->can('task_create'),
                'editTask' => auth()->user()->can('task_edit'),
                'destroyTask' => auth()->user()->can('task_destroy'),
            ],
        ]);
    }

    public function create()
    {
        $this->authorize('task_create');

        return Inertia::render('Tasks/Create');
    }

    public function store(StoreTaskRequest $request)
    {
        $this->authorize('task_create');

        Task::create($request->validated());

        return redirect()->route('tasks.index');
    }

    public function edit(Task $task)
    {
        $this->authorize('task_edit');

        return Inertia::render('Tasks/Edit', compact('task'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('task_edit');

        $task->update($request->validated());

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $this->authorize('task_destroy');

        $task->delete();

        return redirect()->route('tasks.index');
    }
}
