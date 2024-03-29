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

            // Datos Chaleco
            $table->integer('fit_id')->nullable();
            $table->string('talla')->nullable();

            $table->string('notas',1000)->nullable();

            // Clothing data
            $table->integer('tipo_cuello')->nullable(); // 1 En V/2 Con Solapa
            $table->integer('tipo_bolsas')->nullable(); // 0 Vivo/1 Aletilla
            $table->integer('tipo_espalda')->nullable(); // 1 Forro/ 2 Tela
            $table->string('tipo_forro')->nullable(); 
            $table->double('personalizacion_holgura_chaleco')->nullable();
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
