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
            $table->integer('tipo_solapa')->nullable(); // 0 pico/1escuadra
            $table->integer('tipo_ojal_solapa')->nullable(); // 1 Al Tono / 2 En Contraste
            $table->boolean('ojal_activo_solapa')->nullable();
            $table->string('color_ojal_solapa')->nullable();
            $table->integer('botones_frente')->nullable(); // 1,2,3,6
            $table->integer('aberturas_detras')->nullable(); // 0,1,2
            $table->integer('botones_mangas')->nullable(); // 0-4
            $table->integer('tipo_ojal_manga')->nullable(); // al tono/en contraste/activos
            $table->string('color_ojal_manga')->nullable();
            $table->integer('posicion_ojal_manga')->nullable(); // 0 Cascada, 1 en línea
            $table->boolean('ojales_activos_manga')->nullable();
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
            $table->integer('tipo_bolsas_ext')->nullable();
            $table->boolean('pickstitch')->nullable();
            $table->boolean('sin_aletilla')->nullable();

            // Saco - Interno
            $table->integer('tipo_vista')->nullable(); // 0 normal / 1 chapeta francesa
            $table->boolean('balsam_rayas')->nullable();
            $table->string('forro_interno_mangas')->nullable();
            $table->boolean('pin_point_interno')->nullable();
            $table->string('pin_point_interno_color')->nullable();
            $table->string('pin_point_interno_codigo')->nullable();
            $table->boolean('bies')->nullable();
            $table->string('bies_color')->nullable();
            $table->string('bies_codigo')->nullable();
            $table->string('color_puntada')->nullable();
            $table->integer('bolsas_int')->nullable(); // 0 ,1,2,3
            $table->boolean('vivos_bolsas_internas_cuerpo')->nullable();
            $table->string('otro_vivos_bolsas_internas')->nullable();
            $table->boolean('puntada_filos')->nullable();
            $table->boolean('puntada_aletillas')->nullable();
            $table->boolean('puntada_carteras')->nullable();

            // Datos Saco
            $table->integer('fit_id')->nullable();
            $table->integer('talla')->nullable();
            $table->integer('corte')->nullable();
            $table->string('notas_int',1000)->nullable();
            $table->string('notas_ext',1000)->nullable();

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
