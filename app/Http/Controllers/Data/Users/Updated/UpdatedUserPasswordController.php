<?php

namespace App\Http\Controllers\Data\Users\Updated;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserPasswordRequest;
use Illuminate\Support\Facades\Password;

class UpdatedUserPasswordController extends Controller
{
    public function update(UpdateUserPasswordRequest $request, User $user)
    {
        $user->update(['password' => Hash::make($request->password)]);

        return response([
            'user' => $user->only('id', 'name', 'email', 'role')
        ]);
    }

    public function sendResetLink(User $user)
    {
        $user->sendPasswordResetNotification(Str::random(60));

        return response([
            'user' => $user->only('id', 'name', 'email', 'role')
        ]);
    }
}
