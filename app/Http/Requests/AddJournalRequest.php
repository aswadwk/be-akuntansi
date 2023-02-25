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
            'journals' => 'required|array',

            'journals.*.date'        => 'required|date',
            'journals.*.debet'       => 'required|numeric',
            'journals.*.credit'      => 'required|numeric',
            'journals.*.account_id'  => 'required|string|exists:accounts,id',
            'journals.*.type'        => 'required|in:D,C',
            'journals.*.division_id' => 'nullable|string',
            'journals.*.partner_id'  => 'nullable|string',
            'journals.*.description' => 'nullable|string',
        ];
    }
}
