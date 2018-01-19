<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            // Saco - Externo
            $table->integer('botones_frente'); // 1,2,3,6
            $table->integer('aberturas_detras'); // 0,1,2
            $table->integer('tipo_solapa'); // 0pico/1escuadra
            $table->integer('tam_solapa'); // 0normal/1ancha
            $table->integer('botones_mangas'); // 0-4
            $table->integer('tipo_ojal_solapa'); // 0al tono/1en contraste/2activo
            $table->string('color_ojal_solapa')->nullable();
            $table->integer('tipo_ojal_manga'); // al tono/en contraste/activos
            $table->string('color_ojal_manga')->nullable();
            $table->string('posicion_ojal_manga')->nullable();
            $table->integer('ojales_activos_manga'); // 1-4
            $table->boolean('saco_bolsas_ext_carteras'); // 0con carteras/1sin carteras
            $table->boolean('pick_stitch');
            // Saco - Interno
            $table->integer('tipo_vista'); // normal/chapeta francesa
            $table->boolean('pin_point');
            $table->string('color_pin_point')->nullable();
            $table->string('codigo_pin_point')->nullable();
            $table->boolean('bies');
            $table->string('color_bies')->nullable();
            $table->string('codigo_bies')->nullable();
            $table->boolean('bolsa_p_der');
            $table->boolean('bolsa_p_izq');
            $table->boolean('bolsa_cig');
            $table->boolean('bolsa_plum');
            $table->string('bolsa_int_color')->nullable();         
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
        Schema::dropIfExists('coats');
    }
}
