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
            $table->integer('client_id');
            $table->string('consecutivo_ajuste');
            $table->string('consecutivo_op')->nullable();
            $table->integer('status')->default(0); // 0 Unapproved, 1 Approved, 2 Finished
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
