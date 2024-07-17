<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

final class UserRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
        $rules = [
            'name' => 'required|string|max:50|regex:/^[\pL\s\-]+$/u',
            'last_name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
            'sex' => 'required|string|max:1|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
            'age' => 'required|numeric|max:120',
            'countrie_id' => 'required',
        ];

        if ($this->isMethod('POST')) {
            $rules = array_merge($rules, [
                'email' => 'required|string|email|max:255|unique:users,email',
                'username' => 'required|string|regex:/^[\pL\s\-]+$/u|unique:users,username',
                'password' => [
                    'required',
                    Password::defaults()->min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(),
                ],
                'password_confirmation' => 'required|same:password',
            ]);
        }

        if ($this->isMethod('PUT') && !$this->filled('password')) {
            $rules = array_merge($rules, [
                'password' => [
                    'required',
                    Password::defaults()->min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(),
                ],
                'password_confirmation' => 'required|same:password',
            ]);
        }

        return $rules;
	}
}
