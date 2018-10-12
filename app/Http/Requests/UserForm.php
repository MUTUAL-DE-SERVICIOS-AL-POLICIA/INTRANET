<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
			'new_password' => 'required|min:5|max:255',
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
			'new_password.required' => 'La nueva contraseña no puede estar vacía',
			'min' => 'El número mínimo de caracteres es 5',
			'max' => 'El número máximo de caracteres es 255',
		];
	}
}
