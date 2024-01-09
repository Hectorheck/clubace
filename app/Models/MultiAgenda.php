<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;
use Illuminate\Support\Collection;

class MultiAgenda extends Model
{
	use HasFactory;
	protected $guarded = [];
	protected $table = "multi_agendas";
	protected $appends = ['agendas'];
	public function getAgendasAttribute ()
	{
		$agenda = new Collection();
		$data = MultiAgenda::find($this->id);
		$inicio = new DateTime($data->fecha_inicio);
		$fin = new DateTime($data->fecha_termino);
		$var = (explode(',', $data->dias));
		while ($inicio <= $fin) {
			if (in_array($inicio->format('N'), $var)) {
				$result = Agenda::where('fecha',$inicio->format('Y-m-d'))
					->where('recintos_id',$data->recintos_id)
					->where('hora_inicio_bloque','>=',$data->hora_inicio)
					->where('hora_fin_bloque','<=',$data->hora_termino)
					->where('estado','Reservado')
					->whereHas('reserva', function ($query) use ($data) {
						$query->where('users_id', $data->users_id);
					})
					->get();
				$agenda = $agenda->merge($result);
			}
			$inicio->modify("+1 days");
		}
		return $agenda;
	}
	public function users ()
	{
		return $this->belongsTo(User::class);
	}
	public function recintos ()
	{
		return $this->belongsTo(Recintos::class);
	}
}
