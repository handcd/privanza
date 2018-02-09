<?php

namespace App\Http\Controllers;

use App\Vendedor;
use App\Order;
use App\Vest;
use App\Coat;
use App\Pants;
use App\Fit;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexVendedor()
    {
        $allOrders = Vendedor::find(Auth::id())->orders;
        $ordenes = Vendedor::find(Auth::id())->orders()->paginate(15);
        $aprobadas = $allOrders->where('approved','1');
        $noAprobadas = $allOrders->where('approved','0');
        $listosEntrega = $allOrders->where('recoger','1');
        $finalizados = $allOrders->where('cobrados','1');

        return view('vendedor.order.home',compact('ordenes','aprobadas','noAprobadas','listosEntrega','finalizados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = Vendedor::find(Auth::id())->clients;
        return view('vendedor.order.create',compact('clientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;

        $orden = new Order;
        $pantalon = new Pants;
        $chaleco = new Vest;
        $saco = new Coat;

        $this->validate($request, [
            'cliente' => 'required', //: "1",
            'tipoTela' => 'required', //: "isco",
            'codigoTelaCliente' => 'nullable', //: null,
            'codigoColorTelaCliente' => 'nullable', //: null,
            'mtsTelaCliente' => 'nullable', //: null,
            'codigoTelaIsco' => 'nullable', //: "123",
            'tipoForro' => 'required', //: "cliente",
            'codigoForroCliente' => 'nullable', //: "123123",
            'codigoColorForroCliente' => 'nullable', //: "azulito",
            'mtsForroCliente' => 'nullable', //: "13.4",
            'codigoForroIsco' => 'nullable', //: null,
            'codigoBoton' => 'required', //: "123123",
            'colorBoton' => 'required', //: "verde",
            'etiquetaTela' => 'nullable', //: "on",
            'etiquetaMarca' => 'nullable', //: "on",
            'marcaEtiqueta' => 'required', //: "ISCO",
            'tipoGancho' => 'required', //: "1",
            'perGancho' => 'required', //: "tipoportatrajeees",
            'tipoPortatrajes' => 'required', //: "1",
            'botonesFrente' => 'required', //: "1",
            'aberturasDetras' => 'required', //: "1",
            'tipoSolapa' => 'required', //: "2",
            'tipoOjalSolapa' => 'required', //: "1",
            'colorOjalSolapa' => 'required', //: "rojito",
            'botonesMagnas' => 'required', //: "3",
            'tipoOjalManga' => 'required', //: "1",
            'colorOjalManga' => 'required', //: "Amarillito",
            'posicionOjalesManga' => 'required', //: "0",
            'ojalesActivosManga' => 'required', //: "4",
            'bolsExtParche' => 'nullable', //: "on",
            'bolsExtCartera' => 'nullable', // "on",
            'bolsExtVivo' => 'nullable', //: "on",
            'bolsExtCarteraDiag' => 'nullable', //: "on",
            'bolsExtVivoDiag' => 'nullable', //: "on",
            'bolsExtCarteraCont' => 'nullable', //: "on",
            'pickstitch' => 'nullable', //: "on",
            'pinponInterno' => 'nullable', //: "on",
            'pinponInternoColor' => 'required', //: "morado",
            'pinponInternoCodigo' => 'required', //: "123123",
            'biesInterno' => 'nullable', //: "on",
            'biesInternoColor' => 'required', //: "naranja",
            'biesInternoCodigo' => 'required', //: "aosdifjao",
            'bolsaPechoDer' => 'nullable', //: "on",
            'bolsaPechoIzq' => 'nullable', //: "on",
            'cigarrera' => 'nullable', //: "on",
            'plumera' => 'nullable', //: "on",
            'forroBolsasInt' => 'required', //: "verde",
            'bolsasDelanteras' => 'required', //: "2",
            'bolsasTraseras' => 'required', //: "2",
            'bolsasTraserasVivo' => 'required', //: "0",
            'bolsasTraserasCerrado' => 'required', //: "1",
            'ribete' => 'nullable', //: "on",
            'colorRibete' => 'required', //: "azul",
            'forroPiernas' => 'nullable', //: "on",
            'colorMedioForro' => 'required', //: "verde",
            'tipoDobladillo' => 'nullable', //: "1",
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vendedor  $vendedor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orden = Order::find($id);
        if (!$orden || $orden->vendedor_id != Auth::id()) {
            Session::flash('danger','La orden que deseas ver no puede ser mostrada porque no tienes autorización para verla o no existe.');
            return redirect('/vendedor/ordenes');
        }

        return view('vendedor.order.show',compact('orden'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vendedor  $vendedor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orden = Order::find($id);

        if (!$orden || $orden->vendedor_id != Auth::id() || $orden->approved) {
            Session::flash('danger','La orden que deseas editar no puede ser mostrada porque no tienes autorización para verla o no existe.');
            return redirect('/vendedor/ordenes');
        }
        return view('vendedor.order.edit',compact('orden'));
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
        return $request;
    }

    /**
     * Generate a PDF file for an specific Order
     *
     * @param $id
     * @return PDF file for stream
     */
    public function orderpdf($id)
    {
        $orden = Order::find($id);
        
        if (!$orden || $orden->vendedor_id != Auth::id()) {
            return redirect('/vendedor/ordenes');
        }
        PDF::setOptions(['dpi' => 50]);

        return PDF::loadview('pdf.order',compact('orden'))->setPaper('a4', 'landscape')->stream('PRIV-OC'.$id.$orden->client->name.'.pdf');
    }
}
