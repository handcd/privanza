<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Vendedor;
use App\Validador;
use App\Admin;
use App\Order;
use App\Vest;
use App\Coat;
use App\Pants;
use App\Fit;

// Facades
use Auth;
use PDF;
use Session;
use Notification; 

// Notifications Vendedor
use App\Notifications\VendedorNewOrder;
use App\Notifications\VendedorPickupOrder;

// Notifications Validador
use App\Notifications\ValidadorNewOrder;
use App\Notifications\ValidadorApproveOrder;
use App\Notifications\ValidadorProductionOrder;
use App\Notifications\ValidadorProductionCuttingOrder;
use App\Notifications\ValidadorProductionEnsambleOrder;
use App\Notifications\ValidadorProductionRevisionOrder;
use App\Notifications\ValidadorDeliveredOrder;

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

        // Órdenes ya entregadas
        $entregados = Auth::user()
                            ->orders()
                            ->where('delivered','1')
                            ->where('facturado','0')
                            ->paginate(5,['*'],'entregados');

        // Órdenes facturadas
        $facturados = Auth::user()
                            ->orders()
                            ->where('facturado','1')
                            ->paginate(5,['*'],'facturados');

        // Órdenes cobradas
        $cobrados = Auth::user()->orders()->where('cobrado','1')->paginate(5,['*'],'cobrados');

        // Todas las ordenes paginadas en grupos de 15.
        $ordenes = Auth::user()->orders()->paginate(15,['*'],'general');

        return view('vendedor.order.home',compact('ordenes','aprobadas','noAprobadas','listosEntrega','entregados','facturados','cobrados'));
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
            'saco' => 'nullable', // "on",
            'chaleco' => 'nullable', // "on",
            'pantalon' => 'nullable', // "on",
            'tipoTela' => 'required', // "cliente",
            'codigoTelaCliente' => 'nullable|required_if:tipoTela,"cliente"', // "suodfoashudf",
            'codigoColorTelaCliente' => 'nullable|required_if:tipoTela,"cliente"', // "aisdhfaidhsf",
            'mtsTelaCliente' => 'nullable|required_if:tipoTela,"cliente"', // "123.3",
            'codigoTelaIsco' => 'nullable|required_if:tipoTela,"cliente"', // null,
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
            'fitSaco' => 'nullable|required_if:saco,"on"|numeric',
            'tallaSaco' => 'nullable|required_if:saco,"on"|numeric',
            'corteSaco' => 'nullable|required_if:saco,"on"|numeric',
            'largoMangaSaco' => 'nullable|required_if:saco,"on"|numeric',
            'largoEspaldaSaco' => 'nullable|required_if:saco,"on"|numeric',
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
            // 'sinaletilla' => 'required', // "on",
            'notasSacoExt' => 'nullable',

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
            'notasSacoInt' => 'nullable',

            // Datos de Chaleco
            'fitChaleco' => 'nullable|required_if:chaleco,"on"|numeric',
            'tallaChaleco' => 'nullable|required_if:chaleco,"on"|numeric',
            'corteChaleco' => 'nullable|required_if:chaleco,"on"|numeric',
            'espaldaChaleco' => 'nullable|required_if:chaleco,"on"|numeric',
            // 'cuelloChaleco' => 'required', // "0",
            // 'bolsasChaleco' => 'required', // "1",
            // 'forroTela' => 'required', // "0",
            // 'ajustadorChaleco' => 'required', // "on",
            'notasChaleco' => 'nullable',

            // Datos Pantalón
            'fitPantalon' => 'nullable|required_if:pantalon,"on"|numeric',
            'tallaPantalon' => 'nullable|required_if:pantalon,"on"|numeric',
            'largoPantalonExt' => 'nullable|required_if:pantalon,"on"|numeric',
            'largoPantalonInt' => 'nullable|required_if:pantalon,"on"|numeric',
            // 'tipoPase' => 'required', // "0",
            // 'numPliegues' => 'required', // "1",
            // 'bolsasTraseras' => 'required', // "0",
            // 'tipoVivo' => 'required', // "1",
            // 'colorOjaleraEncuarte' => 'required', // "Gris Oxford",
            // 'otroColorOjaleraEncuarte' => 'required', // "asdsad",
            // 'colorMedioForroPiernas' => 'required', // "asdasd",
            // 'dobladillo' => 'required', // "2",
            // 'finish' => 'required', // "Finalizar"
            'notasPantalon' => 'nullable',
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
        //Bordado
        $orden->bordado = $request->bordadoNombre;
        $orden->letra = $request->letra;

        if ($request->bordadoColor) {
            $orden->bordadoColor = $request->bordadoColor;
        }else{
            $orden->bordadoColor = 'Gris Plata';
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

            // Medidas Corporales
            $chaleco->fit_id = $request->fitChaleco;
            $chaleco->talla = $request->tallaChaleco;
            $chaleco->corte = $request->corteChaleco;
            $chaleco->largo_espalda = $request->espaldaChaleco;

            // Datos de Chaleco
            $chaleco->order_id = $orden->id;
            $chaleco->tipo_cuello = $request->cuelloChaleco;
            $chaleco->tipo_bolsas = $request->bolsasChaleco;
            $chaleco->tipo_espalda = $request->forroTela;
            if ($request->tipoForroChaleco) {
                $chaleco->tipo_forro = $request->tipoForroChaleco;
            } else {
                $chaleco->tipo_forro = $request->codigoOtroForroChaleco;
            }
            $chaleco->ajustador_espalda = $request->ajustadorChaleco ? true : false;

            $chaleco->notas = $request->notasChaleco;

            // Guardar Datos de Chaleco
            $chaleco->save();
        }

        // Pantalón
        if ($orden->has_pants) {
            $pantalon = new Pants;

            // Medidas Corporales
            $pantalon->fit_id = $request->fitPantalon;
            $pantalon->talla = $request->tallaPantalon;
            $pantalon->largo_ext = $request->largoPantalonExt;
            $pantalon->largo_int = $request->largoPantalonInt;
            $pantalon->notas = $request->notasPantalon;

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
            //color medio forro piernas 
            if ($request->otroColorMedioForroPiernas) {
                $pantalon->color_medio_forro = $request->otroColorMedioForroPiernas;
            }else{
                $pantalon->color_medio_forro = $request->colorMedioForroPiernas;
            }
            //Dobladillo
            $pantalon->dobladillo = $request->dobladillo;
            //Pretina
            $pantalon->pretina = $request->pretina;
            if ($request->otroColorBiesPretina) {
                $pantalon->color_pretina = $request->otroColorBiesPretina;
            }else{
                $pantalon->color_pretina = $request->colorOjaleraEncuarte;
            }

            // Guardar Datos de Pantalón
            $pantalon->save();
        }

        // Saco
        if ($orden->has_coat) {
            $saco = new Coat;

            // Medidas Corporales
            $saco->fit_id = $request->fitSaco;
            $saco->talla = $request->tallaSaco;
            $saco->corte = $request->corteSaco;
            $saco->largo_manga = $request->largoMangaSaco;
            $saco->largo_espalda = $request->largoEspaldaSaco;

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
            $saco->ojal_activo_solapa = $request->ojalActivoSolapa ? true : false;
            
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
            if ($saco->ojales_activos_manga) {
                $saco->posicion_ojales_activos_manga = $request->posicionOjalesActivosManga;
            }

            // Bolsas Exteriores
            $saco->tipo_bolsas_ext = $request->bolsasExt;
            $saco->pickstitch = $request->pickstitch ? true : false;
            $saco->sin_aletilla = $request->sinaletilla == "on" ? true : false;

            // Datos de Saco Interno
            $saco->tipo_vista = $request->tipoVista;
            $saco->balsam_rayas = $request->balsamRayasForroMangas ? true : false;
            if ($request->otroForroInternoMangas) {
                $saco->forro_interno_mangas = $request->otroForroInternoMangas;
            } else {
                $saco->forro_interno_mangas = "Balsam a Rayas";
            }

            
            // Color de la Puntada
            if ($request->otroColorPuntada) {
                $saco->puntada_color = $request->otroColorPuntada;
            } else {
                $saco->puntada_color = $request->colorPuntada;
            }

            // Pin Point
            $saco->pin_point_interno = $request->pinPointInterno ? true : false;
            if ($saco->pin_point_interno) {
                // Color de Pin Point
                if ($request->otroColorPinPoint) {
                    $saco->pin_point_interno_color = $request->otroColorPuntada;
                } else {
                    $saco->pin_point_interno_color = $request->colorPuntada;
                }

                // Código de Pin Point
                $saco->pin_point_interno_codigo = $request->pinPointInternoCodigo;
            }

            // Bies
            $saco->bies = $request->biesInterno ? true : false;
            if ($saco->bies) {
                // Color de Bies
                if ($request->otroColorBies) {
                    $saco->bies_color = $request->otroColorPuntada;
                } else {
                    $saco->bies_color = $request->colorPuntada;
                }

                // Código Bies
                $saco->bies_codigo = $request->biesInternoCodigo;
                
            }

            

            // Tipo de Bolsas Internas
            $saco->bolsas_int = $request->bolsasInt;

            // Vivos iguales a los vivos del Cuerpo
            $saco->vivos_bolsas_internas_cuerpo = $request->vivosBolsasInternasCuerpo ? true : false;
            if (!$saco->vivos_bolsas_internas_cuerpo) {
                $saco->otro_vivos_bolsas_internas = $request->otroVivosBolsasInternas;
            }
            
            // Puntadas
            $saco->puntada_filos = $request->puntadaFilosSacoInt ? true : false;
            $saco->puntada_aletillas = $request->puntadaAletillasSacoInt ? true : false;
            $saco->puntada_carteras = $request->puntadaCarterasSacoInt ? true : false;

            // Notas del Saco
            $saco->notas_ext = $request->notasSacoExt;
            $saco->notas_int = $request->notasSacoInt;

            // Guardar los datos del Saco
            $saco->save();
        }

        // Notify the user about the new order
        $request->session()->flash('success', '¡Se ha registrado correctamente la orden #'.$orden->id.'!');

        // Send Emails about new Order
        Notification::send(Auth::user(), new VendedorNewOrder($orden));
        Notification::send(Validador::all(), new ValidadorNewOrder($orden));

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
        $clientes = Vendedor::find(Auth::id())->clients;

        if (!$orden || $orden->vendedor_id != Auth::id() || $orden->approved) {
            Session::flash('danger','La orden que deseas editar no puede ser mostrada porque no tienes autorización para verla o no existe.');
            return redirect('/vendedor/ordenes');
        }
        return view('vendedor.order.edit',compact('orden','clientes'));
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
    public function pdfForVendedor($id)
    {
        $orden = Order::find($id);
        
        if (!$orden || $orden->vendedor_id != Auth::id()) {
            return redirect('/vendedor/ordenes');
        }
        PDF::setOptions(['dpi' => 50]);

        return PDF::loadview('pdf.order',compact('orden'))->setPaper('a4', 'landscape')->stream('PRIV-OC'.$id.$orden->client->name.'.pdf');
    }

    /**
     * Admin and Validador Functions
     * 
     * THESE ARE POTENTIALLY DESTRUCTIVE ACTIONS
     * Just, be careful
     */

    /**
     * Generate a PDF file for an specific Order
     * This includes sensitive data only available to Validadors or Admins
     *
     * @param \App\Order $id
     * @return PDF file for stream
     */
    public function pdfForAdminValidador($id)
    {
        $orden = Order::find($id);
        
        if (!$orden || $orden->vendedor_id != Auth::id()) {
            return redirect('/vendedor/ordenes');
        }
        PDF::setOptions(['dpi' => 50]);

        return PDF::loadview('pdf.order',compact('orden'))->setPaper('a4', 'landscape')->stream('PRIV-OC'.$id.$orden->client->name.'.pdf');
    }

    /**
     * Approve Order
     * Admin or Validador only, duh
     *
     * @param \App\Order $id
     * @return \Illuminate\Http\Response
     */
    public function approveOrder($id)
    {
        // Fin the order
        $order = Order::find($id);
        if (!$order) {

        }
    }

    /**
     * Order in Production
     * Admin or Validador only, duh
     *
     * @param \App\Order $id
     * @return \Illuminate\Http\Response
     */
    public function productionOrder($id)
    {
    }

    /**
     * Order in Production - Corte
     * Admin or Validador only, duh
     *
     * @param \App\Order $id
     * @return \Illuminate\Http\Response
     */
    public function productionCorteOrder($id)
    {
    }

    /**
     * Order in Production - Ensamble
     * Admin or Validador only, duh
     *
     * @param \App\Order $id
     * @return \Illuminate\Http\Response
     */
    public function productionEnsambleOrder($id)
    {
    }

    /**
     * Order in Production - Plancha
     * Admin or Validador only, duh
     *
     * @param \App\Order $id
     * @return \Illuminate\Http\Response
     */
    public function productionPlanchaOrder($id)
    {
    }

    /**
     * Order in Production - Revisión
     * Admin or Validador only, duh
     *
     * @param \App\Order $id
     * @return \Illuminate\Http\Response
     */
    public function productionRevisionOrder($id)
    {
    }

    /**
     * Pickup Ready Order
     * Admin or Validador only, duh
     *
     * @param \App\Order $id
     * @return \Illuminate\Http\Response
     */
    public function pickupOrder($id)
    {
        # code...
    }

    /**
     * Delivered Order
     * Admin or Validador only, duh
     *
     * @param \App\Order $id
     * @return \Illuminate\Http\Response
     */
    public function deliveredOrder($id)
    {
        # code...
    }

    /**
     * Invoiced Order
     * Admin or Validador only, duh
     *
     * @param \App\Order $id
     * @return \Illuminate\Http\Response
     */
    public function invoicedOrder($id)
    {
        # code...
    }

    /**
     * Charged Order
     * Admin or Validador only, duh
     *
     * @param \App\Order $id
     * @return \Illuminate\Http\Response
     */
    public function chargedOrder($id)
    {
        # code...
    }
}
