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
             //Medidas del cliente 
            $table->float('altura')->nullable();
            $table->float('peso')->nullable();
            $table->integer('edad')->nullable();
            $table->integer('hombros')->nullable(); // 0 rectos, 1 normales
            $table->integer('abdomen')->nullable(); // 0 delgado, 1 normal, 2 voluminoso
            $table->integer('pecho')->nullable(); //0 musculoso, 1 normal, 2 curpulento
            $table->integer('espalda')->nullable(); //0 recta, 1 normal, 2 encorvada
            $table->float('contornoCuello')->nullable();
            $table->float('contornoBiceps')->nullable();
            $table->float('medidaHombros')->nullable();
            $table->float('brazoDerecho')->nullable();
            $table->float('brazoIzquierdo')->nullable();
            $table->float('hombroDerecho')->nullable();
            $table->float('hombroIzquierdo')->nullable();
            $table->float('anchoEspalda')->nullable();
            $table->float('largoTorso')->nullable();
            $table->float('contornoPecho')->nullable();
            $table->float('punio')->nullable();
            $table->float('contornoAbdomen')->nullable();
            $table->float('contornoCintura')->nullable();
            $table->float('contornoCadera')->nullable();
            $table->float('largoTiro')->nullable();
            $table->float('largoInternoPantalon')->nullable();
            $table->float('largoExternoPantalon')->nullable();
            $table->float('contornoMuslo')->nullable();
            $table->float('contornoRodilla')->nullable();
            //Fecha de creación y modificación
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
