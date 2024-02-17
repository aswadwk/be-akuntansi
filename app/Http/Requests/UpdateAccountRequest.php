<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
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
            'code' => 'nullable|string',
            'name' => 'nullable|string',
            'opening_balance' => 'nullable|numeric',
            'position_normal' => 'nullable|string|in:D,C',
            'account_type_id' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }
}
