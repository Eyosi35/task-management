<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\LoginRequest;

use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    
    public function store(LoginRequest $request){
        $credentials = $request->validated();

        $user = User::where('email', $credentials['email'])->first();

        if(!$user || !Hash::check($credentials['password'], $user->password)){
            return response()->json([
                'message' => 'Invalid credentials, try again'
            ],401);
        }
        
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'login successful',
            'user' => new UserResource($user),
            'token' => $token
        ]);
    }

    public function destroy(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
