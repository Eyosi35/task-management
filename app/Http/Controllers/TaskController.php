<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resource\TaskResource;
use App\Http\Resource\AdminTaskResource;



class TaskController extends Controller
{
    public function index(Request $request){
        $user = $request->user()->isAdmin();

        if($user){
            return response()->json(AdminTaskResource::collection(Task::all()));
        }

        return response()->json(TaskResource::collection($user->$tasks));
    }

    public function show(Task $task){
        $this->authorize('view', $task);

        return response()->json(new TaskResource($task));
    }

    public function store(StoreTaskRequest $request){
        $task = $request->user()->tasks()->create($request->validated());

        return response()->json([
            'message' => 'Task created successfully',
            'task_info' => new TaskResource($task),
        ], 201);
    }

    public function update(UpdateTaskRequest $request, Task $task){
        $this->authorize('update', $task);

        $task->update($request->validated());

        return response()->json([
            'message' => 'Task Updated Successfully',
            'task' => new TaskResource($task),
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
