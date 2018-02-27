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
            $table->integer('tipo_solapa'); // 0 pico/1escuadra
            $table->integer('tipo_ojal_solapa'); // 0 al tono/1en contraste/2activo
            $table->string('color_ojal_solapa');
            $table->integer('botones_frente'); // 1,2,3,6
            $table->integer('aberturas_detras'); // 0,1,2
            $table->integer('botones_mangas'); // 0-4
            $table->integer('tipo_ojal_manga'); // al tono/en contraste/activos
            $table->string('color_ojal_manga');
            $table->integer('posicion_ojal_manga'); // 0 Cascada, 1 en línea
            $table->boolean('ojales_activos_manga');
            
            /*
                0) Parche
                1) Cartera
                2) Cartera en Diagonal
                3) Vivo (sin cartera)
                4) Vivo Diagonal
                5) Cartera Continental
                6) Cartera Continental Diagonal
                7) Sin Bolsas
            */
            $table->integer('tipo_bolsas_ext');
            $table->boolean('pickstitch');
            $table->boolean('pickstitch_filos');
            $table->boolean('pickstitch_aletillla');
            $table->boolean('pickstitch_cartera');
            $table->boolean('sin_aletilla');

            // Saco - Interno
            $table->integer('tipo_vista'); // 0 normal / 1 chapeta francesa
            $table->boolean('balsam_rayas');
            $table->string('forro_interno_mangas');
            $table->boolean('intern_pin_point');
            $table->string('pin_point_interno_color')->nullable();
            $table->string('pin_point_interno_codigo')->nullable();
            $table->boolean('bies');
            $table->string('bies_color')->nullable();
            $table->string('bies_codigo')->nullable();
            $table->string('puntada_color');
            $table->integer('bolsas_int'); // 0 ,1,2,3
            $table->string('bolsa_int_color')->nullable();
            $table->boolean('vivos_bolsas_internas_cuerpo');
            $table->string('otro_vivos_bolsas_internas');
            $table->boolean('puntada_filos');
            $table->boolean('puntada_aletillas');
            $table->boolean('puntada_carteras');
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
