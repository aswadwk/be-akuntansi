<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountTypeSearchRequest extends FormRequest
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
            'all' => 'nullable|boolean',
            'name' => 'nullable|string',
            'code' => 'nullable|min:3',
            'per_page' => 'nullable|integer',
            'page' => 'nullable|integer',
        ];
    }
}
