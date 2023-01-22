<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JournalRequest extends FormRequest
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

            '*.code' => 'nullable|string',

            '*.date' => 'required|date',

            '*.type' => 'required|in:D,C',

            '*.amount' => 'required|numeric',

            '*.account_id' => 'required|string',

            '*.division_id' => 'nullable|string',

            '*.partner_id' => 'nullable|string',

            '*.transaction_id' => 'nullable|string',

            '*.description' => 'nullable|string',
            // 'user_id' => 'nullable|string',
        ];
    }
}
