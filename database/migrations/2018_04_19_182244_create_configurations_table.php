<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->integer('horas_aviso_no_aprobada')->default(22);
            $table->integer('horas_aviso_aprobada')->default(22);
            $table->integer('horas_aviso_produccion')->default(22);
            $table->integer('horas_aviso_produccion_corte')->default(22);
            $table->integer('horas_aviso_produccion_ensamble')->default(22);
            $table->integer('horas_aviso_produccion_plancha')->default(22);
            $table->integer('horas_aviso_produccion_revision')->default(22);
            $table->integer('horas_aviso_pickup')->default(22);
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
        Schema::dropIfExists('configurations');
    }
}
