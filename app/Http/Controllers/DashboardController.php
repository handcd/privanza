<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Client;
use App\Order;
use App\Event;
use Auth;
use Session;
use DB;

class DashboardController extends Controller
{
    public function vendedorDash(Request $request)
    {
    	$currentTime = Carbon::now();

	    $clientes = Client::where('vendedor_id', Auth::id())
	    					->get();

	    $birthdaysMonth = Client::where('vendedor_id', Auth::id())
	    						->whereMonth('birthday',$currentTime->month)
	    						->orderBy('birthday','asc')
	    						->get();

	    $birthdaysToday = Client::where('vendedor_id', Auth::id())
	    						->whereMonth('birthday',$currentTime->month)
	    						->whereDay('birthday',$currentTime->day)
	    						->orderBy('birthday','asc')
	    						->get();

	    $birthdaysWeek = Client::where('vendedor_id', Auth::id())
	    						->whereMonth('birthday',$currentTime->month)
	    						->whereDay('birthday','>=',$currentTime->day)
	    						->whereDay('birthday','<=',$currentTime->addWeek()->day)
	    						->get();

	    $ordenes = Order::where('vendedor_id',Auth::id())
	    					->whereYear('created_at',$currentTime->year)
	    					->get();

	    $montoVentas = array();
	    for ($i=1; $i < 13; $i++) { 
	    	$montoVentas[] = Order::where('vendedor_id',Auth::id())
	    							->whereYear('created_at',$currentTime->year)
	    							->whereMonth('created_at',$i)
	    							->sum('precio');
	    }

	    $prendasVendidas = array();
	    for ($i=1; $i < 13; $i++) { 
	    	$prendasVendidas[] = Order::where('vendedor_id', Auth::id())
	    								->where('created_at','>=', Carbon::now()->month($i)->startOfMonth())
	    								->where('created_at','<=', Carbon::now()->month($i)->endOfMonth())
	    								->count();
	    }

	    $ordenes = Auth::user()->orders;
	    $recoger = Order::where('vendedor_id', Auth::id())->where('pickup','1')->get();

	    // Todos los eventos
	    $eventos = Auth::user()->events;

	    // Citas del día
        $eventosHoy = $eventos->filter(function ($evento) {
            return ($evento->fechahora >= Carbon::today() && $evento->fechahora < Carbon::tomorrow());
        });

        // Citas de la semana
        $eventosSemana = $eventos->filter(function ($evento) {
            return ($evento->fechahora >= Carbon::today() && $evento->fechahora <= Carbon::today()->addWeek());
        });

	    // Warning if there are Orders ready for pickup.
	    if ($recoger->count() > 0) {
	    	$request->session()->flash('warning', 'Tienes pedidos listos para ser recogidos.');
	    }

	    return view('vendedor.dashboard', compact('ordenes','birthdaysToday','birthdaysWeek','birthdaysMonth','recoger','clientes','montoVentas','prendasVendidas','eventosHoy','eventosSemana'));
    }

    public function validadorDash()
    {
    	return 'Hola';
    }

    public function adminDash()
    {
    	return 'Holaaa';
    }
}
