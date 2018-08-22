<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');

            $table->boolean('pase'); // Con pase, Sin Pase
            $table->integer('pliegues'); // 0-2
            $table->integer('bolsas_traseras');
            $table->integer('tipo_vivo'); // 1 Vivo Doble con Ojal, 2 Vivo Sencillo con Ojal
            $table->string('color_ojalera');
            $table->boolean('medio_forro_piernas_al_tono');
            $table->string('codigo_otro_color_medio_forro')->nullable();
            $table->string('otro_color_medio_forro')->nullable();

            $table->integer('dobladillo'); // 1 normal, 2 valenciana
            $table->integer('pretina');
            $table->string('color_pretina');

            // Datos Pantalón
            $table->integer('fit_id');
            $table->integer('talla');
            $table->string('notas')->nullable();

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
        Schema::dropIfExists('pants');
    }
}
