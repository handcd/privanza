<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Client;
use App\Vendedor;
use App\Validador;
use App\Admin;
use App\Fit;

// Facades
use Auth;
use Carbon\Carbon;
use Session;
use Notification;

// Notifications
use App\Notifications\AdminNewClient;           // Cuando Validador/Vendedor añaden un cliente
use App\Notifications\AdminEditedClient;        // Cuando Validador/Vendedor editan un cliente
use App\Notifications\VendedorNewClient;        // Cuando Admin/Validador añaden un cliente
use App\Notifications\VendedorEditedClient;     // Cuando Admin/Validador editan un cliente
use App\Notifications\ValidadorNewClient;       // Cuando Vendedor/Admin añaden un cliente
use App\Notifications\ValidadorEditedClient;    // Cuando Vendedor/Admin editan un cliente


class ClientController extends Controller
{
    /**
     * Display a listing of the resource as a Vendedor
     *
     * @return \Illuminate\Http\Response
     */
    public function indexForVendedor()
    {
        $clientes = Auth::user()->clients()->paginate(15);
        return view('vendedor.client.home',compact('clientes'));
    }

    /**
     * Display the home view for Validador
     *
     * @return \Illuminate\Http\Response
     */
    public function indexForValidador()
    {
        $clientes = Client::paginate(15);
        return view('validador.client.home',compact('clientes'));
    }

    /**
     * Display the home view for Admin
     *
     * @return \Illuminate\Http\Response
     */
    public function indexForAdmin()
    {
        $clientes = Client::paginate(15);
        return view('admin.client.home',compact('clientes'));
    }

    /**
     * Show the form for creating a new resource as a Vendedor
     *
     * @return \Illuminate\Http\Response
     */
    public function createForVendedor()
    {
        $fits = Fit::all();
        return view('vendedor.client.create',compact('fits'));
    }

    /**
     * Show the form for creating a new resource as a Validador
     *
     * @return \Illuminate\Http\Response
     */
    public function createForValidador()
    {
        $fits = Fit::all();
        $vendedores = Vendedor::all();
        return view('validador.client.create',compact('fits','vendedores'));
    }

    /**
     * Show the form for creating a new resource as an Admin
     *
     * @return \Illuminate\Http\Response
     */
    public function createForAdmin()
    {
        $fits = Fit::all();
        $vendedores = Vendedor::all();
        return view('admin.client.create',compact('fits','vendedores'));
    }

    /**
     * Store a newly created resource in storage as a Vendedor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeForVendedor(Request $request)
    {
        $cliente = new Client;
        $this->validate($request, [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required | unique:clients',
            'birthday' => 'required | date',
            'addressVisit' => 'required'
        ]);

        $cliente->name = $request->nombre;
        $cliente->lastname = $request->apellido;
        $cliente->phone = $request->phone;
        $cliente->email = $request->email;
        $cliente->address_visit = $request->addressVisit;
        $cliente->address_delivery = $request->addressDelivery;
        $cliente->birthday = Carbon::parse($request->birthday)->toDateTimeString();
        $cliente->notes = $request->notas;
        $cliente->address_legal = $request->addressLegal;
        $cliente->rfc = $request->rfc;
        $cliente->bank = $request->bank;
        $cliente->account_digits = $request->digitos;
        $cliente->concept = $request->concept;
        $cliente->vendedor_id = Auth::id();
        $cliente->contacto = $request->contactoReferencia;
        $cliente->save();

        // Notifications
        Notification::send(Validador::all(), new ValidadorNewClient($cliente));
        Notification::send(Admin::all(), new AdminNewClient($cliente));

        // Feedback to the user
        $request->session()->flash('success', 'Se ha añadido correctamente un cliente nuevo.');
        return redirect('/vendedor/clientes');
    }

    /**
     * Store a newly created resource in storage as a Validador.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeForValidador(Request $request)
    {
        $cliente = new Client;
        $this->validate($request, [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required | unique:clients',
            'vendedor' => 'required | exists:vendedors,id',
            'birthday' => 'required | date',
            'addressVisit' => 'required'
        ]);

        $cliente->name = $request->nombre;
        $cliente->lastname = $request->apellido;
        $cliente->phone = $request->phone;
        $cliente->email = $request->email;
        $cliente->address_visit = $request->addressVisit;
        $cliente->address_delivery = $request->addressDelivery;
        $cliente->birthday = Carbon::parse($request->birthday)->toDateTimeString();
        $cliente->notes = $request->notas;
        $cliente->address_legal = $request->addressLegal;
        $cliente->rfc = $request->rfc;
        $cliente->bank = $request->bank;
        $cliente->account_digits = $request->digitos;
        $cliente->concept = $request->concept;
        $cliente->vendedor_id = $request->vendedor;
        $cliente->contacto = $request->contactoReferencia;
        $cliente->save();

        // Notifications
        Notification::send($cliente->vendedor, new VendedorNewClient($cliente));
        Notification::send(Admin::all(), new AdminNewClient($cliente));

        // Feedback to the user
        $request->session()->flash('success', 'Se ha añadido correctamente un cliente nuevo.');

        return redirect('/validador/clientes');
    }

    /**
     * Store a newly created resource in storage as an Admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeForAdmin(Request $request)
    {
        $cliente = new Client;
        $this->validate($request, [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required | unique:clients',
            'vendedor' => 'required | exists:vendedors,id',
            'birthday' => 'required | date',
            'addressVisit' => 'required'
        ]);

        $cliente->name = $request->nombre;
        $cliente->lastname = $request->apellido;
        $cliente->phone = $request->phone;
        $cliente->email = $request->email;
        $cliente->address_visit = $request->addressVisit;
        $cliente->address_delivery = $request->addressDelivery;
        $cliente->birthday = Carbon::parse($request->birthday)->toDateTimeString();
        $cliente->notes = $request->notas;
        $cliente->address_legal = $request->addressLegal;
        $cliente->rfc = $request->rfc;
        $cliente->bank = $request->bank;
        $cliente->account_digits = $request->digitos;
        $cliente->concept = $request->concept;
        $cliente->vendedor_id = $request->vendedor;
        $cliente->contacto = $request->contactoReferencia;
        $cliente->save();

        // Notifications
        Notification::send($cliente->vendedor, new VendedorNewClient($cliente));
        Notification::send(Validador::all(), new ValidadorNewClient($cliente));

        // Feedback to the user
        $request->session()->flash('success', 'Se ha añadido correctamente un cliente nuevo.');

        return redirect('/admin/clientes');
    }

    /**
     * Display the specified resource for the Vendedor
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function showForVendedor($id)
    {
        $client = Client::find($id);
        if (!$client || $client->vendedor_id != Auth::id()) {
            Session::flash('danger', 'El cliente que buscas no puede ser mostrado porque no tienes acceso a él o no existe.');
            return redirect('/vendedor/clientes');
        }
        return view('vendedor.client.show',compact('client'));
    }

    /**
     * Display the Client for the Validador
     *
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     */
    public function showForValidador(Request $request, $id)
    {
        $client = Client::find($id);

        if (!$client) {
            $request->session()->flash('danger', 'El cliente que buscas no existe o no puede ser mostrado.');
            return redirect('/validador/clientes');
        }

        return view('validador.client.show',compact('client'));
    }

    /**
     * Display the Client for the Admin
     *
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     */
    public function showForAdmin(Request $request, $id)
    {
        $client = Client::find($id);

        if (!$client) {
            $request->session()->flash('danger', 'El cliente que buscas no existe o no puede ser mostrado.');
            return redirect('/admin/clientes');
        }

        return view('admin.client.show',compact('client'));
    }

    /**
     * Show the form for editing the specified resource as Vendedor
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function editForVendedor($id)
    {
        $cliente = Client::find($id);
        $fits = Fit::all();
        if (!$cliente || $cliente->vendedor_id != Auth::id()) {
            Session::flash('danger', 'El cliente que buscas no existe o no tienes permiso para editarlo.');
            return redirect('/vendedor/clientes');
        }
        return view('vendedor.client.edit',compact('cliente','fits'));
    }

    /**
     * Show the form for editing the specified resource as a Validador
     *
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     */
    public function editForValidador($id)
    {
        $cliente = Client::find($id);

        if (!$cliente) {
            $request->session()->flash('danger', 'El cliente que deseas editar no existe.');
            return redirect('/validador/clientes');
        }

        $vendedores = Vendedor::all();
        $fit = Fit::all();

        return view('validador.client.edit',compact('cliente','fits','vendedores'));
    }

    /**
     * Show the form for editing the specified resource as an Admin
     *
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     */
    public function editForAdmin($id)
    {
        $cliente = Client::find($id);

        if (!$cliente) {
            $request->session()->flash('danger', 'El cliente que deseas editar no existe.');
            return redirect('/admin/clientes');
        }

        $vendedores = Vendedor::all();
        $fit = Fit::all();

        return view('admin.client.edit',compact('cliente','fits','vendedores'));
    }

    /**
     * Update the specified resource in storage for Vendedor
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function updateForVendedor(Request $request, $id)
    {
        $cliente = Client::find($id);

        if (!$cliente || $cliente->vendedor_id != Auth::id()) {
            return redirect('vendedor/clientes/'.$id.'/editar');
        }

        $this->validate($request, [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required',
            'birthday' => 'required | date',
            'addressVisit' => 'required'
        ]);

        $cliente->name = $request->nombre;
        $cliente->lastname = $request->apellido;
        $cliente->phone = $request->phone;
        $cliente->email = $request->email;
        $cliente->address_visit = $request->addressVisit;
        $cliente->address_delivery = $request->addressDelivery;
        $cliente->birthday = Carbon::parse($request->birthday)->toDateTimeString();
        $cliente->notes = $request->notas;
        $cliente->address_legal = $request->addressLegal;
        $cliente->rfc = $request->rfc;
        $cliente->bank = $request->bank;
        $cliente->account_digits = $request->digitos;
        $cliente->concept = $request->concept;
        $cliente->vendedor_id = Auth::id();
        $cliente->contacto = $request->contactoReferencia;
        $cliente->save();

        // Notifications
        Notification::send(Validador::all(), new ValidadorEditedClient($cliente));
        Notification::send(Admin::all(), new AdminEditedClient($cliente));

        // Feedback to the user
        $request->session()->flash('success', 'El cliente ha sido editado correctamente.');

        return redirect('/vendedor/clientes');
    }

    /**
     * Update the specified resource in storage for Validador
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function updateForValidador(Request $request, $id)
    {
        $cliente = Client::find($id);

        if (!$cliente) {
            return redirect('/validador/clientes/'.$id.'/editar');
        }

        $this->validate($request, [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required',
            'birthday' => 'required | date',
            'addressVisit' => 'required',
            'vendedor' => 'required | exists:vendedors,id'
        ]);

        $cliente->name = $request->nombre;
        $cliente->lastname = $request->apellido;
        $cliente->phone = $request->phone;
        $cliente->email = $request->email;
        $cliente->address_visit = $request->addressVisit;
        $cliente->address_delivery = $request->addressDelivery;
        $cliente->birthday = Carbon::parse($request->birthday)->toDateTimeString();
        $cliente->notes = $request->notas;
        $cliente->address_legal = $request->addressLegal;
        $cliente->rfc = $request->rfc;
        $cliente->bank = $request->bank;
        $cliente->account_digits = $request->digitos;
        $cliente->concept = $request->concept;
        $cliente->vendedor_id = $request->vendedor;
        $cliente->contacto = $request->contactoReferencia;
        $cliente->save();

        // Notifications
        Notification::send($cliente->vendedor, new VendedorEditedClient($cliente));
        Notification::send(Admin::all(), new AdminEditedClient($cliente));

        // Feedback to the user
        $request->session()->flash('success', 'El cliente ha sido editado correctamente.');
        return redirect('/validador/clientes');
    }

    /**
     * Update the specified resource in storage for Admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function updateForAdmin(Request $request, $id)
    {
        $cliente = Client::find($id);

        if (!$cliente) {
            return redirect('/admin/clientes/'.$id.'/editar');
        }

        $this->validate($request, [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required',
            'birthday' => 'required | date',
            'addressVisit' => 'required',
            'vendedor' => 'required | exists:vendedors,id'
        ]);

        $cliente->name = $request->nombre;
        $cliente->lastname = $request->apellido;
        $cliente->phone = $request->phone;
        $cliente->email = $request->email;
        $cliente->address_visit = $request->addressVisit;
        $cliente->address_delivery = $request->addressDelivery;
        $cliente->birthday = Carbon::parse($request->birthday)->toDateTimeString();
        $cliente->notes = $request->notas;
        $cliente->address_legal = $request->addressLegal;
        $cliente->rfc = $request->rfc;
        $cliente->bank = $request->bank;
        $cliente->account_digits = $request->digitos;
        $cliente->concept = $request->concept;
        $cliente->vendedor_id = $request->vendedor;
        $cliente->contacto = $request->contactoReferencia;
        $cliente->save();

        // Notifications
        Notification::send($cliente->vendedor, new VendedorEditedClient($cliente));
        Notification::send(Admin::all(), new AdminEditedClient($cliente));

        // Feedback to the user
        $request->session()->flash('success', 'El cliente ha sido editado correctamente.');
        return redirect('/admin/clientes');
    }
}
