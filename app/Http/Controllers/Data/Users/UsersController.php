<?php

namespace App\Http\Controllers\Data\Users;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        return response([
            'results' => User::latest()->paginate(20)
        ]);
    }

    public function store(Request $request)
    {
        return response([
            'data' => $request->all()
        ]);
    }
}
