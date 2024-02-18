<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddJournalRequest extends FormRequest
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
            'date'        => 'required|date|date_format:Y-m-d|before_or_equal:today',
            'description' => 'nullable|string',
            'journals' => 'required|array',
            'account_helper_id'  => 'nullable|string',

            'journals.*.amount'      => 'required|numeric',
            'journals.*.account_id'  => 'required|string',
            'journals.*.type'        => 'required|in:D,C',
            'journals.*.division_id' => 'nullable|string',
        ];
    }
}
