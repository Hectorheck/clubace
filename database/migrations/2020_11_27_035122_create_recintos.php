<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecintos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recintos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clubes_id')->nullable();
            $table->unsignedBigInteger('servicios_id')->nullable();
            $table->string('codigo', 45);
            $table->string('nombre', 45);
            // $table->integer('valor');
            $table->integer('tipo');
            $table->string('observaciones_publicas', 250);
            $table->string('observaciones_privadas', 250);
            $table->string('agno_construccion', 4);
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
        Schema::dropIfExists('recintos');
    }
}
