<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetJournalRequest extends FormRequest
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
            'user_id' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'page' => 'nullable|integer',
            'limit' => 'nullable|integer',
            'sort' => 'nullable|string',
            'order' => 'nullable|string',
            'search' => 'nullable|string',
            'account_id' => 'nullable|string',
            'division_id' => 'nullable|string',
            'partner_id' => 'nullable|string',
        ];
    }
}
