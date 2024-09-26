<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'last_name' => 'required|string|max:40',
            'name' => 'required|string|max:40',
            'middle_name' => 'nullable|string|max:40',
            'email' => 'required|string|email|max:80|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        $user = $this->userService->register($data);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $token = $this->userService->login($data);

        return $token
            ? response()->json(['token' => $token])
            : response()->json(['message' => 'Invalid credentials'], 401);
    }
}

