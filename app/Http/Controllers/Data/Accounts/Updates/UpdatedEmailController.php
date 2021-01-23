<?php

namespace App\Http\Controllers\Data\Accounts\Updates;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatedEmailRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdatedEmailController extends Controller
{
    public function update(UpdatedEmailRequest $request)
    {
        return $request->validated();
    }
}
