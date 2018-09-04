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

            $table->boolean('pase')->nullable(); // Con pase, Sin Pase
            $table->integer('pliegues')->nullable(); // 0-2
            $table->integer('bolsas_traseras')->nullable();
            $table->integer('tipo_vivo')->nullable(); // 1 Vivo Doble con Ojal, 2 Vivo Sencillo con Ojal
            $table->string('color_ojalera')->nullable();
            $table->boolean('medio_forro_piernas_al_tono')->nullable();
            $table->string('codigo_otro_color_medio_forro')->nullable();
            $table->string('otro_color_medio_forro')->nullable();

            $table->integer('dobladillo')->nullable(); // 1 normal, 2 valenciana
            $table->integer('pretina')->nullable();
            $table->string('color_pretina')->nullable();

            // Datos Pantalón
            $table->integer('fit_id')->nullable();
            $table->integer('talla')->nullable();
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
