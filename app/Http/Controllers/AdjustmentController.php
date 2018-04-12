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

		$sinAprobar = AdjustmentOrder::where('status',0)->paginate(5,['*'],'sinAprobar');
		$aprobadas = AdjustmentOrder::where('status',1)->paginate(5,['*'],'aprobadas');
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
	 *
	 * @param \Illuminate\Http\Request $request
	 */
	public function storeForValidador(Request $request)
	{
		$this->validate($request, [
            'consecutivo_ajustes' => 'required',
            'consecutivo_op2' => 'nullable',
            'client_id' => 'required|exists:clients,id',
            'status' => 'required'
        ]);

        $orden = new AdjustmentOrder;

        $orden->client_id = $request->client_id;
        $orden->consecutivo_ajuste = $request->consecutivo_ajustes;
        $orden->consecutivo_op = $request->consecutivo_op2;
        $orden->status = $request->status;

        $orden->save();

        for ($i=0; $i < sizeof($request->fechaClienteOculta); $i++) { 
        	$ajuste = new Adjustment;
        	$ajuste->adjustment_order_id = $orden->id;
        	$ajuste->promesa_planta = Carbon::parse($request->fechaPlantaOculta[$i])->toDateTimeString();
        	$ajuste->promesa_cliente = Carbon::parse($request->fechaClienteOculta[$i])->toDateTimeString();
        	$ajuste->precio = $request->precio[$i];
        	$ajuste->num_prendas = $request->num_prendas[$i];
        	$ajuste->descripcion = $request->descripcion[$i];
        	$ajuste->tipo_prenda = $request->tipo_prenda[$i];
        	$ajuste->save();
        }

        // Feedback the user
        $request->session()->flash('success', 'Se ha añadido exitosamente la Orden de Ajustes #'.$orden->id.' al sistema.');

        // Redirect back to the main view.
        return redirect('/validador/ajustes');
	}

	/**
	 * Get the form for creating a new resource
	 * @return \Illuminate\Http\Request
	 */
	public function createForValidador()
	{
		$ordenes = Order::all();
		$clientes = Client::all();
		return view('validador.adjustment.create',compact('ordenes','clientes'));
	}

	/**
	 * Get the form for editing a new resource
	 * @param \App\AdjustmentOrder $id
	 * @return \Illuminate\Http\Request
	 */
	public function editForValidador($id)
	{
		$adjustmentOrder = AdjustmentOrder::find($id);

		if (!$adjustmentOrder) {
			$request->session()->flash('danger', 'La Orden de Ajustes que deseas editar no ha sido encontrada.');
			return back();
		}
		
		$ordenes = Order::all();
		$clientes = Client::all();

		return view('validador.adjustment.edit',compact('ordenes','adjustmentOrder','clientes'));
	}

	/**
	 * Update the specified resource
	 * @return \Illuminate\Http\Request
	 */
	public function updateForValidador(Request $request, $id)
	{
		$this->validate($request, [
            'consecutivo_ajustes' => 'required',
            'consecutivo_op2' => 'nullable',
            'client_id' => 'required|exists:clients,id',
            'status' => 'required'
        ]);

        $orden = AdjustmentOrder::find($id);

        if (!$orden) {
        	$request->session()->flash('danger', 'La información que proporcionaste tiene errores o no existe.');
        	return redirect('/validador/ajustes/'.$id.'/editar');
        }

        $orden->client_id = $request->client_id;
        $orden->consecutivo_ajuste = $request->consecutivo_ajustes;
        $orden->consecutivo_op = $request->consecutivo_op2;
        $orden->status = $request->status;

        $orden->save();

        // Existing Adjustments
        for ($i=0; $i < sizeof($request->editIdOculto); $i++) { 
        	$ajuste = Adjustment::find($request->editIdOculto[$i]);

        	if ($ajuste) {
	        	$ajuste->adjustment_order_id = $orden->id;
	        	$ajuste->promesa_planta = Carbon::parse($request->fechaPlantaOculta[$i])->toDateTimeString();
	        	$ajuste->promesa_cliente = Carbon::parse($request->fechaClienteOculta[$i])->toDateTimeString();
	        	$ajuste->precio = $request->precio[$i];
	        	$ajuste->num_prendas = $request->num_prendas[$i];
	        	$ajuste->descripcion = $request->descripcion[$i];
	        	$ajuste->tipo_prenda = $request->tipo_prenda[$i];
	        	$ajuste->save();
        	} else {
        		$request->session()->flash('danger', 'Ocurrió un valor actualizando la información de un ajuste específico (#'.$request->editIdOculto[$i].').');
        		return redirect('/validador/ajustes/'.$id.'/editar');
        	}
        }

        // New Adjustments
        for ($i=sizeof($request->editIdOculto); $i < sizeof($request->fechaClienteOculta) ; $i++) { 
        	$ajuste = new Adjustment;
        	$ajuste->adjustment_order_id = $orden->id;
        	$ajuste->promesa_planta = Carbon::parse($request->fechaPlantaOculta[$i])->toDateTimeString();
        	$ajuste->promesa_cliente = Carbon::parse($request->fechaClienteOculta[$i])->toDateTimeString();
        	$ajuste->precio = $request->precio[$i];
        	$ajuste->num_prendas = $request->num_prendas[$i];
        	$ajuste->descripcion = $request->descripcion[$i];
        	$ajuste->tipo_prenda = $request->tipo_prenda[$i];
        	$ajuste->save();
        }

        // Feedback the user
        $request->session()->flash('success', 'Se ha actualizado exitosamente la Orden de Ajustes #'.$orden->id.' en el sistema.');

        // Redirect back to the main view.
        return redirect('/validador/ajustes');
	}
}
