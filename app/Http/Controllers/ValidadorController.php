<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Notification;

// Notifications
use App\Notifications\ValidadorNew;

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

    /**
     * Display the form to add a new Validador
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('admin.validador.create');
    }

    /**
     * Add a new Validador to the App
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$this->validate($request, [
			'name' => 'required',  						
			'lastname' => 'required',  					
			'email' => 'required|email|unique:validadors',  
			'job_position' => 'required',  					
			'phone' => 'required',  					
			'birthday' => 'required|date',  					
			'enabled' => 'required',
			'password' => 'required'						
		]);

    	// New Validador
		$validador = new Validador;

		// Assign data
		$validador->name = $request->name;
		$validador->lastname = $request->lastname;
		$validador->email = $request->email;
		$validador->job_position = $request->job_position;
		$validador->phone = $request->phone;
		$validador->birthday = Carbon::parse($request->birthday)->toDateTimeString();
		$validador->enabled = $request->enabled == "1" ? true : false;
		$validador->password = bcrypt($request->password);

		// Save the data to DB
		$validador->save();

		// Notify new Validador
		Notification::send($validador, new ValidadorNew($validador,$request->password));

		// Feedback to the Admin
		$request->session()->flash('success', '¡Listo! '.$validador->name.' ha sido añadido correctamente como Validador. Se le ha enviado un email con la información para que se integre al sistema.');

		// Redirect to home of CRUD
		return redirect('/admin/validadores');
    }


}
