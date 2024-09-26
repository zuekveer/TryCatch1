<?php

namespace App\Http\Controllers;

use App\Services\PasswordResetService;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    protected $passwordResetService;

    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = $this->passwordResetService->sendResetLink($request->only('email'));

        return $status
            ? response()->json(['message' => 'Reset link sent to your email'])
            : response()->json(['message' => 'Error sending reset link'], 500);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:8',
            'token' => 'required|string',
        ]);

        $status = $this->passwordResetService->resetPassword(
            $request->only('email', 'password', 'password_confirmation', 'token')
        );

        return $status
            ? response()->json(['message' => 'Password has been reset'])
            : response()->json(['message' => 'Error resetting password'], 500);
    }
}

