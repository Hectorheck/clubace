<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

use Illuminate\Http\UploadedFile;
use Storage;

use App\Notifications\CustomResetPassNotification;
use App\Notifications\VerifyApiEmail;

class User extends Authenticatable implements MustVerifyEmail
{
	use HasApiTokens;
	use HasFactory;
	use HasProfilePhoto;
	use Notifiable;
	use TwoFactorAuthenticatable;
	use SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'rut',
		'nombres',
		'apellido_paterno',
		'apellido_materno',
		'tipo_usuarios_id',
		'fecha_nacimiento',
		'direccion',
		'ciudad',
		'telefono',
		'email',
		'password',
		'terminos',
		'fecha_termino',
		'profile_photo_path',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
		'two_factor_recovery_codes',
		'two_factor_secret',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	/**
	 * The accessors to append to the model's array form.
	 *
	 * @var array
	 */
	protected $appends = ['profile_photo_url','full_name','fecha_ch'];

	/**
	 * Send the password reset notification.
	 *
	 * @param  string  $token
	 * @return void
	 * OVERRIDE sobreescritura del metodo en el modelo
	 */
	public function sendPasswordResetNotification($token)
	{
		// $this->notify(new ResetPasswordNotification($token));
		$this->notify(new CustomResetPassNotification($token));
	}
	/* OVERRIDE de metodo para subir foto, ahora en el modelo */
	public function updateProfilePhoto(UploadedFile $photo)
	{
		tap($this->profile_photo_path, function ($previous) use ($photo) {
			$this->forceFill([
				'profile_photo_path' => $photo->storePublicly(
					'avatars', ['disk' => $this->profilePhotoDisk()]
				),
			])->save();

			if ($previous) {
				Storage::disk($this->profilePhotoDisk())->delete($previous);
			}
		});
	}
	public function sendApiEmailVerificationNotification()
	{
		$this->notify(new VerifyApiEmail); // my notification
	}
	public function getFullNameAttribute ()
	{
		/* ########## RETORNAR NOMBRE COMPLETO ########## */
		$nombres = $this->nombres;
		$apellido_paterno = $this->apellido_paterno;
		$apellido_materno = $this->apellido_materno;
		$fullname = "$nombres $apellido_paterno $apellido_materno";
		return $fullname;
	}
	public function getFechaChAttribute ()
	{
		/* ########## RETORNAR FECHA FORMATO CHILENO DD-MM-YYYY ########## */
		$fecha_inicial = $this->fecha_nacimiento;
		$fecha_formato = null;
		if (is_null($fecha_inicial)) {
			return $fecha_formato;
		}
		$fecha_formato = date('d/m/Y', strtotime($fecha_inicial));
		return $fecha_formato;
	}
	public function tipo_usuarios ()
	{
		return $this->belongsTo('App\Models\TipoUsers');
	}
	public function comunas ()
	{
		return $this->belongsTo('App\Models\Comunas');
	}
	public function clubes ()
	{
		return $this->hasMany('App\Models\UsersClubes', 'users_id');
	}
	public function reservas ()
	{
		return $this->hasMany(Reservas::class, 'users_id');
	}
	public function user_convenios ()
	{
		return $this->hasMany(UserConvenios::class, 'users_id');
	}
	public function getTipos ()
	{
		/*
		 * 
		 * Cargara si es admin de algun club, si es tipo 2 en alguna relacion con algun club
		 * 
		*/
		$tipos = new Collection();
		foreach ($this->clubes as $key => $value) {
			$tipos = $tipos->push($value);
		}
		return $tipos;
	}
	public function getClubes ()
	{
		/*
		// Solo cargara la lista de clubes en los que el usuario sea tipo admin o super admin.
		*/
		$clubes = new Collection();
		foreach ($this->clubes->whereIn('tipo_usuarios_id',[3,2,1,5,7]) as $key => $userclub) {
			$clubes = $clubes->push($userclub->clubes);
		}
		return $clubes;
	}
	public function getServicios ()
	{
		$servicios = new Collection();
		$clubes = $this->getClubes();
		foreach ($clubes as $key => $club) {
			$servicios = $servicios->merge($club->servicios);
		}
		return $servicios;
	}
	public function getRecintos ()
	{
		$recintos = new Collection();
		$servicios = $this->getServicios();
		foreach ($servicios as $key => $servicio) {
			$recintos = $recintos->merge($servicio->recintos);
		}
		return $recintos;
	}
	public function checkAdmin ()
	{
		$check = $this->clubes->whereIn('tipo_usuarios_id',[2,1]);
		return (count($check) > 0) ? true : false;
	}

}
