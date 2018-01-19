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
        Schema::dropIfExists('pants');
    }
}
