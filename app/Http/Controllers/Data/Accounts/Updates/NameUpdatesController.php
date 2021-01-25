<?php

namespace App\Http\Controllers\Data\Accounts\Updates;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatedNameRequest;

class NameUpdatesController extends Controller
{
    public function update(UpdatedNameRequest $request, User $user)
    {
        $user->update($request->validated());

        return response([
            'user' => $request->only('id', 'name', 'email', 'role')
        ]);
    }
}
