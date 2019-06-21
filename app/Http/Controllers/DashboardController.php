<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Client;
use App\Order;
use App\Event;

// Facades
use Auth;
use Carbon\Carbon;
use Session;
use DB;

class DashboardController extends Controller
{
	/**
	 * Get the dashboard for the Vendedor
	 *
	 * @param Request $request
	 * @return view
	 */
    public function vendedorDash(Request $request)
    {
    	// La fecha actual
    	$currentTime = Carbon::now();

    	// Los clientes del vendedor
	    $clientes = Client::where('vendedor_id', Auth::id())
	    					->get();

	    // Los cumpleaños del mes
	    $birthdaysMonth = Client::where('vendedor_id', Auth::id())
	    						->whereMonth('birthday',$currentTime->month)
	    						->orderBy('birthday','asc')
	    						->get();
	    
	    // Los cumpleaños del día
	    $birthdaysToday = Client::where('vendedor_id', Auth::id())
	    						->whereMonth('birthday',$currentTime->month)
	    						->whereDay('birthday',$currentTime->day)
	    						->orderBy('birthday','asc')
	    						->get();

	    // Los cumpleaños de la semana
	    $birthdaysWeek = Client::where('vendedor_id', Auth::id())
	    						->whereMonth('birthday',$currentTime->month)
	    						->whereDay('birthday','>=',$currentTime->day)
	    						->whereDay('birthday','<=',$currentTime->addWeek()->day)
	    						->get();

	    // Las órdenes de este año
	    $ordenes = Order::where('vendedor_id',Auth::id())
	    					->whereYear('created_at',$currentTime->year)
	    					->get();

	    // Datos para gráfica de monto de ventas mensual
	    $montoVentas = array();
	    for ($i=1; $i < 13; $i++) { 
	    	$montoVentas[] = Order::where('vendedor_id',Auth::id())
	    							->whereYear('created_at',$currentTime->year)
	    							->whereMonth('created_at',$i)
	    							->sum('precio');
	    }

	    // Gráfica de prendas vendidas en el mes
	    $prendasVendidas = array();
	    for ($i=1; $i < 13; $i++) { 
	    	$prendasVendidas[] = Order::where('vendedor_id', Auth::id())
	    								->where('created_at','>=', Carbon::now()->month($i)->startOfMonth())
	    								->where('created_at','<=', Carbon::now()->month($i)->endOfMonth())
	    								->count();
	    }

	    // Gráfica de Ventas del mes
	    $ventasPorSemana = array();
	    for ($i=0; $i < 4; $i++) { 
	    	$ventasPorSemana[] = Order::where('vendedor_id',Auth::id())
	    							->where('created_at','>=',Carbon::now()->startOfMonth()->addWeeks($i)->startOfWeek())
	    							->where('created_at','<=',Carbon::now()->startOfMonth()->addWeeks($i)->endOfWeek())
	    							->count();
	    }

	    // Ordenes Generales
	    $ordenes = Auth::user()->orders;

	    // Total Vendido el Mes
	    $totalVendido = $ordenes
	    					->filter(function($order){
	    						return $order->currentStatus() === 'cobrado' && $order->created_at >= Carbon::now()->startOfMonth();
	    					})
	    					->sum('precio');

	    // Órdenes sin Aprobar
	    $sinAprobar = $ordenes
	    					->filter(function($order){
	    						return $order->currentStatus() === 'unapproved';
	    					})
	    					->count();

	    // Órdenes Aprobadas
	    $aprobadas = $ordenes
	    				->filter(function($order){
	    					return $order->currentStatus() === 'approved';
	    				})
	    				->count();

	    // Órdenes en Producción
	    $produccion = $ordenes
	    				->filter(function($order){
	    					return $order->currentStatus() === 'production';
	    				})
	    				->count();

	    // Órdenes listas para ser recogidas
	   	$recoleccion = $ordenes
	   					->filter(function($order){
	   						return $order->currentStatus() === 'pickup';
	   					})
	   					->count();

	   	// Órdenes entregadas
	   	$entregadas = $ordenes
	   					->filter(function($order){
	   						return $order->currentStatus() === 'delivered';
	   					})
	   					->count();

	   	// Órdenes Facturadas
	   	$facturadas = $ordenes
	   					->filter(function($order){
	   						return $order->currentStatus() === 'facturado';
	   					})
	   					->count();

	   	// Órdenes Cobradas
	   	$cobradas = $ordenes
	   					->filter(function($order){
	   						return $order->currentStatus() === 'cobrado';
	   					})
	   					->count();


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
	    if ($recoleccion > 0) {
	    	session()->flash('warning', 'Tienes pedidos listos para ser recogidos.');
	    }

	    return view('vendedor.dashboard',compact('birthdaysMonth','birthdaysWeek','birthdaysToday','montoVentas','prendasVendidas','ventasPorSemana','totalVendido','sinAprobar','aprobadas','produccion','recoleccion','entregadas','facturadas','cobradas','eventosHoy','eventosSemana'));
    }

    /**
     * Get the dashboard for the Validador
     *
     * @param Request $request
     * @return view
     */
    public function validadorDash()
    {
    	// La fecha actual
    	$currentTime = Carbon::now();

    	// Los clientes del vendedor
	    $clientes = Client::all();

	    // Los cumpleaños del mes
	    $birthdaysMonth = Client::whereMonth('birthday',$currentTime->month)
	    						->orderBy('birthday','asc')
	    						->get();
	    
	    // Los cumpleaños del día
	    $birthdaysToday = Client::whereMonth('birthday',$currentTime->month)
	    						->whereDay('birthday',$currentTime->day)
	    						->orderBy('birthday','asc')
	    						->get();

	    // Los cumpleaños de la semana
	    $birthdaysWeek = Client::whereMonth('birthday',$currentTime->month)
	    						->whereDay('birthday','>=',$currentTime->day)
	    						->whereDay('birthday','<=',$currentTime->addWeek()->day)
	    						->get();

	    // Las órdenes de este año
	    $ordenes = Order::whereYear('created_at',$currentTime->year)->get();

	    // Datos para gráfica de monto de ventas mensual
	    $montoVentas = array();
	    for ($i=1; $i < 13; $i++) { 
	    	$montoVentas[] = Order::whereYear('created_at',$currentTime->year)
	    							->whereMonth('created_at',$i)
	    							->sum('precio');
	    }

	    // Gráfica de prendas vendidas en el mes
	    $prendasVendidas = array();
	    for ($i=1; $i < 13; $i++) { 
	    	$prendasVendidas[] = Order::where('created_at','>=', Carbon::now()->month($i)->startOfMonth())
	    								->where('created_at','<=', Carbon::now()->month($i)->endOfMonth())
	    								->count();
	    }

	    // Gráfica de Ventas del mes
	    $ventasPorSemana = array();
	    for ($i=0; $i < 4; $i++) { 
	    	$ventasPorSemana[] = Order::where('created_at','>=',Carbon::now()->startOfMonth()->addWeeks($i)->startOfWeek())
	    							->where('created_at','<=',Carbon::now()->startOfMonth()->addWeeks($i)->endOfWeek())
	    							->count();
	    }

	    // Ordenes Generales
	    $ordenes = Order::all();
	    // Total Vendido el Mes
	    $totalVendido = $ordenes
	    					->filter(function($order){
	    						return $order->currentStatus() === 'cobrado' && $order->created_at >= Carbon::now()->startOfMonth();
	    					})
	    					->sum('precio');

	    // Órdenes sin Aprobar
	    $sinAprobar = $ordenes
	    					->filter(function($order){
	    						return $order->currentStatus() === 'unapproved';
	    					})
	    					->count();

	    // Órdenes Aprobadas
	    $aprobadas = $ordenes
	    				->filter(function($order){
	    					return $order->currentStatus() === 'approved';
	    				})
	    				->count();

	    // Órdenes en Producción
	    $produccion = $ordenes
	    				->filter(function($order){
	    					return $order->currentStatus() === 'production';
	    				})
	    				->count();

	    // Órdenes listas para ser recogidas
	   	$recoleccion = $ordenes
	   					->filter(function($order){
	   						return $order->currentStatus() === 'pickup';
	   					})
	   					->count();

	   	// Órdenes entregadas
	   	$entregadas = $ordenes
	   					->filter(function($order){
	   						return $order->currentStatus() === 'delivered';
	   					})
	   					->count();

	   	// Órdenes Facturadas
	   	$facturadas = $ordenes
	   					->filter(function($order){
	   						return $order->currentStatus() === 'facturado';
	   					})
	   					->count();

	   	// Órdenes Cobradas
	   	$cobradas = $ordenes
	   					->filter(function($order){
	   						return $order->currentStatus() === 'cobrado';
	   					})
	   					->count();


	    // Todos los eventos
	    $eventos = Event::all();

	    // Citas del día
        $eventosHoy = $eventos->filter(function ($evento) {
            return ($evento->fechahora >= Carbon::today() && $evento->fechahora < Carbon::tomorrow());
        });

        // Citas de la semana
        $eventosSemana = $eventos->filter(function ($evento) {
            return ($evento->fechahora >= Carbon::today() && $evento->fechahora <= Carbon::today()->addWeek());
        });

	    // Warning if there are Orders ready for pickup.
	    if ($recoleccion > 0) {
	    	session()->flash('warning', 'Tienes pedidos listos para ser recogidos.');
	    }

	    return view('validador.dashboard',compact('birthdaysMonth','birthdaysWeek','birthdaysToday','montoVentas','prendasVendidas','ventasPorSemana','totalVendido','sinAprobar','aprobadas','produccion','recoleccion','entregadas','facturadas','cobradas','eventosHoy','eventosSemana'));
    }

    /**
     * Get the dashboard for the Admin
     *
     * @param Request $request
     * @return view
     */
    public function adminDash()
    {
    	// La fecha actual
    	$currentTime = Carbon::now();

    	// Los clientes del vendedor
	    $clientes = Client::all();

	    // Los cumpleaños del mes
	    $birthdaysMonth = Client::whereMonth('birthday',$currentTime->month)
	    						->orderBy('birthday','asc')
	    						->get();
	    
	    // Los cumpleaños del día
	    $birthdaysToday = Client::whereMonth('birthday',$currentTime->month)
	    						->whereDay('birthday',$currentTime->day)
	    						->orderBy('birthday','asc')
	    						->get();

	    // Los cumpleaños de la semana
	    $birthdaysWeek = Client::whereMonth('birthday',$currentTime->month)
	    						->whereDay('birthday','>=',$currentTime->day)
	    						->whereDay('birthday','<=',$currentTime->addWeek()->day)
	    						->get();

	    // Las órdenes de este año
	    $ordenes = Order::whereYear('created_at',$currentTime->year)->get();

	    // Datos para gráfica de monto de ventas mensual
	    $montoVentas = array();
	    for ($i=1; $i < 13; $i++) { 
	    	$montoVentas[] = Order::whereYear('created_at',$currentTime->year)
	    							->whereMonth('created_at',$i)
	    							->sum('precio');
	    }

	    // Gráfica de prendas vendidas en el mes
	    $prendasVendidas = array();
	    for ($i=1; $i < 13; $i++) { 
	    	$prendasVendidas[] = Order::where('created_at','>=', Carbon::now()->month($i)->startOfMonth())
	    								->where('created_at','<=', Carbon::now()->month($i)->endOfMonth())
	    								->count();
	    }

	    // Gráfica de Ventas del mes
	    $ventasPorSemana = array();
	    for ($i=0; $i < 4; $i++) { 
	    	$ventasPorSemana[] = Order::where('created_at','>=',Carbon::now()->startOfMonth()->addWeeks($i)->startOfWeek())
	    							->where('created_at','<=',Carbon::now()->startOfMonth()->addWeeks($i)->endOfWeek())
	    							->count();
	    }

	    // Ordenes Generales
	    $ordenes = Order::all();
	    // Total Vendido el Mes
	    $totalVendido = $ordenes
	    					->filter(function($order){
	    						return $order->currentStatus() === 'cobrado' && $order->created_at >= Carbon::now()->startOfMonth();
	    					})
	    					->sum('precio');

	    // Órdenes sin Aprobar
	    $sinAprobar = $ordenes
	    					->filter(function($order){
	    						return $order->currentStatus() === 'unapproved';
	    					})
	    					->count();

	    // Órdenes Aprobadas
	    $aprobadas = $ordenes
	    				->filter(function($order){
	    					return $order->currentStatus() === 'approved';
	    				})
	    				->count();

	    // Órdenes en Producción
	    $produccion = $ordenes
	    				->filter(function($order){
	    					return $order->currentStatus() === 'production';
	    				})
	    				->count();

	    // Órdenes listas para ser recogidas
	   	$recoleccion = $ordenes
	   					->filter(function($order){
	   						return $order->currentStatus() === 'pickup';
	   					})
	   					->count();

	   	// Órdenes entregadas
	   	$entregadas = $ordenes
	   					->filter(function($order){
	   						return $order->currentStatus() === 'delivered';
	   					})
	   					->count();

	   	// Órdenes Facturadas
	   	$facturadas = $ordenes
	   					->filter(function($order){
	   						return $order->currentStatus() === 'facturado';
	   					})
	   					->count();

	   	// Órdenes Cobradas
	   	$cobradas = $ordenes
	   					->filter(function($order){
	   						return $order->currentStatus() === 'cobrado';
	   					})
	   					->count();


	    // Todos los eventos
	    $eventos = Event::all();

	    // Citas del día
        $eventosHoy = $eventos->filter(function ($evento) {
            return ($evento->fechahora >= Carbon::today() && $evento->fechahora < Carbon::tomorrow());
        });

        // Citas de la semana
        $eventosSemana = $eventos->filter(function ($evento) {
            return ($evento->fechahora >= Carbon::today() && $evento->fechahora <= Carbon::today()->addWeek());
        });

	    // Warning if there are Orders ready for pickup.
	    if ($recoleccion > 0) {
	    	session()->flash('warning', 'Tienes pedidos listos para ser recogidos.');
	    }

	    return view('admin.dashboard',compact('birthdaysMonth','birthdaysWeek','birthdaysToday','montoVentas','prendasVendidas','ventasPorSemana','totalVendido','sinAprobar','aprobadas','produccion','recoleccion','entregadas','facturadas','cobradas','eventosHoy','eventosSemana'));
    }
}
