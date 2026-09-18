<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\AdminTaskResource;
use  Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Task::class);

        if(Gate::allows('admin-task')){
            return response()->json(AdminTaskResource::collection(Task::all()));
        }

        $user = $request->user();
        return response()->json(TaskResource::collection($user->tasks));
    }

    public function show(Task $task){
        $this->authorize('view', $task);

        return response()->json(new TaskResource($task));
    }

    public function store(StoreTaskRequest $request){
        $this->authorize('create', Task::class);

        $task = $request->user()->tasks()->create($request->validated());

        return response()->json([
            'message' => 'Task created successfully',
            'task_info' => new TaskResource($task),
        ], 201);
    }

    public function update(UpdateTaskRequest $request, Task $task){
        $this->authorize('update', $task);

        $task->update($request->validated());

        if(Gate::allows('admin-task')){
            return response()->json([
                'message' => "You have updated the user's task successfully",
                'updated_task' => new AdminTaskResource($task),
            ]);
        }

        return response()->json([
            'message' => "Task updated successfully",
            'updated_task' => new TaskResource($task),
        ]);
    }

    public function destroy(Task $task){
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json(['message' => 'Task deleted Successfully']);
    }
}
