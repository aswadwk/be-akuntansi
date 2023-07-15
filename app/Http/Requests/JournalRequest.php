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
            'journals.*.date' => 'required|date',
            'journals.*.amount' => 'required|numeric',
            'journals.*.account_id' => 'required|integer',
            'journals.*.description' => 'required|string',
            'journals.*.type' => 'required|string',
            'journals.*.division_id' => 'nullable|integer',
            'journals.*.partner_id' => 'nullable|integer',
        ];
    }
}
