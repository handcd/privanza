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
            $table->decimal('precio',15,2)->nullable();
            // Contenido de Orden
            $table->boolean('vest')->default(0);
            $table->boolean('coat')->default(0);
            $table->boolean('pants')->default(0);
            // Status General de Orden
            $table->boolean('approved')->default(0);
            $table->dateTime('date_approved')->nullable();
            $table->boolean('production')->default(0);
            $table->dateTime('date_production')->nullable();
            $table->boolean('pickup')->default(0);
            $table->dateTime('date_pickup')->nullable();
            $table->boolean('delivered')->default(0);
            $table->dateTime('date_delivered')->nullable();
            $table->boolean('facturado')->default(0);
            $table->dateTime('date_facturado')->nullable();
            $table->boolean('cobrado')->default(0);
            $table->dateTime('date_cobrado')->nullable();
            // Status en Producción
            $table->boolean('corte')->default(0);
            $table->dateTime('date_corte')->nullable();
            $table->boolean('ensamble')->default(0);
            $table->dateTime('date_ensamble')->nullable();
            $table->boolean('plancha')->default(0);
            $table->dateTime('date_plancha')->nullable();
            $table->boolean('revision')->default(0);
            $table->dateTime('date_revision')->nullable();
            // Etiquetado y Empaque
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
            $table->string('marca_en_etiqueta')->nullable();
            $table->integer('gancho'); // Normal/Personalizado
            $table->string('gancho_personalizacion')->nullable();
            $table->integer('portatrajes'); // Cubrepolvos/Personalizado
            $table->string('portatrajes_personalizacion')->nullable();
            $table->string('notas_tela')->nullable();
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
