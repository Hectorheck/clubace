<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Recintos;
use App\Models\Servicios;
use App\Models\Agenda;
use DateTime;
use Mail;

use App\Traits\MultiClases;
use Illuminate\Support\Facades\Mail as FacadesMail;

class CargaHorarios extends Command
{
	use MultiClases;
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'carga:horarios';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Carga horarios del mes';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		// return 0;
		$servicios = Servicios::all();
		foreach ($servicios as $key => $serv) {
			$recintos = Recintos::where('servicios_id', $serv->id)->get();
			foreach ($recintos as $key => $recinto) {
				$dias = explode(',', $recinto->dias_atencion);
				$days = $this->dias_semana($dias);
				$primero = new DateTime();
				$primero->modify('first day of this month');
				/* $primero->modify('first day of 3 month'); */
				$ultimo = new DateTime();
				/* $ultimo->modify('last day of next month'); */
				$ultimo->modify('+ 6 months');
				/* $ultimo->modify('last day of this month'); */

				$inicio = date_create($primero->format('Y-m-d').' '.$recinto->hora_inicio);
				$final = date_create($ultimo->format('Y-m-d').' '.$recinto->hora_fin);

				/* $primeroY = date_create($primero->format('Y'));
				$ultimoY = date_create($ultimo->format('Y'));
				

				if($primeroY == $ultimoY) {
					$inicio = date_create(date('Y').'-'.$primero->format('m-d').' '.$recinto->hora_inicio);
					$final = date_create(date('Y').'-'.$ultimo->format('m-d').' '.$recinto->hora_fin);
				}else{
					$inicio = date_create(date('Y').'-'.$primero->format('m-d').' '.$recinto->hora_inicio);
					$final = date_create(date('Y', strtotime('+1 year')).'-'.$ultimo->format('m-d').' '.$recinto->hora_fin);
				} */


				while ($inicio < $final) {
					$agenda = null;
					if ($inicio->format('H:i:s') >= $recinto->hora_inicio && $inicio->format('H:i:s') < $recinto->hora_fin && in_array($inicio->format('l'), $days)) {
						$agenda = Agenda::firstOrCreate([
							'agno' => $inicio->format('Y'),
							'mes' => $inicio->format('m'),
							'dia' => $inicio->format('d'),
							'fecha' => $inicio->format('Y-m-d'),
							'hora_inicio_bloque' => $inicio->format('H:i:s'),
							'recintos_id' => $recinto->id,
						],[
							'estado' => 'Disponible',
						]);
						/* $out = new \Symfony\Component\Console\Output\ConsoleOutput();
						$out->writeln($agenda); */
					}
					$inicio->modify($recinto->bloque_horario);
					if (!is_null($agenda)) {
						Agenda::find($agenda->id)->update(['hora_fin_bloque' => $inicio->format('H:i:s')]);
					}
					
				}
			}
		}
		$mail = Mail::raw('Se termino de ejecutar el CRON '.date('d-m-Y H:i:s'), function ($message) {
			$message->from('no-reply@aceclub.cl', 'Aceclub');
			// $message->sender('john@johndoe.com', 'John Doe');
			$message->to('erebolledos@gmail.com', 'Esteban');
			// $message->cc('john@johndoe.com', 'John Doe');
			// $message->bcc('john@johndoe.com', 'John Doe');
			// $message->replyTo('john@johndoe.com', 'John Doe');
			$message->subject('Se ha ejecutado el CRON');
			// $message->priority(3);
			// $message->attach('pathToFile');
		});
	}
}
