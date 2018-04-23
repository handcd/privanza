<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Configuration;
use App\Admin;
use App\Vendedor;
use App\Validador;

class ConfigurationController extends Controller
{
	/**
	 * Main view
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$configuration = Configuration::first();

		return view('admin.configuration.home', compact('configuration'));
	}

	/**
	 * Update the configuration
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$this->validate($request, [
			'horas_aviso_no_aprobada' => 'required',
			'horas_aviso_aprobada' => 'required',
			'horas_aviso_produccion' => 'required',
			'horas_aviso_produccion_corte' => 'required',
			'horas_aviso_produccion_ensamble' => 'required',
			'horas_aviso_produccion_plancha' => 'required',
			'horas_aviso_produccion_revision' => 'required',
			'horas_aviso_pickup' => 'required'
		]);

		// First row
		$configuration = Configuration::first();

		// Notifications' Times
		$configuration->horas_aviso_no_aprobada = $request->horas_aviso_no_aprobada;
		$configuration->horas_aviso_aprobada = $request->horas_aviso_aprobada;
		$configuration->horas_aviso_produccion = $request->horas_aviso_produccion;
		$configuration->horas_aviso_produccion_corte = $request->horas_aviso_produccion_corte;
		$configuration->horas_aviso_produccion_ensamble = $request->horas_aviso_produccion_ensamble;
		$configuration->horas_aviso_produccion_revision = $request->horas_aviso_produccion_revision;
		$configuration->horas_aviso_pickup = $request->horas_aviso_pickup;

		// Notifications enabled/disabled
		// Admin
        $configuration->notificar_admin_nueva_orden = $request->notificar_admin_nueva_orden ? true : false;
        $configuration->notificar_admin_cambio_orden = $request->notificar_admin_cambio_orden ? true : false;
        $configuration->notificar_admin_status_orden = $request->notificar_admin_status_orden ? true : false;
        $configuration->notificar_admin_nuevo_vendedor = $request->notificar_admin_nuevo_vendedor ? true : false;
        $configuration->notificar_admin_cambio_vendedor = $request->notificar_admin_cambio_vendedor ? true : false;
        $configuration->notificar_admin_nuevo_cliente = $request->notificar_admin_nuevo_cliente ? true : false;
        $configuration->notificar_admin_cambio_cliente = $request->notificar_admin_cambio_cliente ? true : false;
        $configuration->notificar_admin_nuevo_ajuste = $request->notificar_admin_nuevo_ajuste ? true : false;
        $configuration->notificar_admin_cambio_ajuste = $request->notificar_admin_cambio_ajuste ? true : false;
        $configuration->notificar_admin_nueva_cita = $request->notificar_admin_nueva_cita ? true : false;
        $configuration->notificar_admin_cambio_cita = $request->notificar_admin_cambio_cita ? true : false;
        // Validador
        $configuration->notificar_validador_desactivado = $request->notificar_validador_desactivado ? true : false;
        $configuration->notificar_validador_nueva_orden = $request->notificar_validador_nueva_orden ? true : false;
        $configuration->notificar_validador_cambio_orden = $request->notificar_validador_cambio_orden ? true : false;
        $configuration->notificar_validador_status_orden = $request->notificar_validador_status_orden ? true : false;
        $configuration->notificar_validador_nuevo_vendedor = $request->notificar_validador_nuevo_vendedor ? true : false;
        $configuration->notificar_validador_cambio_vendedor = $request->notificar_validador_cambio_vendedor ? true : false;
        $configuration->notificar_validador_nuevo_cliente = $request->notificar_validador_nuevo_cliente ? true : false;
        $configuration->notificar_validador_cambio_cliente = $request->notificar_validador_cambio_cliente ? true : false;
        $configuration->notificar_validador_nuevo_ajuste = $request->notificar_validador_nuevo_ajuste ? true : false;
        $configuration->notificar_validador_cambio_ajuste = $request->notificar_validador_cambio_ajuste ? true : false;
        $configuration->notificar_validador_nueva_cita = $request->notificar_validador_nueva_cita ? true : false;
        $configuration->notificar_validador_cambio_cita = $request->notificar_validador_cambio_cita ? true : false;
        // Vendedor
        $configuration->notificar_vendedor_desactivado = $request->notificar_vendedor_desactivado ? true : false;
        $configuration->notificar_vendedor_nueva_orden = $request->notificar_vendedor_nueva_orden ? true : false;
        $configuration->notificar_vendedor_cambio_orden = $request->notificar_vendedor_cambio_orden ? true : false;
        $configuration->notificar_vendedor_status_orden = $request->notificar_vendedor_status_orden ? true : false;
        $configuration->notificar_vendedor_nuevo_cliente = $request->notificar_vendedor_nuevo_cliente ? true : false;
        $configuration->notificar_vendedor_cambio_cliente = $request->notificar_vendedor_cambio_cliente ? true : false;
        $configuration->notificar_vendedor_nueva_cita = $request->notificar_vendedor_nueva_cita ? true : false;
        $configuration->notificar_vendedor_cambio_cita = $request->notificar_vendedor_cambio_cita ? true : false;

		// Save to Database
		$configuration->save();

		// Feedback the user
		$request->session()->flash('success', 'Se ha actualizado correctamente la configuración general del sistema.');
		// Redirect to base view
		return redirect('/admin/configuracion');
	}
}
