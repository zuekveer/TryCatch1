<?php

namespace App\Services;

use Illuminate\Support\Facades\Password;

class PasswordResetService
{
    public function sendResetLink(array $data)
    {
        return Password::sendResetLink($data);
    }

    public function resetPassword(array $data)
    {
        return Password::reset(
            $data,
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );
    }
}

