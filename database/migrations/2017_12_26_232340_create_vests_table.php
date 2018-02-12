<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vests', function (Blueprint $table) {
            // Main data
            $table->increments('id');
            $table->integer('order_id');

            // Clothing data
            $table->integer('tipo_cuello'); // 1 En V/2 Con Solapa
            $table->integer('tipo_bolsas')->nullable(); // 0 Vivo/1 Aletilla
            $table->integer('tipo_espalda'); // 1 Forro/ 2 Tela
            $table->boolean('ajustador_espalda');
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
        Schema::dropIfExists('vests');
    }
}
