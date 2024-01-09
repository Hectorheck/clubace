<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
	/**
	 * Validate and update the given user's profile information.
	 *
	 * @param  mixed  $user
	 * @param  array  $input
	 * @return void
	 */
	public function update($user, array $input)
	{
		Validator::make($input, [
			'nombres' => ['required', 'string', 'max:255'],
			'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
			'photo' => ['nullable', 'image', 'max:1024'],
			'ciudad' => ['nullable', 'string', 'max:255'],
			'apellido_paterno' => ['nullable', 'string', 'max:255'],
			'apellido_materno' => ['nullable', 'string', 'max:255'],
			'rut' => ['nullable', 'string', 'max:11', 'unique:users,rut,'.auth()->user()->id],
		])->validate();
		// ])->validateWithBag('updateProfileInformation');

		if (isset($input['photo'])) {
			$user->updateProfilePhoto($input['photo']);
		}

		if ($input['email'] !== $user->email &&
			$user instanceof MustVerifyEmail) {
			$this->updateVerifiedUser($user, $input);
		} else {
			$user->forceFill([
				'nombres' => $input['nombres'],
				'email' => $input['email'],
				'ciudad' => $input['ciudad'] ?? null,
				'apellido_paterno' => $input['apellido_paterno'] ?? null,
				'apellido_materno' => $input['apellido_materno'] ?? null,
				'rut' => $input['rut'] ?? null,
			])->save();
		}
	}

	/**
	 * Update the given verified user's profile information.
	 *
	 * @param  mixed  $user
	 * @param  array  $input
	 * @return void
	 */
	protected function updateVerifiedUser($user, array $input)
	{
		$user->forceFill([
			'name' => $input['name'],
			'email' => $input['email'],
			'email_verified_at' => null,
		])->save();

		$user->sendEmailVerificationNotification();
	}
}
