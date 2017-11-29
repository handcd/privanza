<?php

namespace App\Http\Controllers\Validador;

use App\Vendedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VendedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendedores = Vendedor::all();
        return view('validador.vendedor.home',compact('vendedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('validador.vendedor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vendedor = new Vendedor;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required | unique:vendedors',
            'address' => 'required',
            'phone' => 'required',
            'enabled' => 'required',
        ]);

        $vendedor->name = $request->name;
        $vendedor->email = $request->email;
        $vendedor->address = $request->address;
        $vendedor->phone = $request->phone;
        $vendedor->password = bcrypt('vendedor.'.$request->email);
        $vendedor->save();

        // TODO: Send email to new Vendedor with login info.

        return redirect('/validador/vendedores');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vendedor  $vendedor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendedor = Vendedor::find($id);
        return view('validador.vendedor.show',compact('vendedor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vendedor  $vendedor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendedor = Vendedor::find($id);
        return view('validador.vendedor.edit',compact('vendedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vendedor  $vendedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vendedor = Vendedor::find($id);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'enabled' => 'required',
        ]);

        $vendedor->name = $request->name;
        $vendedor->email = $request->email;
        $vendedor->address = $request->address;
        $vendedor->phone = $request->phone;
        $vendedor->save();

        // TODO: Send email to new Vendedor with login info.

        return redirect('/validador/vendedores');
    }

    /**
     * Deactivate the Vendedor account
     *
     * @param  Key  $id
     * @return \Illuminate\Http\Response
     */
    public function activar($id)
    {
        return $id;
    }

    /**
     * Activate the Vendedor account
     * @param Key $id
     * @return \Illuminate\Http\Response
     */
    public function desactivar($id)
    {
        return $id;
    }
}
