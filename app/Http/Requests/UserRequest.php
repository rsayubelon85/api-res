<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

final class UserRequest extends FormRequest
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
		$rules['name'] = 'required|string|max:50|regex:/^[\pL\s\-]+$/u';
		$rules['last_name'] = 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)';
		$rules['sex'] = 'required|string|max:1|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)';
		$rules['age'] = 'required|numeric|max:120';

		if ($this->isMethod('POST')) {
			$rules['email'] = 'required|string|email|max:255|unique:users,email';
			$rules['username'] = 'required|string|regex:/^[\pL\s\-]+$/u|unique:users,username';
			$rules['password'] = [
				'required',
				Password::defaults()->min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(),
			];
			$rules['password_confirmation'] = 'required|same:password';
			$rules['telephone'] = 'required|numeric|min:50000000|max:59999999|unique:users,telephone';
		}

		if ($this->isMethod('PUT')) {
			$rules['telephone'] = 'required|numeric|min:50000000|max:59999999|unique:users,telephone,' . app(
				'request'
			)->segment(
				2
			);
			if ($this->request->get('password') !== null) {
				$rules['password'] = [
					'required',
					Password::defaults()->min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(),
				];
				$rules['password_confirmation'] = 'required|same:password';
			}
		}

		return $rules;
	}
}
