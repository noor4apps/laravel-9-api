<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->api([], 1, $validator->errors()->first());
        }

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {

            $user = auth()->user();

            $data['user'] = new UserResource($user);
            $data['token'] = $user->createToken('api-token')->plainTextToken;

            return response()->api($data);
        } else {
            return response()->api([], 1, __('auth.failed'));
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        if($validator->fails()) {
            return response()->api([], 1, $validator->errors()->first());
        }

        $request->merge([
            'password' => bcrypt($request->password),
        ]);

        $user = User::create($request->all());

        $data['user'] = new UserResource($user);
        $data['token'] = $user->createToken('api-token')->plainTextToken;

        return response()->api($data);
    }

    public function logout()
    {
        $user = auth()->user();

        if ($user->tokens()->delete()) {
            return response()->api([], 0, 'logged out');
        } else {
            return response()->api([], 1, 'something went wrong!');
        }

    }
}
