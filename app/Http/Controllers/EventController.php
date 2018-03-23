<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Vendedor;
use App\Event;
use App\Client;
use App\Admin;

// Facades
use Carbon\Carbon;
use Auth;
use Session;
use Notification;

// Notifications
use App\Notifications\ValidadorNewEvent;    // Cuando el Vendedor/Admin añaden cita
use App\Notifications\ValidadorEditedEvent; // Cuando el Vendedor/Admin editan cita
use App\Notifications\VendedorNewEvent;     // Cuando el Validador/Admin añaden cita
use App\Notifications\VendedorEditedEvent;  // Cuando el Validador/Admin editan cita
use App\Notifications\AdminNewEvent;        // Cuando el Validador/Vendedor añaden cita
use App\Notifications\AdminEditedEvent;     // Cuando el Validador/Vendedor editan cita

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexForVendedor()
    {
        // Citas Principales
        $eventos = Auth::user()->events;

        // Citas del día
        $eventosHoy = $eventos->filter(function ($evento) {
            return ($evento->fechahora >= Carbon::today() && $evento->fechahora < Carbon::tomorrow());
        });

        // Citas de la semana
        $eventosSemana = $eventos->filter(function ($evento) {
            return ($evento->fechahora >= Carbon::today() && $evento->fechahora <= Carbon::today()->addWeek());
        });

        // Citas Principales con Paginación
        $eventos = Auth::user()->events()->paginate(15);

        return view('vendedor.event.home',compact('eventos','eventosHoy','eventosSemana'));
    }

    public function indexForValidador()
    {
        // Todas las citas
        $eventos = Event::paginate(15,['*'],'citas');

        // Citas del día
        $eventosHoy = Event::where('fechahora','>=',Carbon::today())
                            ->where('fechahora','<',Carbon::tomorrow())
                            ->paginate(5,['*'],'citasHoy');

        // Citas de la semana
        $eventosSemana = Event::where('fechahora','>=',Carbon::today())
                                ->where('fechahora','<',Carbon::today()->addWeek())
                                ->paginate(5,['*'],'citasSemana');


        return view('validador.event.home',compact('eventos','eventosHoy','eventosSemana'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createForVendedor()
    {
        $clientes = Vendedor::find(Auth::id())->clients;
        return view('vendedor.event.create',compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createForValidador()
    {
        $clientes = Client::all();
        $vendedores = Vendedor::all();
        return view('validador.event.create',compact('clientes','vendedores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeForVendedor(Request $request)
    {
        $evento = new Event;
        $this->validate($request, [
            'cliente' => 'required|exists:clients,id',
            'fechahora' => 'required|date',
            'notes' => 'nullable'
        ]);

        $cliente = Client::find($request->cliente);
        if (!$cliente) {
            $request->session()->flash('danger', 'Ocurrió un error al encontrar el cliente que seleccionaste, intenta de nuevo.');
            return redirect()->back()->withInput();
        }

        $evento->vendedor_id = Auth::id();
        $evento->client_id = $cliente->id;
        $evento->fechahora = Carbon::parse($request->fechahora)->toDateTimeString();
        $evento->notes = $request->notes;
        $evento->save();

        // Notifications
        Notification::send(Validador::all(),new ValidadorNewEvent($evento));
        Notification::send(Admin::all(), new AdminNewEvent($evento));

        // Feedback to the user
        $request->session()->flash('success', 'Se ha añadido correctamente la cita.');

        return redirect('/vendedor/citas');
    }

    /**
     * Store a newly created resource from the Validador in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeForValidador(Request $request)
    {
        $evento = new Event;

        $this->validate($request,[
            'cliente' => 'required|exists:clients,id',
            'fechahora' => 'required|date',
            'notes' => 'nullable'
        ]);

        $evento->client_id = $request->cliente;
        $evento->vendedor_id = $evento->client->vendedor->id;
        $evento->fechahora = Carbon::parse($request->fechahora)->toDateTimeString();
        $evento->notes = $request->notes;

        $evento->save();

        // Notifications
        Notification::send($evento->vendedor,new VendedorNewEvent($evento));
        Notification::send(Admin::all(), new AdminNewEvent($evento));

        // Feedback to the user
        $request->session()->flash('success', '¡Listo! Hemos añadido la cita y notificado a '.$evento->vendedor->name);

        return redirect('/validador/citas');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function showForVendedor($id)
    {
        $evento = Event::find($id);
        if (!$evento || $evento->vendedor_id != Auth::id()) {
            Session::flash('danger','La cita que deseas consultar no puede ser mostrada porque no existe o no tienes autorización para verla.');
            return redirect('/vendedor/citas');
        }
        return view('vendedor.event.show',compact('evento'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function showForValidador($id)
    {
        $evento = Event::find($id);
        if (!$evento) {
            Session::flash('danger','La cita que deseas consultar no puede ser mostrada porque no existe.');
            return redirect('/validador/citas');
        }
        return view('validador.event.show',compact('evento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function editForVendedor($id)
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
     * Shw the form for editing the specified resource.
     *
     * @param \App\Event $id
     * @param \Illuminate\Http\Response
     */
    public function editForValidador($id)
    {
        $evento = Event::find($id);
        if (!$evento) {
            Session::flash('danger', 'La citas que indicas no existe o no puede ser ubicada.');
            return redirect('/validador/citas');
        }

        $clientes = Client::all();
        return view('validador.event.edit',compact('evento','clientes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function updateForVendedor(Request $request, $id)
    {
        $evento = Event::find($id);

        $this->validate($request, [
            'cliente' => 'required|exists:clients,id',
            'fechahora' => 'required|date',
            'notes' => 'nullable'
        ]);

        $cliente = Client::find($request->cliente);

        if (!$cliente || !$evento || Carbon::parse($evento->fechahora)->isPast() || $evento->vendedor_id != Auth::id()) {
            $request->session()->flash('warning', 'Hemos encontrado problemas con la información proporcionada para la edición del evento.');
            return redirect()->back()->withInput();
        }

        $evento->vendedor_id = Auth::id();
        $evento->client_id = $cliente->id;
        $evento->fechahora = Carbon::parse($request->fechahora)->toDateTimeString();
        $evento->notes = $request->notes;
        $evento->save();

        // Notifications
        Notification::send(Validador::all(), new ValidadorEditedEvent($evento));
        Notification::send(Admin::all(), new AdminEditedEvent($evento));

        // Feedback to the user
        $request->session()->flash('success', 'Se ha editado correctamente la cita y se ha notificado al Validador y Administrador.');
        return redirect('/vendedor/citas');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function updateForValidador(Request $request, $id)
    {
        $evento = Event::find($id);

        $this->validate($request, [
            'cliente' => 'required|exists:clients,id',
            'fechahora' => 'required|date',
            'notes' => 'nullable'
        ]);

        $cliente = Client::find($request->cliente);

        $evento->vendedor_id = $cliente->vendedor->id;
        $evento->client_id = $cliente->id;
        $evento->fechahora = Carbon::parse($request->fechahora)->toDateTimeString();
        $evento->notes = $request->notes;
        $evento->save();

        // Notifications
        Notification::send($evento->vendedor, new VendedorEditedEvent($evento));
        Notification::send(Admin::all(), new AdminEditedEvent($evento));

        // Feedback to the user
        $request->session()->flash('success', 'Se ha editado correctamente la cita y se ha enviado una notificación al Vendedor.');

        return redirect('/vendedor/citas');
    }
}
