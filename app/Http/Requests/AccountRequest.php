<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'code'            => 'required|string|min:3',
            'name'            => 'required|string|min:3',
            'opening_balance'         => 'nullable|numeric',
            'position_normal' => 'required|string|in:D,C',
            'description'     => 'nullable|min:3|string',
            'account_type_id' => 'required|string|exists:account_types,id',
            'user_id'         => 'required|string',
        ];
    }
}
