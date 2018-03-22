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

// Notifications
use App\Notifications\VendedorNew;

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

	/**
	 * Add a new vendedor into the system
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$vendedor = new Vendedor;

		$this->validate($request, [
			'name' => 'required',  						
			'lastname' => 'required',  					
			'email' => 'required|email|unique:vendedors',  
			'address' => 'required',  					
			'phone' => 'required',  					
			'birthday' => 'required|date',  			
			'rfc' => 'nullable',  						
			'digits' => 'nullable',  					
			'bank' => 'nullable',  						
			'legalAddress' => 'nullable',  				
			'concept' => 'nullable',  					
			'enabled' => 'required',  					
			'type' => 'required',
			'password' => 'required'						
		]);

		$vendedor->name = $request->name;
		$vendedor->lastname = $request->lastname;
		$vendedor->email = $request->email;
		$vendedor->address_home = $request->address;
		$vendedor->phone = $request->phone;
		$vendedor->birthday = Carbon::parse($request->birthday)->toDateTimeString();
		$vendedor->rfc = $request->rfc;
		$vendedor->account_digits = $request->digits;
		$vendedor->bank = $request->bank;
		$vendedor->address_legal = $request->legalAddress;
		$vendedor->concept = $request->concept;
		$vendedor->enabled = $request->enabled == "1" ? true:false;
		$vendedor->type = $request->type;
		$vendedor->password = bcrypt($request->password);

		$vendedor->save();

		// Notify new Vendedor
		Notification::send($vendedor,new VendedorNew($vendedor,$request->password));
		// Notify Admin

		// Notify current Validador

		// Feedback to the user
		$request->session()->flash('success', '¡Listo! '.$vendedor->name.' ha sido agregado exitosamente. Se le ha enviado un correo electrónico con la información de inicio de sesión así como una notificación para ti y el administrador.');


		// Redirect to home of CRUD
		return redirect('/validador/vendedores');
	}

	/**
	 * Update a Vendedor
	 *
	 * @param integer $id
	 * @param Request $request
	 */
	public function update(Request $request, $id)
	{
		$vendedor = Vendedor::find($id);

		if (!$vendedor) {
			$request->session()->flash('danger', 'Ha ocurrido un error y no hemos podido encontrar el vendedor al que hace referencia la información.');
			return redirect()->back();
		}

		$this->validate($request, [
			'name' => 'required',  						
			'lastname' => 'required',  					
			'email' => 'required|email',  
			'address' => 'required',  					
			'phone' => 'required',  					
			'birthday' => 'required|date',  			
			'rfc' => 'nullable',  						
			'digits' => 'nullable',  					
			'bank' => 'nullable',  						
			'legalAddress' => 'nullable',  				
			'concept' => 'nullable',  					
			'enabled' => 'required',  					
			'type' => 'required'						
		]);

		$vendedor->name = $request->name;
		$vendedor->lastname = $request->lastname;
		$vendedor->email = $request->email;
		$vendedor->address_home = $request->address;
		$vendedor->phone = $request->phone;
		$vendedor->birthday = Carbon::parse($request->birthday)->toDateTimeString();
		$vendedor->rfc = $request->rfc;
		$vendedor->account_digits = $request->digits;
		$vendedor->bank = $request->bank;
		$vendedor->address_legal = $request->legalAddress;
		$vendedor->concept = $request->concept;
		$vendedor->enabled = $request->enabled == "1" ? true:false;
		$vendedor->type = $request->type;

		$vendedor->save();

		$request->session()->flash('success', '¡Listo! Hemos actualizado correctamente la información de '.$vendedor->name.'.');

		return redirect('/validador/vendedores');
	}
}
