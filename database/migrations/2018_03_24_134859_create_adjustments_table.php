<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjustments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('adjustment_order_id');
            $table->datetime('promesa_planta');
            $table->datetime('promesa_cliente');
            $table->decimal('precio',15,2)->nullable();
            $table->integer('num_prendas');
            $table->string('descripcion',1000)->nullable();
            $table->string('tipo_prenda');
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
        Schema::dropIfExists('adjustments');
    }
}
