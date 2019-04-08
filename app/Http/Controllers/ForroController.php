<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Forro;

class ForroController extends Controller
{
    public function indexForValidador(){
        $forros = Forro::paginate(20);
        return view('validador.forros.home', compact('forros'));
    }
    public function createForValidador()
	{
		return view('validador.forros.create');
	}
	public function storeForValidador(Request $request){
		/*$this->validate($request, [
            'codigo_tela' => 'requiered',
            'color_tela' => 'requiered',
            'nombre_tela' => 'requiered',
            'composicion' => 'requiered'

        ]);*/

        $forro = new Forro;

        $forro->codigo_forro = $request->codigo_forro;
        $forro->color_forro = $request->color_forro;
        $forro->nombre_forro = $request->nombre_forro;
        $forro->composicion = $request->composicion;
        $forro->estado = $request->estado;
        $forro->save();
        return redirect('/validador/forros');
	}
	public function editForValidador($id)
	{
		$forro = Forro::find($id);

		if (!$forro) {
			$request->session()->flash('danger', 'El forro que deseas editar no ha sido encontrado.');
			return redirect('/validador/forros');
		}

		return view('validador.forros.edit',compact('forro'));
	}
	public function updateForValidador(Request $request, $id){
		$forro = Forro::find($id);

        if (!$forro) {
        	$request->session()->flash('danger', 'La información que proporcionaste tiene errores o no existe.');
        	return redirect('/validador/forros/'.$id.'/editar');
        }

        $forro->codigo_forro = $request->codigo_forro;
        $forro->color_forro = $request->color_forro;
        $forro->nombre_forro = $request->nombre_forro;
        $forro->composicion = $request->composicion;
        $forro->estado = $request->estado;
        $forro->save();
        return redirect('/validador/forros');
	}
}
