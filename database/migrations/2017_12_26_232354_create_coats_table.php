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
            $table->integer('tipo_solapa'); // 0pico/1escuadra
            $table->integer('tipo_ojal_solapa'); // 0al tono/1en contraste/2activo
            $table->string('color_ojal_solapa');
            $table->integer('botones_frente'); // 1,2,3,6
            $table->integer('aberturas_detras'); // 0,1,2
            $table->integer('botones_mangas'); // 0-4
            $table->integer('tipo_ojal_manga'); // al tono/en contraste/activos
            $table->string('color_ojal_manga');
            $table->integer('posicion_ojal_manga'); // 0 Cascada, 1 en línea
            $table->boolean('ojales_activos_manga'); 
            $table->boolean('bolsa_parche');
            $table->boolean('bolsa_cartera');
            $table->boolean('bolsa_cartera_diagonal');
            $table->boolean('bolsa_vivo');
            $table->boolean('bolsa_vivo_diagonal');
            $table->boolean('bolsa_cartera_continental');
            $table->boolean('bolsa_cartera_continental_diagonal');
            $table->boolean('sin_bolsas');
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
            $table->string('pin_point_interno_color');
            $table->string('pin_point_interno_codigo');
            $table->boolean('bies');
            $table->string('color_bies');
            $table->string('codigo_bies');
            $table->string('puntada_color');
            $table->boolean('bolsa_interna_pecho_derecho');
            $table->boolean('bolsa_interna_pecho_izquierdo');
            $table->boolean('bolsa_interna_cigarrera');
            $table->boolean('bolsa_interna_plumera');
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
