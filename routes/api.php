<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminController;

Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', [LoginController::class, 'store'])
->middleware('throttle:login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy']);
    
    Route::get('/me', function (Request $request) {
        return response()->json($request->user());
    });

    Route::apiResource('tasks', TaskController::class)
        ->middleware('throttle:task_requests');

    Route::apiResource('admin/tasks', AdminController::class)
        ->only(['index','destroy']);
    
    Route::delete('/admin/user/{user}/', [AdminController::class, 'destroyUser']);
});
