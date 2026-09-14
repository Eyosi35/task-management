<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illumincate\Support\Facades\Gate;
use App\Models\Task;

class AdminController extends Controller
{
    public function tasks(Request $request){
        if(Gate::denies('admin-task')){
            return response()->json([
                'message' => 'Forbidden Request',
            ],403);
        }

        $tasks = Task::with('user:id,name,email')->get();

        return response()->json($tasks);
    }
    

    
}
