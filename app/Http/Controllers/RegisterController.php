<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterStoreRequest;

class RegisterController extends Controller
{
    public function store(RegisterStoreRequest $request){
        $validatedAtt = $request->validated();

        $user = User::create([
            'name' => $validatedAtt['name'],
            'email' => $validatedAtt['email'],
            'password' => Hash::make($validatedAtt['password']),
            'role' => 'user',
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'User registered Successfully',
            'user' => new UserResource($user),
            'token' => $token,
        ],201);
    }

}
