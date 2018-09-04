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
            $table->string('notes',1000)->nullable();
            // Datos Facturación
            $table->string('address_legal')->nullable();
            $table->string('rfc')->nullable();
            $table->string('bank')->nullable();
            $table->string('account_digits')->nullable();
            $table->string('concept',1000)->nullable();
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
