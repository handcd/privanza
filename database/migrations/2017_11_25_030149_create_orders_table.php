<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->integer('vendedor_id');
            $table->boolean('approved')->default(0);
            $table->boolean('production')->default(0);
            $table->boolean('recoger')->default(0);
            $table->boolean('entregado')->default(0);
            $table->boolean('facturado')->default(0);
            $table->boolean('cobrado')->default(0);
            $table->float('precio')->nullable();
            // Telas y Souvenirs
            $table->boolean('tela_isco');
            $table->string('codigo_tela')->nullable();
            $table->float('mts_tela_cliente')->nullable();
            $table->string('codigo_color_tela_cliente')->nullable();
            $table->boolean('forro_isco');
            $table->string('codigo_forro')->nullable();
            $table->float('mts_forro_cliente')->nullable();
            $table->string('codigo_color_forro_cliente')->nullable();
            $table->string('codigo_botones');
            $table->string('color_botones');
            $table->boolean('etiquetas_tela'); // Si/No
            $table->boolean('etiquetas_marca'); // Si/No
            $table->integer('gancho'); // Normal/Personalizado
            $table->integer('portatrajes'); // Cubrepolvos/Personalizado
            $table->string('notas_tela')->nullable();
            // Saco - Afuera
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
            // Saco - Dentro
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
            // Pantalón
            $table->boolean('pretina_bies');
            $table->string('pretina_bies_color')->nullable();
            $table->boolean('pretina_pin_point');
            $table->string('pretina_pin_point_color')->nullable();
            $table->boolean('pretina_flexon');
            $table->boolean('pretina_snutex');
            $table->boolean('pretina_snutex_bies');
            $table->boolean('pretina_snutex_pin_point');
            $table->boolean('pretina_snutex_sola');
            $table->integer('no_bolsas_delanteras');
            $table->integer('no_bolsas_traseras');
            $table->integer('tipo_vivo'); // sencillo/doble
            $table->integer('tipo_cerrado'); // ojal y botón/traba y botón
            $table->boolean('ribete');
            $table->string('ribete_color')->nullable();
            $table->boolean('medioforno');
            $table->boolean('dobladillo_personalizado');
            $table->integer('tipo_dobladillo_personalizado')->nullable(); // normal/valenciana española
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
        Schema::dropIfExists('orders');
    }
}
