<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserForm extends FormRequest
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
	 * @return array
	 */
	public function rules()
	{
		$this->sanitize();
		return [
			'username' => 'required|min:4|max:255',
			'old_password' => 'required|min:4|max:255',
			'new_password' =>[
				'required',
				'string',
				'min:8',
				'regex:/[a-z]/',
				'regex:/[A-Z]/',
				'regex:/[0-9]/',
				'regex:/[@$!%*+-?&#=]/',
				'not_regex:/password|12345678|abcd|qwerty/',
			],
		];
	}

	public function sanitize()
	{
		$input = $this->all();

		$input['username'] = strtolower($input['username']);

		$this->replace($input);
	}

	public function messages()
	{
		return [
			'username.required' => 'El usuario no puede estar vacío',
			'old_password.required' => 'La contraseña no puede estar vacía',
			'new_password.required' => 'La contraseña es obligatoria.',
			'new_password.string' => 'La contraseña debe ser una cadena de texto.',
			'new_password.min' => 'La contraseña debe tener al menos 8 caracteres.',
			'new_password.regex' => 'La contraseña debe contener al menos una letra minúscula, una letra mayúscula, un número y un carácter especial.',
			'new_password.not_regex' => 'La contraseña no debe ser una de las contraseñas comunes.',
			'min' => 'El número mínimo de caracteres es 5',
			'max' => 'El número máximo de caracteres es 255',
		];
	}
}
