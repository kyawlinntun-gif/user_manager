<?php

namespace App\Http\Controllers\Data\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request, $next) {
            if(!Auth::user()->isAdmin())
            {
                return response('Unauthorized', 403); 
            }

            return $next($request);
        })->only('destroy', 'index');
    }

    public function index()
    {
        return response([
            'results' => User::latest()->paginate(20)
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->only('name', 'email', 'role') + ['password' => Hash::make($request->password)]);

        return response([
            'user' => $user
        ]);
    }

    public function destroy(User $user)
    {
        return response([
            'user' => $user
        ]);
    }
}
