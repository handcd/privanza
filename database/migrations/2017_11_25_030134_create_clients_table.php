<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('lastname');
            $table->string('phone')->nullable();
            $table->string('email');
            $table->string('address_visit');
            $table->string('address_delivery');
            $table->string('address_legal');
            $table->string('rfc');
            $table->string('bank');
            $table->date('birthday');
            $table->string('notes');
            $table->string('account_digits');
            $table->string('concept');
            $table->integer('fit_saco');
            $table->integer('fit_pantalon');
            $table->integer('talla_saco');
            $table->integer('corte_saco');
            $table->float('largo_manga');
            $table->float('largo_espalda');
            $table->string('notas_saco');
            $table->string('notas_pantalon');
            $table->integer('talla_pantalon');
            $table->float('largo_pantalon_ext');
            $table->float('largo_pantalon_int');
            $table->integer('vendedor_id');
            $table->string('contacto');
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
        Schema::dropIfExists('clients');
    }
}
