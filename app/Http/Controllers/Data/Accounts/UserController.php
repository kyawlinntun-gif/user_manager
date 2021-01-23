<?php

namespace App\Http\Controllers\Data\Accounts;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(User $user = null)
    {
        if($user == null)
        {
            return response([
                'user' => Auth::user()
            ]);
        }
    }
}
