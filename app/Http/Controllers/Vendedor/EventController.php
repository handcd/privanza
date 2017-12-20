<?php

namespace App\Http\Controllers\Vendedor;

use App\Vendedor;
use App\Event;
use App\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Citas Principales
        $eventos = Vendedor::find(Auth::id())->events;

        // Citas del día
        $eventosHoy = $eventos->filter(function ($evento) {
            return ($evento->fechahora >= Carbon::today() && $evento->fechahora <= Carbon::tomorrow());
        });

        // Citas de la semana
        $eventosSemana = $eventos->filter(function ($evento) {
            return ($evento->fechahora >= Carbon::today() && $evento->fechahora <= Carbon::today()->addWeek());
        });

        return view('vendedor.event.home',compact('eventos','eventosHoy','eventosSemana'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = Vendedor::find(Auth::id())->clients;
        return view('vendedor.event.create',compact('clientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $evento = new Event;
        $this->validate($request, [
            'cliente' => 'required',
            'fechahora' => 'required|date'
        ]);

        $cliente = Client::find($request->cliente);
        if (!$cliente) {
            $request->session()->flash('errors', 'Ocurrió un error al encontrar el cliente que seleccionaste, intenta de nuevo.');
            return redirect()->back()->withInput();
        }

        $evento->vendedor_id = Auth::id();
        $evento->client_id = $cliente->id;
        $evento->fechahora = Carbon::parse($request->fechahora)->toDateTimeString();
        $evento->save();

        return redirect('/vendedor/citas');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $evento = Event::find($id);
        if (!$evento || $evento->vendedor_id != Auth::id()) {
            return redirect('/vendedor/citas');
        }
        return view('vendedor.event.show',compact('evento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $evento = Event::find($id);
        if (!$evento || $evento->vendedor_id != Auth::id()) {
            return redirect('/vendedor/citas');
        }
        $clientes = Vendedor::find(Auth::id())->clients;
        return view('vendedor.event.edit',compact('evento','clientes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $request;
    }
}
