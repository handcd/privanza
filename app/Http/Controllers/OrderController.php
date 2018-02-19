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
    public function indexForVendedor()
    {   
        /**
         * Òrdenes de la vista principal del Vendedor
         *
         * Todas las órdenes se paginan en grupos de 5 para no saturar la vista. 
         * No se pueden paginar las colecciones por lo que comprobamos que el estado que buscamos
         * se encuentre verdadero (p. ej. 'approved') y que el siguiente estado se encuentre en falso
         * (p. ej. 'production'). De esa forma podemos asegurar cual es el único status válido.
         *
         * Información Adicional: Cuando se trabaja con el seeder la información se llena de forma 
         *                        arbitraria por lo que muchas órdenes dan un falso positivo a este
         *                        tipo de validación.
         */

        // Órdenes sin aprobar 
        $noAprobadas = Auth::user()->orders()->where('approved','0')->paginate(5,['*'],'noAprobadas');

        // Órdenes aprobadas (pero no en producción)
        $aprobadas = Auth::user()
                        ->orders()
                        ->where('approved','1')
                        ->where('production','0')
                        ->paginate(5,['*'],'aprobadas');

        // Órdenes listas para recolección (pero no entregadas)
        $listosEntrega = Auth::user()
                            ->orders()
                            ->where('pickup','1')
                            ->where('delivered','0')
                            ->paginate(5,['*'],'recoger');

        // Órdenes cobradas
        $finalizados = Auth::user()->orders()->where('cobrado','1')->paginate(5,['*'],'finalizados');

        // Todas las ordenes paginadas en grupos de 15.
        $ordenes = Auth::user()->orders()->paginate(15,['*'],'general');

        return view('vendedor.order.home',compact('ordenes','aprobadas','noAprobadas','listosEntrega','finalizados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createForVendedor()
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
    public function storeForVendedor(Request $request)
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
    public function showForVendedor($id)
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
    public function editForVendedor($id)
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
    public function updateForVendedor(Request $request, $id)
    {
        return $request;
    }

    /**
     * Generate a PDF file for an specific Order
     *
     * @param $id
     * @return PDF file for stream
     */
    public function orderpdfForVendedor($id)
    {
        $orden = Order::find($id);
        
        if (!$orden || $orden->vendedor_id != Auth::id()) {
            return redirect('/vendedor/ordenes');
        }
        PDF::setOptions(['dpi' => 50]);

        return PDF::loadview('pdf.order',compact('orden'))->setPaper('a4', 'landscape')->stream('PRIV-OC'.$id.$orden->client->name.'.pdf');
    }
}
