<?php

namespace App\Http\Controllers;

use App\Vendedor;
use App\Event;
use App\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Http\Controllers\Controller;
use Session;

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
        $eventos = Auth::user()->events;

        // Citas del día
        $eventosHoy = $eventos->filter(function ($evento) {
            return ($evento->fechahora >= Carbon::today() && $evento->fechahora <= Carbon::tomorrow());
        });

        // Citas de la semana
        $eventosSemana = $eventos->filter(function ($evento) {
            return ($evento->fechahora >= Carbon::today() && $evento->fechahora <= Carbon::today()->addWeek());
        });

        // Citas Principales con Paginación
        $eventos = Auth::user()->events()->paginate(15);

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
            $request->session()->flash('danger', 'Ocurrió un error al encontrar el cliente que seleccionaste, intenta de nuevo.');
            return redirect()->back()->withInput();
        }

        $evento->vendedor_id = Auth::id();
        $evento->client_id = $cliente->id;
        $evento->fechahora = Carbon::parse($request->fechahora)->toDateTimeString();
        $evento->save();

        $request->session()->flash('success', 'Se ha añadido correctamente el evento.');
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
            Session::flash('danger','La cita que deseas consultar no puede ser mostrada porque no existe o no tienes autorización para verla.');
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
        if (!$evento || $evento->vendedor_id != Auth::id() || Carbon::parse($evento->fechahora)->isPast() ) {
            Session::flash('danger','No es posible editar la cita que buscas debido a que no existe, no tienes autorización para editarla o su fecha ya pasó.');
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
        $evento = Event::find($id);

        $this->validate($request, [
            'cliente' => 'required',
            'fechahora' => 'required|date'
        ]);

        $cliente = Client::find($request->cliente);

        if (!$cliente || !$evento || Carbon::parse($evento->fechahora)->isPast() || $evento->vendedor_id != Auth::id()) {
            $request->session()->flash('warning', 'Hemos encontrado problemas con la información proporcionada para la edición del evento.');
            return redirect()->back()->withInput();
        }

        $evento->vendedor_id = Auth::id();
        $evento->client_id = $cliente->id;
        $evento->fechahora = Carbon::parse($request->fechahora)->toDateTimeString();
        $evento->save();

        $request->session()->flash('success', 'Se ha editado correctamente el evento.');
        return redirect('/vendedor/citas');
    }
}
