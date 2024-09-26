<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserService
{
    public function register(array $data)
    {
        return DB::transaction(function () use ($data) {
            $data['id'] = (string) Str::uuid();

            return User::create([
                'id' => $data['id'],
                'last_name' => $data['last_name'],
                'name' => $data['name'],
                'middle_name' => $data['middle_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
            ]);
        });
    }

    public function login(array $data)
    {

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            return $token;
        }

        return false;
    }
}
