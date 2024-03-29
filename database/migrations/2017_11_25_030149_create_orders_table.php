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
            $table->integer('tela_id')->nullable();
            $table->integer('forro_id')->nullable();
            $table->string('consecutivo_op')->nullable();
            $table->decimal('precio',15,2)->nullable();
            // Contenido de Orden
            $table->boolean('has_vest')->default(0);
            $table->boolean('has_coat')->default(0);
            $table->boolean('has_pants')->default(0);
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
            //Tela
            $table->boolean('tela_isco')->nullable();
            $table->string('codigo_tela')->nullable();
            $table->string('nombre_tela')->nullable();
            $table->string('codigo_color_tela')->nullable();
            $table->string('color_tela')->nullable();
            $table->float('mts_tela_cliente')->nullable();
            //Forro
            $table->boolean('forro_isco')->nullable();
            $table->string('codigo_forro')->nullable();
            $table->string('nombre_forro')->nullable();            
            $table->string('codigo_color_forro')->nullable();
            $table->string('color_forro')->nullable();            
            $table->float('mts_forro_cliente')->nullable();
            //Botones
            $table->string('tipo_botones')->nullable();
            $table->string('codigo_botones')->nullable();
            $table->string('color_botones')->nullable();
            $table->integer('cantidad_botones')->nullable();
            //Etiquetas
            $table->boolean('etiquetas_tela')->nullable(); // Si/No
            $table->boolean('etiquetas_marca')->nullable(); // Si/No
            $table->string('marca_en_tela')->nullable();
            $table->string('marca_en_etiqueta')->nullable();
            //Gancho
            $table->integer('gancho')->nullable(); // Normal/Personalizado
            $table->string('gancho_personalizacion')->nullable();
            $table->integer('portatrajes')->nullable(); // Cubrepolvos/Personalizado
            $table->string('portatrajes_personalizacion')->nullable();
            $table->string('notas_tela')->nullable();
            //Bordado
            $table->string('bordado')->nullable();
            $table->string('letra')->nullable();
            $table->string('bordadoColor')->nullable();
            $table->string('notasBordado',1000)->nullable();
            //Fecha de creación y de edición
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
