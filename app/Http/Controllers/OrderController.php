<?php

namespace App\Http\Controllers;

use App\Vendedor;
use App\Order;
use App\Vest;
use App\Coat;
use App\Pants;
use App\Fit;
use Auth;
use App\Jobs\SendNewOrderEmails;
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
        //return $request;

        $orden = new Order;
        $pantalon = new Pants;
        $chaleco = new Vest;
        $saco = new Coat;

        $this->validate($request, [
            // Datos Orden
            'cliente' => 'required|numeric', // "1",
            // 'saco' => 'required', // "on",
            // 'chaleco' => 'required', // "on",
            // 'pantalon' => 'required', // "on",
            'tipoTela' => 'required', // "cliente",
            // 'codigoTelaCliente' => 'required', // "suodfoashudf",
            // 'codigoColorTelaCliente' => 'required', // "aisdhfaidhsf",
            // 'mtsTelaCliente' => 'required', // "123.3",
            // 'codigoTelaIsco' => 'required', // null,
            'tipoForro' => 'required', // "cliente",
            // 'codigoForroCliente' => 'required', // "123123",
            // 'codigoColorForroCliente' => 'required', // "asdasd",
            // 'mtsForroCliente' => 'required', // "12.1",
            // 'codigoForroIsco' => 'required', // null,
            'codigoBoton' => 'required', // "asoufhs",
            'colorBoton' => 'required', // "sadiuhasdiu",
            // 'etiquetaTela' => 'required', // "on",
            // 'etiquetaMarca' => 'required', // "on",
            // 'marcaEtiqueta' => 'required', // "asdasd",
            'tipoGancho' => 'required', // "1",
            // 'perGancho' => 'required', // "asdasdasd",
            'tipoPortatrajes' => 'required', // "1",
            // 'perPortatrajes' => 'required', // "asdasd",

            // Datos de Saco Externo
            // 'tipoSolapa' => 'required', // "1",
            // 'tipoOjalSolapa' => 'required', // "3",
            // 'colorOjalSolapa' => 'required', // "Vino",
            // 'otroColorOjalSolapa' => 'required', // "asdasd",
            // 'botonesFrente' => 'required', // "2",
            // 'aberturasDetras' => 'required', // "1",
            // 'botonesMagnas' => 'required', // "4",
            // 'tipoOjalManga' => 'required', // "1",
            // 'colorOjalMangas' => 'required', // "Azul Marino",
            // 'otroColorOjalMangas' => 'required', // "weqweqe",
            // 'posicionOjalesManga' => 'required', // "0",
            // 'ojalesActivosManga' => 'required', // "on",
            // 'bolsasExt' => 'required', // "6",
            // 'pickstitch' => 'required', // "on",
            // 'pickstitchfilos' => 'required', // "on",
            // 'pickstitchaletilla' => 'required', // "on",
            // 'pickstitchcartera' => 'required', // "on",
            // 'sinaletilla' => 'required', // "on",

            // Datos de Saco Interno
            // 'tipoVista' => 'required', // "0",
            // 'balsamRayasForroMangas' => 'required', // "on",
            // 'otroForroInternoMangas' => 'required', // "qweqwe",
            // 'pinPointInterno' => 'required', // "on",
            // 'colorPinPointInterno' => 'required', // "Negro",
            // 'otroColorPinPoint' => 'required', // "asdasd",
            // 'pinPointInternoCodigo' => 'required', // "asdasd",
            // 'biesInterno' => 'required', // "on",
            // 'colorBies' => 'required', // "Gris Oxford",
            // 'otroColorBies' => 'required', // "asdasd",
            // 'biesInternoCodigo' => 'required', // "asdasd",
            // 'colorPuntada' => 'required', // "Gris Oxford",
            // 'otroColorPuntada' => 'required', // "asdasd",
            // 'bolsasInt' => 'required', // "3 Bolsas Cigarrera",
            // 'bolsasInternasColor' => 'required', // "asdada",
            // 'vivosBolsasInternasCuerpo' => 'required', // "on",
            // 'otroVivosBolsasInternas' => 'required', // "asdasd",
            // 'puntadaFilosSacoInt' => 'required', // "on",
            // 'puntadaAletillasSacoInt' => 'required', // "on",
            // 'puntadaCarterasSacoInt' => 'required', // "on",

            // Datos de Chaleco
            // 'cuelloChaleco' => 'required', // "0",
            // 'bolsasChaleco' => 'required', // "1",
            // 'forroTela' => 'required', // "0",
            // 'ajustadorChaleco' => 'required', // "on",

            // Datos Pantalón
            // 'tipoPase' => 'required', // "0",
            // 'numPliegues' => 'required', // "1",
            // 'bolsasTraseras' => 'required', // "0",
            // 'tipoVivo' => 'required', // "1",
            // 'colorOjaleraEncuarte' => 'required', // "Gris Oxford",
            // 'otroColorOjaleraEncuarte' => 'required', // "asdsad",
            // 'colorMedioForroPiernas' => 'required', // "asdasd",
            // 'dobladillo' => 'required', // "2",
            // 'finish' => 'required', // "Finalizar"
        ]);

        // Datos Orden
        $orden = new Order;

        $orden->client_id = $request->cliente;
        $orden->vendedor_id = Auth::id();

        // Tela
        if ($request->tipoTela === 'cliente') {
            $orden->tela_isco = false;
            $orden->codigo_tela = $request->codigoTelaCliente;
            $orden->mts_tela_cliente = $request->mtsTelaCliente;
            $orden->codigo_color_tela_cliente = $request->codigoColorTelaCliente;
        } else {
            $orden->tela_isco = true;
            $orden->codigo_tela = $request->codigoTelaIsco;
        }

        // Forro
        if ($request->tipoForro === 'cliente') {
            $orden->forro_isco = false;
            $orden->codigo_forro = $request->codigoForroCliente;
            $orden->mts_forro_cliente = $request->mtsForroCliente;
            $orden->codigo_color_forro_cliente = $request->codigoColorForroCliente;
        } else {
            $orden->forro_isco = true;
            $orden->codigo_forro = $request->codigoForroIsco;
        }

        // Botones
        $orden->codigo_botones = $request->codigoBoton; 
        $orden->color_botones = $request->colorBoton;

        // Etiquetas
        $orden->etiquetas_tela = $request->etiquetaTela ? true : false;
        $orden->etiquetas_marca = $request->etiquetaMarca ? true : false;

        // Marca de la Etiqueta
        if ($request->etiquetaMarca) {
            $orden->marca_en_etiqueta = $request->marcaEtiqueta;
        }

        // Gancho
        $orden->gancho = $request->tipoGancho;
        if ($orden->gancho == 1) {
            $orden->gancho_personalizacion = $request->perGancho;
        }

        // Portatrajes
        $orden->portatrajes = $request->tipoPortatrajes;
        if ($orden->portatrajes == 1) {
            $orden->portatrajes_personalizacion = $request->perPortatrajes;
        }

        // Componentes del Traje
        $orden->has_vest = $request->chaleco ? true : false;
        $orden->has_coat = $request->saco ? true : false;
        $orden->has_pants = $request->pantalon ? true : false;

        // Guardar la Orden;
        $orden->save();

        // Chaleco
        if ($orden->has_vest) {
            $chaleco = new Vest;

            // Datos de Chaleco
            $chaleco->order_id = $orden->id;
            $chaleco->tipo_cuello = $request->cuelloChaleco;
            $chaleco->tipo_bolsas = $request->bolsasChaleco;
            $chaleco->tipo_espalda = $request->forroTela;
            $chaleco->ajustador_espalda = $request->ajustadorChaleco ? true : false;

            // Guardar Datos de Chaleco
            $chaleco->save();
        }

        // Pantalón
        if ($orden->has_pants) {
            $pantalon = new Pants;

            // Datos del Pantalón
            $pantalon->order_id = $orden->id;
            $pantalon->pase = $request->tipoPase;
            $pantalon->pliegues = $request->numPliegues;
            $pantalon->bolsas_traseras = $request->bolsasTraseras;
            $pantalon->tipo_vivo = $request->tipoVivo;
            // Color Ojalera y Encuarte
            if ($request->otroColorOjaleraEncuarte) {
                $pantalon->color_ojalera = $request->otroColorOjaleraEncuarte;
            } else {
                $pantalon->color_ojalera = $request->colorOjaleraEncuarte;
            }
            
            $pantalon->color_medio_forro = $request->colorMedioForroPiernas;
            $pantalon->dobladillo = $request->dobladillo;

            // Guardar Datos de Pantalón
            $pantalon->save();
        }

        // Saco
        if ($orden->has_coat) {
            $saco = new Coat;

            $saco->order_id = $orden->id;

            // Datos de Saco Externo
            $saco->tipo_solapa = $request->tipoSolapa;
            // Color Ojal de Solapa
            $saco->tipo_ojal_solapa = $request->tipoOjalSolapa;
            if ($request->otroColorOjalSolapa) {
                $saco->color_ojal_solapa = $request->otroColorOjalSolapa;
            } else {
                $saco->color_ojal_solapa = $request->colorOjalSolapa;
            }
            
            $saco->botones_frente = $request->botonesFrente;
            $saco->aberturas_detras = $request->aberturasDetras;
            $saco->botones_mangas = $request->botonesMangas;
            $saco->tipo_ojal_manga = $request->tipoOjalManga;

            // Color del Ojal en Mangas
            if ($request->otroColorOjalMangas) {
                $saco->color_ojal_manga = $request->otroColorOjalMangas;
            } else {
                $saco->color_ojal_manga = $request->colorOjalMangas;
            }

            $saco->posicion_ojal_manga = $request->posicionOjalesManga;
            $saco->ojales_activos_manga = $request->ojalesActivosManga ? true : false;

            // Bolsas Exteriores
            $saco->tipo_bolsas_ext = $request->bolsasExt;
            $saco->pickstitch = $request->pickstitch ? true : false;
            $saco->pickstitch_filos = $request->pickstitchfilos == "on" ? true : false;
            $saco->pickstitch_aletilla = $request->pickstitchaletilla == "on" ? true : false;
            $saco->pickstitch_cartera = $request->pickstitchcartera == "on" ? true : false;
            $saco->sin_aletilla = $request->sinaletilla == "on" ? true : false;

            // Datos de Saco Interno
            $saco->tipo_vista = $request->tipoVista;
            $saco->balsam_rayas = $request->balsamRayasForroMangas ? true : false;
            if ($request->otroForroInternoMangas) {
                $saco->forro_interno_mangas = $request->otroForroInternoMangas;
            } else {
                $saco->forro_interno_mangas = "Balsam a Rayas";
            }

            // Pin Point
            $saco->pin_point_interno = $request->pinPointInterno ? true : false;
            if ($saco->pin_point_interno) {
                // Color de Pin Point
                if ($request->otroColorPinPoint) {
                    $saco->pin_point_interno_color = $request->otroColorPinPoint;
                } else {
                    $saco->pin_point_interno_color = $request->colorPinPointInterno;
                }

                // Código de Pin Point
                $saco->pin_point_interno_codigo = $request->pinPointInternoCodigo;
            }

            // Bies
            $saco->bies = $request->biesInterno ? true : false;
            if ($saco->bies) {
                // Color de Bies
                if ($request->otroColorBies) {
                    $saco->bies_color = $request->otroColorBies;
                } else {
                    $saco->bies_color = $request->colorBies;
                }

                // Código Bies
                $saco->bies_codigo = $request->biesInternoCodigo;
                
            }

            // Color de la Puntada
            if ($request->otroColorPuntada) {
                $saco->puntada_color = $request->otroColorPuntada;
            } else {
                $saco->puntada_color = $request->colorPuntada;
            }

            // Tipo de Bolsas Internas
            $saco->bolsas_int = $request->bolsasInt;
            $saco->bolsa_int_color = $request->bolsasInternasColor;

            // Vivos iguales a los vivos del Cuerpo
            $saco->vivos_bolsas_internas_cuerpo = $request->vivosBolsasInternasCuerpo ? true : false;
            if (!$saco->vivos_bolsas_internas_cuerpo) {
                $saco->otro_vivos_bolsas_internas = $request->otroVivosBolsasInternas;
            }
            
            // Puntadas
            $saco->puntada_filos = $request->puntadaFilosSacoInt ? true : false;
            $saco->puntada_aletillas = $request->puntadaAletillasSacoInt ? true : false;
            $saco->puntada_carteras = $request->puntadaCarterasSacoInt ? true : false;

            // Guardar los datos del Saco
            $saco->save();
        }

        // Notify the user about the new order
        $request->session()->flash('success', '¡Se ha registrado correctamente la orden #'.$orden->id.'!');

        // Send Emails about new Order
        dispatch(new SendNewOrderEmails($orden));

        // Redirect to Orders:Home
        return redirect('/vendedor/ordenes');
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
