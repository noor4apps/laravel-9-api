<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $credentials = ['email' => $request->email, 'password' => $request->password];

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('api-token')->plainTextToken;
            return response()->json(['status' => true, 'message' => 'logged in', 'data' => ['token' => $token, 'user' => $user]], 201);
        } else {
            return response()->json(['status' => false, 'message' => 'Please check email and password!', 'data' => []], 401);
        }
    }

    public function logout()
    {
        $user = auth()->user();
        if ($user->tokens()->delete()) {
            return response()->json(['status' => true, 'message' => 'logged out', 'data' => []], 201);
        } else {
            return response()->json(['status' => false, 'message' => 'something went wrong!', 'data' => []], 401);
        }

    }
}
