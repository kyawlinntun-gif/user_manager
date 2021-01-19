<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|regex:/[a-zA-z]/',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'password' => [
                'required',
                'string',
                'min:10',
                'regex:/[a-zA-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!#%^&*]/'
            ],
            'confirm_password' => 'required|same:password'
        ];
    }
}
