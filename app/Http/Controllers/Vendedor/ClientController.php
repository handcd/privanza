<?php

namespace App\Http\Controllers\Vendedor;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Client::all();
        return view('vendedor.client.home',compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendedor.client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cliente = new Client;
        $this->validate($request, [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required | unique:clients',
        ]);

        $cliente->name = $request->nombre;
        $cliente->lastname = $request->apellido;
        $cliente->email = $request->email;
        $cliente->phone = $request->phone;
        $cliente->save();

        return redirect('/vendedor/clientes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::find($id);
        return view('vendedor.client.show',compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = Client::find($id);
        return view('vendedor.client.edit',compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cliente = Client::find($id);
        $this->validate($request, [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required',
        ]);

        $cliente->name = $request->nombre;
        $cliente->lastname = $request->apellido;
        $cliente->email = $request->email;
        $cliente->phone = $request->phone;
        $cliente->save();

        return redirect('/vendedor/clientes');
    }
}
