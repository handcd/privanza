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
            // ID
            $table->increments('id');
            // Tiempos de aviso entre acciones
            $table->integer('horas_aviso_no_aprobada')->default(22);
            $table->integer('horas_aviso_aprobada')->default(22);
            $table->integer('horas_aviso_produccion')->default(22);
            $table->integer('horas_aviso_produccion_corte')->default(22);
            $table->integer('horas_aviso_produccion_ensamble')->default(22);
            $table->integer('horas_aviso_produccion_plancha')->default(22);
            $table->integer('horas_aviso_produccion_revision')->default(22);
            $table->integer('horas_aviso_pickup')->default(22);

            // Activar/Desactivar Notificaciones
            // Admin
            $table->boolean('notificar_admin_nueva_orden')->default(1);
            $table->boolean('notificar_admin_cambio_orden')->default(1);
            $table->boolean('notificar_admin_nueva_cita')->default(1);
            $table->boolean('notificar_admin_cambio_cita')->default(1);
            $table->boolean('notificar_admin_nuevo_ajuste')->default(1);
            $table->boolean('notificar_admin_cambio_ajuste')->default(1);
            $table->boolean('notificar_admin_nuevo_vendedor')->default(1);
            $table->boolean('notificar_admin_cambio_vendedor')->default(1);
            $table->boolean('notificar_admin_nuevo_validador')->default(1);
            $table->boolean('notificar_admin_cambio_validador')->default(1);
            $table->boolean('notificar_admin_nuevo_cliente')->default(1);
            $table->boolean('notificar_admin_cambio_cliente')->default(1);
            $table->boolean('notificar_admin_orden_aprobada')->default(1);
            $table->boolean('notificar_admin_orden_produccion')->default(1);
            $table->boolean('notificar_admin_orden_produccion_corte')->default(1);
            $table->boolean('notificar_admin_orden_produccion_ensamble')->default(1);
            $table->boolean('notificar_admin_orden_produccion_plancha')->default(1);
            $table->boolean('notificar_admin_orden_produccion_revision')->default(1);
            $table->boolean('notificar_admin_orden_pickup')->default(1);
            $table->boolean('notificar_admin_orden_entregada')->default(1);
            $table->boolean('notificar_admin_orden_cobrada')->default(1);
            $table->boolean('notificar_admin_orden_facturada')->default(1);
            // Validador
            $table->boolean('notificar_validador_nueva_orden')->default(1);
            $table->boolean('notificar_validador_cambio_orden')->default(1);
            $table->boolean('notificar_validador_nueva_cita')->default(1);
            $table->boolean('notificar_validador_cambio_cita')->default(1);
            $table->boolean('notificar_validador_nuevo_ajuste')->default(1);
            $table->boolean('notificar_validador_cambio_ajuste')->default(1);
            $table->boolean('notificar_validador_nuevo_vendedor')->default(1);
            $table->boolean('notificar_validador_cambio_vendedor')->default(1);
            $table->boolean('notificar_validador_cambio_validador')->default(1);
            $table->boolean('notificar_validador_nuevo_cliente')->default(1);
            $table->boolean('notificar_validador_cambio_cliente')->default(1);
            $table->boolean('notificar_validador_orden_aprobada')->default(1);
            $table->boolean('notificar_validador_orden_produccion')->default(1);
            $table->boolean('notificar_validador_orden_produccion_corte')->default(1);
            $table->boolean('notificar_validador_orden_produccion_ensamble')->default(1);
            $table->boolean('notificar_validador_orden_produccion_plancha')->default(1);
            $table->boolean('notificar_validador_orden_produccion_revision')->default(1);
            $table->boolean('notificar_validador_orden_pickup')->default(1);
            $table->boolean('notificar_validador_orden_entregada')->default(1);
            $table->boolean('notificar_validador_orden_cobrada')->default(1);
            $table->boolean('notificar_validador_orden_facturada')->default(1);
            $table->boolean('notificar_validador_desactivado')->default(0);
            $table->boolean('notificar_validador_activado')->default(0);
            // Vendedor
            $table->boolean('notificar_vendedor_nueva_orden')->default(1);
            $table->boolean('notificar_vendedor_cambio_orden')->default(1);
            $table->boolean('notificar_vendedor_nueva_cita')->default(1);
            $table->boolean('notificar_vendedor_cambio_cita')->default(1);
            $table->boolean('notificar_vendedor_cambio_vendedor')->default(1);
            $table->boolean('notificar_vendedor_nuevo_cliente')->default(1);
            $table->boolean('notificar_vendedor_cambio_cliente')->default(1);
            $table->boolean('notificar_vendedor_orden_aprobada')->default(1);
            $table->boolean('notificar_vendedor_orden_produccion')->default(1);
            $table->boolean('notificar_vendedor_orden_pickup')->default(1);
            $table->boolean('notificar_vendedor_orden_entregada')->default(1);
            $table->boolean('notificar_vendedor_orden_cobrada')->default(1);
            $table->boolean('notificar_vendedor_orden_facturada')->default(1);
            $table->boolean('notificar_vendedor_desactivado')->default(0);
            $table->boolean('notificar_vendedor_activado')->default(0);

            // Timestamps
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
