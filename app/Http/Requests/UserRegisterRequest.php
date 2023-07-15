<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'             => 'required|string:min:3',
            'email'            => 'required|email',
            'role_id'          => 'required|exists:roles,id',
            'password'         => 'required|min:8',
            'password_confirm' => 'same:password',
        ];
    }
}
