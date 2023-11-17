<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => [
                'required',
                'max:20',
                'regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
            ],
        ];

        if ($this->isMethod('PUT')) {
            $rules['name'][] = Rule::unique('roles', 'name')->ignore(app('request')->segment(2));
        }

        if ($this->isMethod('POST')) {
            $rules['name'][4] = 'unique:roles,name';
        }

        return $rules;
    }
}
