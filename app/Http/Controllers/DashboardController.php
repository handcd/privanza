<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Client;
use App\Order;
use Auth;
use Session;
use DB;

class DashboardController extends Controller
{
    public function vendedorDash()
    {
    	$currentTime = Carbon::now();

	    $clientes = Client::where('vendedor_id', Auth::id())
	    					->get();

	    $birthdaysMonth = Client::whereMonth('birthday',$currentTime->month)
	    				 		->where('vendedor_id', Auth::id())
	    						->orderBy('birthday','asc')
	    						->get();

	    $birthdaysToday = Client::whereMonth('birthday',$currentTime->month)
	    						->where('vendedor_id', Auth::id())
	    						->whereDay('birthday',$currentTime->day)
	    						->orderBy('birthday','asc')
	    						->get();

	    $birthdaysWeek = Client::whereMonth('birthday',$currentTime->month)
	    						->where('vendedor_id', Auth::id())
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
	    $ordenes = Auth::user()->orders;
	    $recoger = Order::where('pickup','1')->get();

	    // Warning if there are Orders ready for pickup.
	    // if ($recoger->count() > 0) {
	    // 	Session::flash('warning', 'Tienes pedidos listos para ser recogidos.');
	    // }

	    return view('vendedor.dashboard', compact('ordenes','birthdaysToday','birthdaysWeek','birthdaysMonth','recoger','clientes'));
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
