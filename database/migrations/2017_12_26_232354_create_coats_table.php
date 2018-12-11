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
            $table->integer('tipo_solapa')->nullable(); // 0 pico normal| 1 pico ancha | 2 escuadra normal | 3 escuadra ancha
            $table->integer('tipo_ojal_solapa')->nullable(); // 1 Al Tono / 2 En Contraste
            $table->boolean('ojal_activo_solapa')->nullable(); //0 No, 1 Sí
            $table->string('color_ojal_solapa')->nullable();
            $table->integer('botones_frente')->nullable(); // 1,2,3,6
            $table->integer('aberturas_detras')->nullable(); // 0,1,2
            $table->integer('botones_mangas')->nullable(); // 0-4
            $table->integer('tipo_ojal_manga')->nullable(); // al tono/en contraste/activos
            $table->string('color_ojal_manga')->nullable();
            $table->integer('posicion_ojal_manga')->nullable(); // 0 Cascada, 1 en línea
            $table->boolean('ojales_activos_manga')->nullable();
            $table->integer('posicion_ojales_activos_manga')->nullable(); /* 0-> Cuarto | 1-> Tercero y cuarto | 2-> Segundo, tercero y cuarto | 3-> Todos*/
            $table->integer('posicion_ojal_solapa')->nullable(); /* 0-> Primero | 1-> Uno y dos | 2-> uno, dos y tres | 3-> Todos | 4-> cuatro */
            $table->integer('posicion_ojales_contraste')->nullable();
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

            //Accesorios  
            $table->integer('tipo_accesorio')->nullable();
            $table->string('accesorio_color')->nullable();
            $table->string('accesorio_codigo')->nullable();

            //Código en paleta de colores
            $table->string('color_puntada')->nullable();

            $table->integer('bolsas_int')->nullable(); // 0 ,1,2,3
            $table->boolean('vivos_bolsas_internas_cuerpo')->nullable();
            $table->string('otro_vivos_bolsas_internas')->nullable();
            $table->boolean('puntada_filos')->nullable();
            $table->boolean('puntada_aletillas')->nullable();
            $table->boolean('puntada_carteras')->nullable();

            // Datos Saco
            $table->integer('fit_id')->nullable();
            $table->double('talla')->nullable();
            $table->double('largo_espalda_deseado')->nullable();

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
