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
use App\Configuration;
use App\Validador;
use App\Admin;
use App\Telas;
use App\Forro;

// Notifications
use App\Notifications\NewAdjustment;
use App\Notifications\EditedAdjustment;

class TelasController extends Controller
{
    public function indexForValidador(){
    	$telas = Telas::paginate(20);
    	return view('validador.telas.home', compact('telas'));
    }
    public function createForValidador()
	{
		return view('validador.telas.create');
	}
	public function storeForValidador(Request $request){
		/*$this->validate($request, [
            'codigo_tela' => 'requiered',
            'color_tela' => 'requiered',
            'nombre_tela' => 'requiered',
            'composicion' => 'requiered'

        ]);*/

        $tela = new Telas;

        $tela->codigo_tela = $request->codigo_tela;
        $tela->color_tela = $request->color_tela;
        $tela->nombre_tela = $request->nombre_tela;
        $tela->composicion = $request->composicion;
        $tela->estado = $request->estado;
        $tela->save();
        return redirect('/validador/telas');
	}
	public function editForValidador($id)
	{
		$tela = Telas::find($id);

		if (!$tela) {
			$request->session()->flash('danger', 'La Tela que deseas editar no ha sido encontrada.');
			return redirect('/validador/telas');
		}

		return view('validador.telas.edit',compact('tela'));
	}
	public function updateForValidador(Request $request, $id){
		$tela = Telas::find($id);

        if (!$tela) {
        	$request->session()->flash('danger', 'La información que proporcionaste tiene errores o no existe.');
        	return redirect('/validador/telas/'.$id.'/editar');
        }

        $tela->codigo_tela = $request->codigo_tela;
        $tela->color_tela = $request->color_tela;
        $tela->nombre_tela = $request->nombre_tela;
        $tela->composicion = $request->composicion;
        $tela->estado = $request->estado;
        $tela->save();
        return redirect('/validador/telas');
	}
}
