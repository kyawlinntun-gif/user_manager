<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isAdmin() || Auth::id() === $this->route('id');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
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
