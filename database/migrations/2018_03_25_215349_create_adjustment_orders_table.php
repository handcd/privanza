<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdjustmentOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjustment_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('consecutivo_ajuste');
            $table->integer('consecutivo_op')->nullable();
            $table->string('datos_cliente')->nullable();
            $table->decimal('precio_general',15,2)->nullable();
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
        Schema::dropIfExists('adjustment_orders');
    }
}
