<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
	use PasswordValidationRules;

	/**
	 * Validate and create a newly registered user.
	 *
	 * @param  array  $input
	 * @return \App\Models\User
	 */
	public function create(array $input)
	{
		Validator::make($input, [
			'nombres' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => $this->passwordRules(),
		],[
			'nombres.required' => 'Debe ingresar su nombre de usuario',
			'email.required' => 'Debe ingresar su email',
			'password.required' => 'Debe ingresar su contraseña',
		])->validate();

		return User::create([
			'nombres' => $input['nombres'],
			'email' => $input['email'],
			'tipo_usuarios_id' => 4,
			'password' => Hash::make($input['password']),
		]);
	}
}
