<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConfigDefault;

class VarDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConfigDefault::create([
            "Nombre" => "Tiempo",
            "Descripcion" => "Tiempo reserva para hacer el pago",
            "TipoVariable" => "int",
            "ValorDefault" => "3",
        ]);
        ConfigDefault::create([
            "Nombre" => "Confirmacion",
            "Descripcion" => "Confirmar asistencia en el club",
            "TipoVariable" => "bool",
            "ValorDefault" => "Si",
        ]);
    }
}
