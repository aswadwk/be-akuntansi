<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class ProfitLossRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            // array of object
            'settings' => ['required', 'array'],
            'settings.*.title' => ['required', 'string', 'max:255'],
            'settings.*.section' => ['required', 'integer', 'min:1'],
            'settings.*.sub_title' => ['nullable', 'string', 'max:255'],
            'settings.*.type' => ['required', 'string', 'max:255'],
            'settings.*.accounts' => ['required', 'array']
        ];
    }
}
