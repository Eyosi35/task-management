<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\AdminTaskResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Gate;
use App\Models\Task;


class AdminController extends Controller
{
    public function index(Request $request){
        if(Gate::denies('admin-task')){
            return response()->json([
                'message' => 'Forbidden Request',
            ],403);
        }

        $tasks = Task::with('user:id,name,email')->get();

        return response()->json(AdminTaskResource::collection($tasks));
    }

    public function destroy(Task $task){
        if(Gate::denies('admin-task')){
            return response()->json([
                'message' => 'Forbidden Request',
            ],403);
        }

        $user = $task->user;
        $task->delete();

        return response()->json([
            'message' => "User's task deleted Successfully",
            'user' => new UserResource($user)
        ]);
    }
}
