<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransbankToClubes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clubes', function (Blueprint $table) {
            $table->boolean('estado_transbank')->default(0);
            $table->string('codigo_comercio_transbank', 12)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clubes', function (Blueprint $table) {
            $table->dropColumn('estado_transbank');
            $table->dropColumn('codigo_comercio_transbank');
        });
    }
}
