<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;


class TaskController extends Controller
{
    public function index(Request $request){
        $tasks = $request->user()->isAdmin()
            ? Task::all()
            : $request->user()->tasks;

        return response()->json($tasks);
    }

    public function show(Task $task){
        $this->authorize('view', $task);

        return response()->json($task);
    }

    public function store(StoreTaskRequest $request){
        $task = $request->user()->tasks()->create($request->validated());

        return response()->json([
            'message' => 'Task created successfully',
            'task_info' => $task,
        ], 201);
    }

    public function update(UpdateTaskRequest $request, Task $task){
        $this->authorize('update', $task);

        $task->update($request->validated());

        return response()->json([
            'message' => 'Task Updated Successfully',
            'task' => $task,
        ]);
    }

    public function destroy(Task $task){
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json([
            'message' => 'Task Deleted Successfully',
        ]);
    }
}
