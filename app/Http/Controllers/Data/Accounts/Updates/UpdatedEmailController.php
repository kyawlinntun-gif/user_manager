<?php

namespace App\Http\Controllers\Data\Accounts\Updates;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdatedEmailRequest;

class UpdatedEmailController extends Controller
{
    public function update(UpdatedEmailRequest $request, User $user)
    {
        $user->update($request->validated());

        return response([
            'user' => $user->only('id', 'name', 'email', 'role')
        ]);
    }
}
