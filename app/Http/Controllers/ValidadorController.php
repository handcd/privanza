<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Notification;

// Models
use App\Vendedor;
use App\Admin;
use App\Validador;

class ValidadorController extends Controller
{
	/**
	 * Display the home view for the CRUD
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index()
    {
    	$validadores = Validador::paginate(30);
    	return view('admin.validador.home',compact('validadores'));
    }


    /**
     * Display the specified resource
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	$validador = Validador::find($id);

    	if (!$validador) {
    		$request->session()->flash('danger', 'El Validador que deseas visualizar no se encuentra registrado en el sistema, verifica la información e inténtalo de nuevo.');
    		return redirect('/admin/validadores');
    	}

    	return view('admin.validador.show', compact('validador'));
    }


}
