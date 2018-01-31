<?php

namespace App\Http\Controllers\Vendedor;

use App\Client;
use App\Fit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Auth::user()->clients;
        return view('vendedor.client.home',compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fits = Fit::all();
        return view('vendedor.client.create',compact('fits'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $cliente = new Client;
        $this->validate($request, [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required | unique:clients',
            'birthday' => 'required | date',
            'addressVisit' => 'required',
            'fitSaco' => 'required',
            'tallaSaco' => 'required',
            'corteSaco' => 'required',
            'largoManga' => 'required',
            'largoEspalda' => 'required',
            'fitChaleco' => 'required',
            'tallaChaleco' => 'required',
            'corteChaleco' => 'required',
            'largoEspaldaChaleco' => 'required',
            'fitPantalon' => 'required',
            'tallaPantalon' => 'required',
            'largoExtPantalon' => 'required',
            'largoIntPantalon' => 'required'
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
        $cliente->fit_saco = $request->fitSaco;
        $cliente->talla_saco = $request->tallaSaco;
        $cliente->corte_saco = $request->corteSaco;
        $cliente->largo_manga = $request->largoManga;
        $cliente->largo_espalda = $request->largoEspalda;
        $cliente->notas_saco = $request->notasSaco;
        $cliente->fit_pantalon = $request->fitPantalon;
        $cliente->talla_pantalon = $request->tallaPantalon;
        $cliente->largo_pantalon_ext = $request->largoExtPantalon;
        $cliente->largo_pantalon_int = $request->largoIntPantalon;
        $cliente->notas_pantalon = $request->notasPantalon;
        $cliente->fit_chaleco = $request->fitChaleco;
        $cliente->talla_chaleco = $request->tallaChaleco;
        $cliente->corte_chaleco = $request->corteChaleco;
        $cliente->largo_espalda_chaleco = $request->largoEspaldaChaleco;
        $cliente->notas_chaleco = $request->notasChaleco;
        $cliente->vendedor_id = Auth::id();
        $cliente->contacto = $request->contactoReferencia;
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
        if ($client->vendedor_id != Auth::id()) {
            return redirect('/vendedor/clientes');
        }
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
        $fits = Fit::all();
        if (!$cliente || $cliente->vendedor_id != Auth::id()) {
            return redirect('/vendedor/clientes');
        }
        return view('vendedor.client.edit',compact('cliente','fits'));
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

        if (!$cliente || $cliente->vendedor_id != Auth::id()) {
            return redirect('vendedor/clientes/'.$id.'/editar');
        }

        $this->validate($request, [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required',
            'birthday' => 'required | date',
            'addressVisit' => 'required',
            'fitSaco' => 'required',
            'tallaSaco' => 'required',
            'corteSaco' => 'required',
            'largoManga' => 'required',
            'largoEspalda' => 'required',
            'fitChaleco' => 'required',
            'tallaChaleco' => 'required',
            'corteChaleco' => 'required',
            'largoEspaldaChaleco' => 'required',
            'fitPantalon' => 'required',
            'tallaPantalon' => 'required',
            'largoExtPantalon' => 'required',
            'largoIntPantalon' => 'required'
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
        $cliente->fit_saco = $request->fitSaco;
        $cliente->talla_saco = $request->tallaSaco;
        $cliente->corte_saco = $request->corteSaco;
        $cliente->largo_manga = $request->largoManga;
        $cliente->largo_espalda = $request->largoEspalda;
        $cliente->notas_saco = $request->notasSaco;
        $cliente->fit_pantalon = $request->fitPantalon;
        $cliente->talla_pantalon = $request->tallaPantalon;
        $cliente->largo_pantalon_ext = $request->largoExtPantalon;
        $cliente->largo_pantalon_int = $request->largoIntPantalon;
        $cliente->notas_pantalon = $request->notasPantalon;
        $cliente->fit_chaleco = $request->fitChaleco;
        $cliente->talla_chaleco = $request->tallaChaleco;
        $cliente->corte_chaleco = $request->corteChaleco;
        $cliente->largo_espalda_chaleco = $request->largoEspaldaChaleco;
        $cliente->notas_chaleco = $request->notasChaleco;
        $cliente->vendedor_id = Auth::id();
        $cliente->contacto = $request->contactoReferencia;
        $cliente->save();

        return redirect('/vendedor/clientes');
    }
}
