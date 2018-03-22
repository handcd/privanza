<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Vendedor;
use App\Admin;
use App\Validador;

// Notifications


class VendedorController extends Controller
{
	/**
	 * Display the listing of all Vendedores
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$vendedores = Vendedor::paginate(15);
		return view('validador.vendedor.home',compact('vendedores'));
	}

	/**
	 * Show a specific Vendedor
	 *
	 * @param integer id->vendedor
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $id)
	{
		$vendedor = Vendedor::find($id);

		if (!$vendedor) {
			$request->session()->flash('danger', 'El Vendedor que deseas consultar (ID #'.$id.') no se encuentra registrado, corrobora la información e inténtalo de nuevo.');
			return redirect('/validador/vendedores');
		}

		return view('validador.vendedor.show',compact('vendedor'));
	}

	/**
	 * Show the form for a Client creation
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('validador.vendedor.create');
	}

	/**
	 * Show the form for editing an existing Vendedor
	 *
	 * @param integer $id Vendedor
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{
		$vendedor = Vendedor::find($id);

		if (!$vendedor) {
			$request->session()->flash('danger', 'El vendedor que deseas editar no ha sido encontrado. Corrobora la información e inténtalo de nuevo.');
			return redirect('/validador/vendedores');
		}

		return view('validador.vendedor.edit',compact('vendedor'));
	}
}
