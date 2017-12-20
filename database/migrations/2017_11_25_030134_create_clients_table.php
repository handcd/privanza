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
            // Datos Primarios
            $table->string('name');
            $table->string('lastname');
            $table->string('phone')->nullable();
            $table->string('email');
            $table->string('address_visit');
            $table->string('address_delivery')->nullable();
            $table->date('birthday');
            $table->string('notes')->nullable();
            // Datos Facturación
            $table->string('address_legal')->nullable();
            $table->string('rfc')->nullable();
            $table->string('bank')->nullable();
            $table->string('account_digits')->nullable();
            $table->string('concept')->nullable();
            // Datos Saco
            $table->integer('fit_saco');
            $table->integer('talla_saco');
            $table->integer('corte_saco');
            $table->float('largo_manga');
            $table->float('largo_espalda');
            $table->string('notas_saco');
            // Datos Pantalón
            $table->integer('fit_pantalon');
            $table->integer('talla_pantalon');
            $table->float('largo_pantalon_ext');
            $table->float('largo_pantalon_int');
            $table->string('notas_pantalon');
            // Datos Chaleco
            $table->integer('fit_chaleco');
            $table->integer('talla_chaleco');
            $table->integer('corte_chaleco');
            $table->float('largo_espalda_chaleco');
            $table->string('notas_chaleco');
            // Datos Generales
            $table->integer('vendedor_id');
            $table->string('contacto')->nullable();
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
