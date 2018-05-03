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
use App\Configuration;

// Notifications
use App\Notifications\NewVendedor;
use App\Notifications\EditedVendedor;
use App\Notifications\VendedorEnabled;
use App\Notifications\VendedorDisabled;

class VendedorController extends Controller
{
	/**
     * Application's configuration
     * @var \App\Configuration $configuracion
     */
    protected $configuracion;

    /**
     * Constructor of the class
     */
    public function __construct()
    {
        $this->configuracion = Configuration::first();
    }

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
	 * Display the listing of all Vendedores for Admin
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function indexForAdmin()
	{
		$vendedores = Vendedor::paginate(15);
		return view('admin.vendedor.home',compact('vendedores'));
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
	 * Show a specific Vendedor for Admin
	 *
	 * @param integer id->vendedor
	 * @return \Illuminate\Http\Response
	 */
	public function showForAdmin(Request $request, $id)
	{
		$vendedor = Vendedor::find($id);

		if (!$vendedor) {
			$request->session()->flash('danger', 'El Vendedor que deseas consultar (ID #'.$id.') no se encuentra registrado, corrobora la información e inténtalo de nuevo.');
			return redirect('/admin/vendedores');
		}

		return view('admin.vendedor.show',compact('vendedor'));
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
	 * Show the form for a Client creation for Admin
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function createForAdmin()
	{
		return view('admin.vendedor.create');
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
	 * Show the form for editing an existing Vendedor for Admin
	 *
	 * @param integer $id Vendedor
	 * @return \Illuminate\Http\Response
	 */
	public function editForAdmin(Request $request, $id)
	{
		$vendedor = Vendedor::find($id);

		if (!$vendedor) {
			$request->session()->flash('danger', 'El vendedor que deseas editar no ha sido encontrado. Corrobora la información e inténtalo de nuevo.');
			return redirect('/admin/vendedores');
		}

		return view('admin.vendedor.edit',compact('vendedor'));
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

		// Email notifications
		Notification::send($vendedor, new NewVendedor($vendedor,$vendedor,$request->password));
		if ($this->configuracion->notificar_validador_nuevo_vendedor) {
			foreach (Validador::all() as $validador) {
				Notification::send($validador, new NewVendedor($validador,$vendedor));
			}
		}
		if ($this->configuracion->notificar_admin_nuevo_vendedor) {
			foreach (Admin::all() as $admin) {
				Notification::send($admin, new NewVendedor($admin,$vendedor));
			}
		}

		// Feedback to the user
		$request->session()->flash('success', '¡Listo! '.$vendedor->name.' ha sido agregado exitosamente. Se le ha enviado un correo electrónico con la información de inicio de sesión así como una notificación para ti y el administrador.');


		// Redirect to home of CRUD
		return redirect('/validador/vendedores');
	}

	/**
	 * Add a new vendedor into the system as Admin
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function storeForAdmin(Request $request)
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

		// Email notifications
		Notification::send($vendedor, new NewVendedor($vendedor,$vendedor,$request->password));
		if ($this->configuracion->notificar_validador_nuevo_vendedor) {
			foreach (Validador::all() as $validador) {
				Notification::send($validador, new NewVendedor($validador,$vendedor));
			}
		}
		if ($this->configuracion->notificar_admin_nuevo_vendedor) {
			foreach (Admin::all() as $admin) {
				Notification::send($admin, new NewVendedor($admin,$vendedor));
			}
		}

		// Feedback to the user
		$request->session()->flash('success', '¡Listo! '.$vendedor->name.' ha sido agregado exitosamente. Se le ha enviado un correo electrónico con la información de inicio de sesión así como una notificación para ti y el administrador.');


		// Redirect to home of CRUD
		return redirect('/admin/vendedores');
	}

	/**
	 * Update a Vendedor
	 *
	 * @param integer $id
	 * @param Request $request
	 */
	public function update(Request $request, $id)
	{
		// Get the desired vendedor's model
		$vendedor = Vendedor::find($id);
		// Validate vendedor's existence
		if (!$vendedor) {
			$request->session()->flash('danger', 'Ha ocurrido un error y no hemos podido encontrar el vendedor al que hace referencia la información.');
			return redirect()->back();
		}
		// Validate request
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
		// Assign request data to model
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

		// Notifications for account activated/deactivated
		if (!$vendedor->enabled && ($request->enabled == "1")) {
			if ($this->configuracion->notificar_admin_vendedor_activado) {
				foreach (Admin::all() as $admin) {
					Notification::send($admin, new VendedorEnabled($admin,$vendedor));
				}
			}
			if ($this->configuracion->notificar_validador_vendedor_activado) {
				foreach (Validador::all() as $validador) {
					Notification::send($validador, new VendedorEnabled($validador,$vendedor));
				}
			}
			if ($this->configuracion->notificar_vendedor_activado) {
				Notification::send($vendedor, new VendedorEnabled($vendedor,$vendedor));
			}
		} elseif ($vendedor->enabled && ($request->enabled != "1")) {
			if ($this->configuracion->notificar_admin_vendedor_desactivado) {
				foreach (Admin::all() as $admin) {
					Notification::send($admin, new VendedorDisabled($admin,$vendedor));
				}
			}
			if ($this->configuracion->notificar_validador_vendedor_desactivado) {
				foreach (Validador::all() as $validador) {
					Notification::send($validador, new VendedorDisabled($validador,$vendedor));
				}
			}
			if ($this->configuracion->notificar_vendedor_desactivado) {
				Notification::send($vendedor, new VendedorDisabled($vendedor,$vendedor));
			}
		}

		$vendedor->enabled = $request->enabled == "1" ? true : false;
		$vendedor->type = $request->type;
		// Save to DB
		$vendedor->save();

		// Email notifications
		if ($this->configuracion->notificar_vendedor_cambio_vendedor) {
			Notification::send($vendedor, new EditedVendedor($vendedor,$vendedor));
		}
		if ($this->configuracion->notificar_validador_cambio_vendedor) {
			foreach (Validador::all() as $validador) {
				Notification::send($validador, new EditedVendedor($validador,$vendedor));
			}
		}
		if ($this->configuracion->notificar_admin_cambio_vendedor) {
			foreach (Admin::all() as $admin) {
				Notification::send($admin, new EditedVendedor($admin,$vendedor));
			}
		}

		// Feedback to the user
		$request->session()->flash('success', '¡Listo! Hemos actualizado correctamente la información de '.$vendedor->name.'.');

		// Redirect to home
		return redirect('/validador/vendedores');
	}

	/**
	 * Update a Vendedor for Admin
	 *
	 * @param integer $id
	 * @param Request $request
	 */
	public function updateForAdmin(Request $request, $id)
	{
		// Get the desired vendedor's model
		$vendedor = Vendedor::find($id);

		// Validate Vendedor's existence
		if (!$vendedor) {
			$request->session()->flash('danger', 'Ha ocurrido un error y no hemos podido encontrar el vendedor al que hace referencia la información.');
			return redirect('/admin/vendedores');
		}

		// Validate request
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
		// Assign Request data to Model
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
		
		// Notifications for account activated/deactivated
		if (!$vendedor->enabled && ($request->enabled == "1")) {
			if ($this->configuracion->notificar_admin_vendedor_activado) {
				foreach (Admin::all() as $admin) {
					Notification::send($admin, new VendedorEnabled($admin,$vendedor));
				}
			}
			if ($this->configuracion->notificar_validador_vendedor_activado) {
				foreach (Validador::all() as $validador) {
					Notification::send($validador, new VendedorEnabled($validador,$vendedor));
				}
			}
			if ($this->configuracion->notificar_vendedor_activado) {
				Notification::send($vendedor, new VendedorEnabled($vendedor,$vendedor));
			}
		} elseif ($vendedor->enabled && ($request->enabled != "1")) {
			if ($this->configuracion->notificar_admin_vendedor_desactivado) {
				foreach (Admin::all() as $admin) {
					Notification::send($admin, new VendedorDisabled($admin,$vendedor));
				}
			}
			if ($this->configuracion->notificar_validador_vendedor_desactivado) {
				foreach (Validador::all() as $validador) {
					Notification::send($validador, new VendedorDisabled($validador,$vendedor));
				}
			}
			if ($this->configuracion->notificar_vendedor_desactivado) {
				Notification::send($vendedor, new VendedorDisabled($vendedor,$vendedor));
			}
		}

		$vendedor->enabled = $request->enabled == "1" ? true:false;
		$vendedor->type = $request->type;
		// Save to DB
		$vendedor->save();

		// Email notifications
		if ($this->configuracion->notificar_vendedor_cambio_vendedor) {
			Notification::send($vendedor, new EditedVendedor($vendedor,$vendedor));
		}
		if ($this->configuracion->notificar_validador_cambio_vendedor) {
			foreach (Validador::all() as $validador) {
				Notification::send($validador, new EditedVendedor($validador,$vendedor));
			}
		}
		if ($this->configuracion->notificar_admin_cambio_vendedor) {
			foreach (Admin::all() as $admin) {
				Notification::send($admin, new EditedVendedor($admin,$vendedor));
			}
		}

		// Feedback the user
		$request->session()->flash('success', '¡Listo! Hemos actualizado correctamente la información de '.$vendedor->name.'.');

		// Redirect to home
		return redirect('/admin/vendedores');
	}
}
