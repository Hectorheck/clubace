<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clubes_id');
            $table->string('nombre');
            $table->integer('valor');
            $table->boolean('socios')->nullable();
            $table->boolean('arriendo')->nullable();
            $table->string('bloque_horario');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios');
    }
}
