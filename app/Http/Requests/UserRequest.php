<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
        return match($this->method()){
            'POST' => [
                'name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
                'last_name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
                'sex' => 'required|string|max:1|regex:([M or F or I]+)',
                'email' => 'required|string|email|max:255|unique:users,email',
                'age' => 'required|numeric|max:120',
                'password' => ['required',Password::defaults()->min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
                'password_confirmation' => 'required|same:password'               
            ]
        };
        
        
        
        /*[
            'name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
            'last_name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
            'sex' => 'required|string|max:1|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
            'email' => 'required|string|email|max:255|unique:users,email',
            'age' => 'required|numeric|max:120',
            'password' => ['required',Password::defaults()->min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
            'password_confirmation' => 'required|same:password'
        ];*/
    }
}
