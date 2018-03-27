<?php

namespace App\Http\Controllers;

// Facades
use Illuminate\Http\Request;
use Carbon\Carbon;
use Notification;

// Models
use App\Adjustment;
use App\AdjustmentOrder;
use App\Client;
use App\Order;

// Notifications


class AdjustmentController extends Controller
{
	/**
	 * Get the index view for Validadors
	 * @return \Illuminate\Http\Request
	 */
	public function indexForValidador()
	{
		$ordenes = AdjustmentOrder::paginate(15,['*'],'general');

		$aprobadas = AdjustmentOrder::where('status',1)->paginate(5,['*'],'aprobadas');
		$sinAprobar = AdjustmentOrder::where('status',0)->paginate(5,['*'],'sinAprobar');
		$finalizadas = AdjustmentOrder::where('status',2)->paginate(5,['*'],'finalizadas');

		return view('validador.adjustment.home',compact('ordenes','aprobadas','sinAprobar','finalizadas'));
	}

	/**
	 * Get the view for a specific resource
	 * @param \Illuminate\Http\Request $request
	 * @param \App\AdjustmentOrder $id 
	 */
	public function showForValidador(Request $request, $id)
	{
		$adjustmentOrder = AdjustmentOrder::find($id);

		if (!$adjustmentOrder) {
			$request->session()->flash('danger', 'La Orden de Ajustes que buscas no ha sido encontrada.');
			return back();
		}

		return view('validador.adjustment.show',compact('adjustmentOrder'));
	}

	/**
	 * Store the request
	 * @param \Illuminate\Http\Request $request
	 */
	public function storeForValidador(Request $request)
	{
		return $request;
	}

	/**
	 * Get the form for creating a new resource
	 * @return \Illuminate\Http\Request
	 */
	public function createForValidador()
	{
		$ordenes = Order::all();
		return view('validador.adjustment.create',compact('ordenes'));
	}

	/**
	 * Get the form for editing a new resource
	 * @param \App\AdjustmentOrder $id
	 * @return \Illuminate\Http\Request
	 */
	public function editForValidador($id)
	{
		$ordenes = Order::all();
		$adjustmentOrder = AdjustmentOrder::find($id);

		if (!$adjustmentOrder) {
			$request->session()->flash('danger', 'La Orden de Ajustes que deseas editar no ha sido encontrada.');
			return back();
		}

		return view('validador.adjustment.edit',compact('ordenes'));
	}

	/**
	 * Update the specified resource
	 * @return \Illuminate\Http\Request
	 */
	public function updateForValidador()
	{
		return 'papapapapa';
	}
}
