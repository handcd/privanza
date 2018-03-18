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
            $table->integer('tipo_ojal_solapa'); // 0 Sin Ojal / 1 Al Tono / 2 En Contraste
            $table->boolean('ojal_activo_solapa');
            $table->string('color_ojal_solapa');
            $table->integer('botones_frente'); // 1,2,3,6
            $table->integer('aberturas_detras'); // 0,1,2
            $table->integer('botones_mangas'); // 0-4
            $table->integer('tipo_ojal_manga'); // al tono/en contraste/activos
            $table->string('color_ojal_manga');
            $table->integer('posicion_ojal_manga'); // 0 Cascada, 1 en línea
            $table->boolean('ojales_activos_manga');
            $table->integer('posicion_ojales_activos_manga')->nullable(); // 0 Todos los Ojales / 1 3º y 4º / 2 4º
            
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
            $table->boolean('sin_aletilla');

            // Saco - Interno
            $table->integer('tipo_vista'); // 0 normal / 1 chapeta francesa
            $table->boolean('balsam_rayas');
            $table->string('forro_interno_mangas');
            $table->boolean('pin_point_interno');
            $table->string('pin_point_interno_color')->nullable();
            $table->string('pin_point_interno_codigo')->nullable();
            $table->boolean('bies');
            $table->string('bies_color')->nullable();
            $table->string('bies_codigo')->nullable();
            $table->string('puntada_color');
            $table->integer('bolsas_int'); // 0 ,1,2,3
            $table->boolean('vivos_bolsas_internas_cuerpo');
            $table->string('otro_vivos_bolsas_internas')->nullable();
            $table->boolean('puntada_filos');
            $table->boolean('puntada_aletillas');
            $table->boolean('puntada_carteras');

            // Datos Saco
            $table->integer('fit_id');
            $table->integer('talla');
            $table->integer('corte');
            $table->float('largo_manga');
            $table->float('largo_espalda');
            $table->string('notas_int')->nullable();
            $table->string('notas_ext')->nullable();

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
