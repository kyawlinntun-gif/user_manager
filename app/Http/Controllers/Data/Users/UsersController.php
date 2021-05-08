<?php

namespace App\Http\Controllers\Data\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                return response('Unauthorized', 403);
            }

            return $next($request);
        })->only('destroy', 'index');
    }

    public function index()
    {
        return response([
            'results' => User::latest('updated_at')->paginate(20)
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->only('name', 'email', 'role') + ['password' => Hash::make($request->password)]);

        return response([
            'user' => $user
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return response([
            'user' => $user->only('id', 'name', 'email', 'role')
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null);
    }
}
