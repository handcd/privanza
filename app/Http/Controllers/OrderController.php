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
use App\Configuration;
use App\Client;

// Facades
use Auth;
use PDF;
use Session;
use Notification; 
use Carbon\Carbon;
use Dompdf\Dompdf;

// Notifications 
use App\Notifications\NewOrder;
use App\Notifications\EditedOrder;
use App\Notifications\OrderApproved;
use App\Notifications\OrderProduction;
use App\Notifications\OrderProductionCut;
use App\Notifications\OrderProductionAssemble;
use App\Notifications\OrderProductionIron;
use App\Notifications\OrderProductionReview;
use App\Notifications\OrderPickup;
use App\Notifications\OrderDelivered;
use App\Notifications\OrderCharged;
use App\Notifications\OrderInvoiced;

class OrderController extends Controller
{
    /**
     * Application's configuration
     * @var \App\Configuration $configuracion
     */
    protected $configuracion;

    /**
     * Constructor of the class
     */
    public function __construct()
    {
        $this->configuracion = Configuration::first();
    }

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
        $configuracion = new Configuration;
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
            'tipoTela' => 'nullable', // "cliente",
            'codigoTelaCliente' => 'nullable', // "suodfoashudf",
            'codigoColorTelaCliente' => 'nullable', // "aisdhfaidhsf",
            'mtsTelaCliente' => 'nullable', // "123.3",
            'codigoTelaIsco' => 'nullable', // null,
            'tipoForro' => 'nullable', // "cliente",
            'codigoBoton' => 'nullable', // "asoufhs",
            'colorBoton' => 'nullable', // "sadiuhasdiu",
            'tipoGancho' => 'nullable', // "1",
            'tipoPortatrajes' => 'nullable', // "1",

            // Datos de Saco Externo
            'fitSaco' => 'nullable|numeric',
            'tallaSaco' => 'nullable|numeric',
            'corteSaco' => 'nullable|numeric',
            'largoMangaSaco' => 'nullable|numeric',
            'largoEspaldaSaco' => 'nullable|numeric',
            'notasSacoExt' => 'nullable',

            // Datos de Saco Interno
            'notasSacoInt' => 'nullable',

            // Datos de Chaleco
            'fitChaleco' => 'nullable|numeric',
            'tallaChaleco' => 'nullable|numeric',
            'corteChaleco' => 'nullable|numeric',
            'espaldaChaleco' => 'nullable|numeric',
            'notasChaleco' => 'nullable',

            // Datos Pantalón
            'fitPantalon' => 'nullable|numeric',
            'largoPantalonExt' => 'nullable|numeric',
            'largoPantalonInt' => 'nullable|numeric',
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
            $orden->nombre_tela = $request->nombreTelaCliente;
            $orden->codigo_color_tela = $request->codigoColorTelaCliente;
            $orden->color_tela = $request->colorTelaCliente;
            $orden->mts_tela_cliente = $request->mtsTelaCliente; 
        } else if($request->tipoTela === 'isco'){
            $orden->tela_isco = true;
            $orden->codigo_tela = $request->codigoTelaIsco;
            $orden->nombre_tela = $request->nombreTelaIsco;
            $orden->codigo_color_tela = $request->codigoColorTelaIsco;
            $orden->color_tela = $request->colorTelaIsco;     
        }

        // Forro
        if ($request->tipoForro === 'cliente') {
            $orden->forro_isco = false;
            $orden->codigo_forro = $request->codigoForroCliente;
            $orden->nombre_forro = $request->nombreForroCliente;            
            $orden->codigo_color_forro = $request->codigoColorForroCliente;
            $orden->color_forro = $request->colorForroCliente;
            $orden->mts_forro_cliente = $request->mtsForroCliente;
        } else if($request->tipoForro === 'isco'){
            $orden->forro_isco = true;
            $orden->codigo_forro = $request->codigoForroIsco;
            $orden->nombre_forro = $request->nombreForroIsco;
            $orden->codigo_color_forro = $request->codigoColorForroIsco;
            $orden->color_forro = $request->colorForroIsco;  

        }

        // Botones
        $orden->tipo_botones = $request->botonesCliente ? true : false;
        $orden->codigo_botones = $request->codigoBotones;
        $orden->color_botones = $request->colorBotones;
        $orden->cantidad_botones = $request->cantidadBotones;

        // Etiquetas
        $orden->etiquetas_tela = $request->etiquetaTela ? true : false;
        $orden->etiquetas_marca = $request->etiquetaMarca ? true : false;

        // Marca de la Etiqueta
        if ($request->etiquetaMarca) {
            $orden->marca_en_etiqueta = $request->marcaEtiqueta;
        }
        // Marca de la Tela
        if ($request->etiquetaTela) {
            $orden->marca_en_tela = $request->marcaTela;
        }

        // Gancho
        $orden->gancho = $request->tipoGancho;
        if ($orden->gancho == 2) {
            $orden->gancho_personalizacion = $request->perGancho;
        }

        // Portatrajes
        $orden->portatrajes = $request->tipoPortatrajes;
        if ($orden->portatrajes == 2) {
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

        $orden->notasBordado = $request->notasBordado;

        // Componentes del Traje
        $orden->has_vest = $request->chaleco ? true : false;
        $orden->has_coat = $request->saco ? true : false;
        $orden->has_pants = $request->pantalon ? true : false;

        $orden->consecutivo_op = $request->consecutivoOperacion;
        $orden->precio = $request->precio;
        // Guardar la Orden;
        $orden->save();

        // Chaleco
        if ($orden->has_vest) {
            $chaleco = new Vest;

            // Medidas Corporales
            $chaleco->fit_id = $request->fitChaleco;
            $chaleco->talla = $request->tallaChaleco;

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

            $chaleco->notas = $request->notasChaleco;

            // Guardar Datos de Chaleco
            $chaleco->save();
        }

        // Pantalón
        if ($orden->has_pants) {
            $pantalon = new Pants;

            // Medidas Corporales
            $pantalon->fit_id = $request->fitPantalon;
            $pantalon->notas = $request->notasPantalon;

            // Datos del Pantalón
            $pantalon->order_id = $orden->id;
            $pantalon->pase = $request->tipoPase;
            $pantalon->pliegues = $request->numPliegues;
            $pantalon->bolsas_traseras = $request->bolsasTraseras;
            $pantalon->tipo_vivo = $request->tipoVivo;
            // Color Ojalera, Encuarte y Pretina
            if ($request->otroColorOjaleraEncuarte) {
                $pantalon->color_ojalera = $request->otroColorOjaleraEncuarte;
                $pantalon->color_pretina = $request->otroColorOjaleraEncuarte;
            } else {
                $pantalon->color_ojalera = $request->colorOjaleraEncuarte;
                $pantalon->color_pretina = $request->colorOjaleraEncuarte;
            }
              

            //Dobladillo
            $pantalon->dobladillo = $request->dobladillo;
            

            // Guardar Datos de Pantalón
            $pantalon->save();
        }

        // Saco
        if ($orden->has_coat) {
            $saco = new Coat;
            // Medidas Corporales
            $saco->fit_id = $request->fitSaco;
            $saco->personalizacion_holgura_saco = $request->personalizacionHolguraSaco;
            $saco->largo_manga_izquierda_saco = $request->largoMangaIzquierdaSaco;
            $saco->largo_manga_derecha_saco = $request->largoMangaDerechaSaco;
            $saco->largo_espalda_deseado = $request->largoEspaldaSaco;

            $saco->order_id = $orden->id;
            $saco->tipo_solapa = $request->tipoSolapa; //Solapa 
            // Todo lo referente a Mangas 
            $saco->botones_mangas = $request->botonesMangas; // Número de botones en mangas
            $saco->tipo_ojal_manga = $request->tipoOjalManga; //Al tono o en contraste
            //Color de ojal de manga
            if ($request->tipoOjalManga == 1) {
                $saco->posicion_ojales_contraste = $request->posicionOjalesContrasteMangas;
            }            
            // Color de Ojal de Solapa
            $saco->tipo_ojal_solapa = $request->tipoOjalSolapa; //Al tono o en contraste
            // Otro color del ojal para solapa y manga  
            $saco->color_ojal_manga = $request->colorOjalSolapa;
            $saco->color_ojal_solapa = $request->colorOjalSolapa;         

            
            if ($request->otroColorOjalSolapa) {
                $saco->color_ojal_manga = $request->otroColorOjalSolapa;
                $saco->color_ojal_solapa = $request->otroColorOjalSolapa;
            }
            
            //ojal activo en solapa
            $saco->ojal_activo_solapa = $request->ojalActivoSolapa ? true : false;
            //Posición de los ojales en contraste para solapa
            $saco->posicion_ojal_solapa = $request->posicionOjalesSolapa;
            //Botones
            $saco->botones_frente = $request->botonesFrente;
            //Aberturas
            $saco->aberturas_detras = $request->aberturasDetras;
            

            $saco->posicion_ojal_manga = $request->posicionOjalesManga;
            $saco->ojales_activos_manga = $request->ojalesActivosManga ? true : false;
            if ($saco->ojales_activos_manga) {
                $saco->posicion_ojales_activos_manga = $request->posicionOjalesActivosManga;
            }

            // Bolsas Exteriores
            $saco->tipo_bolsas_ext = $request->bolsasExt;
            $saco->pickstitch = $request->pickstitch ? true : false;
            $saco->sin_aletilla = $request->sinaletilla ? true : false;
            

            // Datos de Saco Interno
            $saco->tipo_vista = $request->tipoVista;
                        

            //Bies y pinpoint
            $saco->tipo_accesorio = $request->tipoAccesorio;
            if ($saco->tipo_accesorio === 0) {
                // Color Pinpoint
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código de Pinpoint
                $saco->accesorio_codigo = $request->pinPointInternoCodigo;
                
            }elseif ($saco->tipo_accesorio === 1) {
                //Color de Bies
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código Bies
                $saco->accesorio_codigo = $request->biesInternoCodigo;
            }else{
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código Bies y pinpoint
                $saco->accesorio_codigo = $request->pinpointbiesInternoCodigo;
            }
            

            // Tipo de Bolsas Internas
            $saco->bolsas_int = $request->bolsasInt;
            
            // Puntadas
            $saco->puntada_filos = $request->pickstitch ? true : false;
            $saco->puntada_aletillas = $request->pickstitch ? true : false;
            $saco->puntada_carteras = $request->pickstitch ? true : false;
            // Notas del Saco
            $saco->notas_ext = $request->notasSacoExt;
            $saco->notas_int = $request->notasSacoInt;

            // Guardar los datos del Saco
            $saco->save();
        }

        // Notify the user about the new order
        $request->session()->flash('success', '¡Se ha registrado correctamente la orden #'.$orden->id.'!');

        // Send Emails about new Order
        if ($this->configuracion->notificar_vendedor_nueva_orden) {
            Notification::send($orden->vendedor, new NewOrder($orden->vendedor,$orden));
        }
        if ($this->configuracion->notificar_validador_nueva_orden) {
            foreach (Validador::all() as $validador) {
                Notification::send($validador, new NewOrder($validador,$orden));
            }
        }
        if ($this->configuracion->notificar_admin_nueva_orden) {
            foreach (Admin::all() as $admin) {
                Notification::send($admin, new NewOrder($admin,$orden));
            }
        }

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
        $saco = Coat::find($id);        
        $chaleco = Vest::find($id);
        $pantalon = Pants::find($id);
        if (!$orden || $orden->vendedor_id != Auth::id() || $orden->approved) {
            Session::flash('danger','La orden que deseas editar no puede ser mostrada porque no tienes autorización para verla o no existe.');
            return redirect('/vendedor/ordenes');
        }
        //return $saco;
        //return $orden;
        return view('vendedor.order.edit',compact('orden','clientes','saco','chaleco','pantalon'));
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
        //return $request;
        $orden = Order::find($id);
        $clientes = Vendedor::find(Auth::id())->clients;
        $saco = Coat::find($id);
        $chaleco = Vest::find($id);
        $pantalon = Pants::find($id);
        if (!$orden || $orden->vendedor_id != Auth::id() || $orden->approved) {
            Session::flash('danger','La orden que deseas editar no puede ser mostrada porque no tienes autorización para verla o no existe.');
            return redirect('/vendedor/ordenes');
        }

        // Tela
        if ($request->tipoTela === 'cliente') {
            $orden->tela_isco = false;
            $orden->codigo_tela = $request->codigoTelaCliente;
            $orden->nombre_tela = $request->nombreTelaCliente;
            $orden->codigo_color_tela = $request->codigoColorTelaCliente;
            $orden->color_tela = $request->colorTelaCliente;
            $orden->mts_tela_cliente = $request->mtsTelaCliente; 
        } else if($request->tipoForro === 'isco'){
            $orden->tela_isco = true;
            $orden->codigo_tela = $request->codigoTelaIsco;
            $orden->nombre_tela = $request->nombreTelaIsco;
            $orden->codigo_color_tela = $request->codigoColorTelaIsco;
            $orden->color_tela = $request->colorTelaIsco;
        }


        // Forro
        if ($request->tipoForro === 'cliente') {
            $orden->forro_isco = false;
            $orden->codigo_forro = $request->codigoForroCliente;
            $orden->nombre_forro = $request->nombreForroCliente;            
            $orden->codigo_color_forro = $request->codigoColorForroCliente;
            $orden->color_forro = $request->colorForroCliente;
            $orden->mts_forro_cliente = $request->mtsForroCliente;
        } else if($request->tipoForro === 'isco'){
            $orden->forro_isco = true;
            $orden->codigo_forro = $request->codigoForroIsco;
            $orden->nombre_forro = $request->nombreForroIsco;
            $orden->codigo_color_forro = $request->codigoColorForroIsco;
            $orden->color_forro = $request->colorForroIsco;  

        }

        // Botones
        $orden->tipo_botones = $request->botonesCliente ? true : false;
        $orden->codigo_botones = $request->codigoBotones; 
        $orden->color_botones = $request->colorBotones;
        $orden->cantidad_botones = $request->cantidadBotones;

        // Etiquetas
        $orden->etiquetas_tela = $request->etiquetaTela ? true : false;
        $orden->etiquetas_marca = $request->etiquetaMarca ? true : false;

        // Marca de la Etiqueta
        if ($request->etiquetaMarca) {
            $orden->marca_en_etiqueta = $request->marcaEtiqueta;
        }
         if ($request->etiquetaTela) {
            $orden->marca_en_tela = $request->marcaTela;
        }

        // Gancho
        $orden->gancho = $request->tipoGancho;
        if ($orden->gancho == 2) {
            $orden->gancho_personalizacion = $request->perGancho;
        }

        // Portatrajes
        $orden->portatrajes = $request->tipoPortatrajes;
        if ($orden->portatrajes == 2) {
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

        $orden->notasBordado = $request->notasBordado;

        // Componentes del Traje
        $orden->has_vest = $request->chaleco ? true : false;
        $orden->has_coat = $request->saco ? true : false;
        $orden->has_pants = $request->pantalon ? true : false;


        // Guardar la Orden;
        $orden->save();

        // Chaleco
        if (isset($chaleco) && $orden->has_vest) {
            

            // Medidas Corporales
            $chaleco->fit_id = $request->fitChaleco;
            $chaleco->talla = $request->tallaChaleco;
            $chaleco->order_id = $orden->id;
            $chaleco->tipo_cuello = $request->cuelloChaleco;
            $chaleco->tipo_bolsas = $request->bolsasChaleco;

            $chaleco->tipo_espalda = $request->forroTela;

            if ($request->tipoForroChaleco) {
                $chaleco->tipo_forro = $request->tipoForroChaleco;
            } else {
                $chaleco->tipo_forro = $request->codigoOtroForroChaleco;
            }

            $chaleco->notas = $request->notasChaleco;

            // Guardar Datos de Chaleco
            $chaleco->save();
        }else if(!isset($chaleco) && $orden->has_vest){
            $chaleco = new Vest;
            // Medidas Corporales

            $chaleco->order_id = $orden->id;
            $chaleco->fit_id = $request->fitChaleco;
            $chaleco->talla = $request->tallaChaleco;
            $chaleco->tipo_cuello = $request->cuelloChaleco;
            $chaleco->tipo_bolsas = $request->bolsasChaleco;

            $chaleco->tipo_espalda = $request->forroTela;
            if ($request->tipoForroChaleco) {
                $chaleco->tipo_forro = $request->tipoForroChaleco;
            } else {
                $chaleco->tipo_forro = $request->codigoOtroForroChaleco;
            }

            $chaleco->notas = $request->notasChaleco;

            // Guardar Datos de Chaleco
            $chaleco->save();
        }

        // Pantalón
        if (isset($pantalon) && $orden->has_pants) {
           

            // Medidas Corporales
            $pantalon->fit_id = $request->fitPantalon;
            $pantalon->notas = $request->notasPantalon;

            // Datos del Pantalón
            $pantalon->order_id = $orden->id;
            $pantalon->pase = $request->tipoPase;
            $pantalon->pliegues = $request->numPliegues;
            $pantalon->bolsas_traseras = $request->bolsasTraseras;
            $pantalon->tipo_vivo = $request->tipoVivo;
            // Color Ojalera, Encuarte y Pretina
            if ($request->otroColorOjaleraEncuarte) {
                $pantalon->color_ojalera = $request->otroColorOjaleraEncuarte;
                $pantalon->color_pretina = $request->otroColorOjaleraEncuarte;
            } else {
                $pantalon->color_ojalera = $request->colorOjaleraEncuarte;
                $pantalon->color_pretina = $request->colorOjaleraEncuarte;
            }
            
            //Dobladillo
            $pantalon->dobladillo = $request->dobladillo;
            

            // Guardar Datos de Pantalón
            $pantalon->save();
            //return $pantalon;
        }else if (!isset($pantalon) && $orden->has_pants) {
            $pantalon = new Pants;
            // Medidas Corporales
            $pantalon->fit_id = $request->fitPantalon;
            $pantalon->notas = $request->notasPantalon;

            // Datos del Pantalón
            $pantalon->order_id = $orden->id;
            $pantalon->pase = $request->tipoPase;
            $pantalon->pliegues = $request->numPliegues;
            $pantalon->bolsas_traseras = $request->bolsasTraseras;
            $pantalon->tipo_vivo = $request->tipoVivo;
            // Color Ojalera, Encuarte y Pretina
            if ($request->otroColorOjaleraEncuarte) {
                $pantalon->color_ojalera = $request->otroColorOjaleraEncuarte;
                $pantalon->color_pretina = $request->otroColorOjaleraEncuarte;
            } else {
                $pantalon->color_ojalera = $request->colorOjaleraEncuarte;
                $pantalon->color_pretina = $request->colorOjaleraEncuarte;
            }
            
            //Dobladillo
            $pantalon->dobladillo = $request->dobladillo;
            

            // Guardar Datos de Pantalón
            $pantalon->save();
        }
       
        // Saco
         if (isset($saco) && $orden->has_coat) {

            // Medidas Corporales
            $saco->fit_id = $request->fitSaco;
            $saco->personalizacion_holgura_saco = $request->personalizacionHolguraSaco;
            $saco->largo_manga_izquierda_saco = $request->largoMangaIzquierdaSaco;
            $saco->largo_manga_derecha_saco = $request->largoMangaDerechaSaco;
            $saco->largo_espalda_deseado = $request->largoEspaldaSaco;

            $saco->order_id = $orden->id;
            $saco->tipo_solapa = $request->tipoSolapa; //Solapa 
            // Todo lo referente a Mangas 
            $saco->botones_mangas = $request->botonesMangas; // Número de botones en mangas
            $saco->tipo_ojal_manga = $request->tipoOjalManga; //Al tono o en contraste
            $saco->posicion_ojales_contraste = $request->posicionOjalesContrasteMangas;            

            // Color Ojal de Solapa
            $saco->tipo_ojal_solapa = $request->tipoOjalSolapa; //Al tono o en contraste
            // Color del ojal en solapa y manga
            $saco->color_ojal_manga = $request->colorOjalSolapa;
            $saco->color_ojal_solapa = $request->colorOjalSolapa;         

            
            if ($request->otroColorOjalSolapa) {
                $saco->color_ojal_manga = $request->otroColorOjalSolapa;
                $saco->color_ojal_solapa = $request->otroColorOjalSolapa;
            }
           
            //ojal activo en solapa
            $saco->ojal_activo_solapa = $request->ojalActivoSolapa ? true : false;
            //Posición de los ojales en contraste para solapa
            $saco->posicion_ojal_solapa = $request->posicionOjalesSolapa;
            //Botones
            $saco->botones_frente = $request->botonesFrente;
            //Aberturas
            $saco->aberturas_detras = $request->aberturasDetras;
            
            $saco->posicion_ojal_manga = $request->posicionOjalesManga;
            $saco->ojales_activos_manga = $request->ojalesActivosManga ? true : false;
            $saco->posicion_ojales_activos_manga = $request->posicionOjalesActivosManga;

            // Bolsas Exteriores
            $saco->tipo_bolsas_ext = $request->bolsasExt;
            $saco->pickstitch = $request->pickstitch ? true : false;
            $saco->sin_aletilla = $request->sinaletilla ? true : false;
            

            // Datos de Saco Interno
            $saco->tipo_vista = $request->tipoVista;

                        

            //Bies y pinpoint
            $saco->tipo_accesorio = $request->tipoAccesorio;
            if ($saco->tipo_accesorio === 0) {
                // Color Pinpoint
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código de Pinpoint
                $saco->accesorio_codigo = $request->pinPointInternoCodigo;
                
            }elseif ($saco->tipo_accesorio === 1) {
                //Color de Bies
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código Bies
                $saco->accesorio_codigo = $request->biesInternoCodigo;
            }else{
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código Bies y pinpoint
                $saco->accesorio_codigo = $request->pinpointbiesInternoCodigo;
            }
            

            // Tipo de Bolsas Internas
            $saco->bolsas_int = $request->bolsasInt;

            
            // Puntadas
            $saco->puntada_filos = $request->pickstitch ? true : false;
            $saco->puntada_aletillas = $request->pickstitch ? true : false;
            $saco->puntada_carteras = $request->pickstitch ? true : false;
            // Notas del Saco
            $saco->notas_ext = $request->notasSacoExt;
            $saco->notas_int = $request->notasSacoInt;
            // Guardar los datos del Saco
            $saco->save();
        }else if (!isset($saco) && $orden->has_coat) {
            $saco = new Coat;

            // Medidas Corporales
            $saco->fit_id = $request->fitSaco;
            $saco->personalizacion_holgura_saco = $request->personalizacionHolguraSaco;
            $saco->largo_manga_izquierda_saco = $request->largoMangaIzquierdaSaco;
            $saco->largo_manga_derecha_saco = $request->largoMangaDerechaSaco;
            $saco->largo_espalda_deseado = $request->largoEspaldaSaco;

            $saco->order_id = $orden->id;
            $saco->tipo_solapa = $request->tipoSolapa; //Solapa 
            // Todo lo referente a Mangas 
            $saco->botones_mangas = $request->botonesMangas; // Número de botones en mangas
            $saco->tipo_ojal_manga = $request->tipoOjalManga; //Al tono o en contraste
            $saco->posicion_ojales_contraste = $request->posicionOjalesContrasteMangas;
            
            // Tipo de Ojal de Solapa
            $saco->tipo_ojal_solapa = $request->tipoOjalSolapa; //Al tono o en contraste
            // Color del ojal en solapa
            $saco->color_ojal_manga = $request->colorOjalSolapa;
            $saco->color_ojal_solapa = $request->colorOjalSolapa;         

            
            if ($request->otroColorOjalSolapa) {
                $saco->color_ojal_manga = $request->otroColorOjalSolapa;
                $saco->color_ojal_solapa = $request->otroColorOjalSolapa;
            }
            //ojal activo en solapa
            $saco->ojal_activo_solapa = $request->ojalActivoSolapa ? true : false;
            //Posición de los ojales en contraste para solapa
            $saco->posicion_ojal_solapa = $request->posicionOjalesSolapa;
            //Botones
            $saco->botones_frente = $request->botonesFrente;
            //Aberturas
            $saco->aberturas_detras = $request->aberturasDetras;
            
            $saco->posicion_ojal_manga = $request->posicionOjalesManga;
            $saco->ojales_activos_manga = $request->ojalesActivosManga ? true : false;
          

            // Bolsas Exteriores
            $saco->tipo_bolsas_ext = $request->bolsasExt;
            $saco->pickstitch = $request->pickstitch ? true : false;
            $saco->sin_aletilla = $request->sinaletilla ? true : false;
            

            // Datos de Saco Interno
            $saco->tipo_vista = $request->tipoVista;                        

            //Bies y pinpoint
            $saco->tipo_accesorio = $request->tipoAccesorio;
            if ($saco->tipo_accesorio === 0) {
                // Color Pinpoint
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código de Pinpoint
                $saco->accesorio_codigo = $request->pinPointInternoCodigo;
                
            }elseif ($saco->tipo_accesorio === 1) {
                //Color de Bies
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código Bies
                $saco->accesorio_codigo = $request->biesInternoCodigo;
            }else{
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código Bies y pinpoint
                $saco->accesorio_codigo = $request->pinpointbiesInternoCodigo;
            }
            

            // Tipo de Bolsas Internas
            $saco->bolsas_int = $request->bolsasInt;
            
            // Puntadas
            $saco->puntada_filos = $request->pickstitch ? true : false;
            $saco->puntada_aletillas = $request->pickstitch ? true : false;
            $saco->puntada_carteras = $request->pickstitch ? true : false;
            // Notas del Saco
            $saco->notas_ext = $request->notasSacoExt;
            $saco->notas_int = $request->notasSacoInt;
            // Guardar los datos del Saco
            $saco->save();
            //return $saco;
        }

        

        // Notify the user about the new order
        $request->session()->flash('success', '¡Se ha editado correctamente la orden #'.$orden->id.'!');

        // Send Emails about new Order
        if ($this->configuracion->notificar_vendedor_nueva_orden) {
            Notification::send($orden->vendedor, new NewOrder($orden->vendedor,$orden));
        }
        if ($this->configuracion->notificar_validador_nueva_orden) {
            foreach (Validador::all() as $validador) {
                Notification::send($validador, new NewOrder($validador,$orden));
            }
        }
        if ($this->configuracion->notificar_admin_nueva_orden) {
            foreach (Admin::all() as $admin) {
                Notification::send($admin, new NewOrder($admin,$orden));
            }
        }
        // Redirect to Orders:Home
        return redirect('/vendedor/ordenes');
    }

    /**
     * Generate a PDF file for an specific Order
     *
     * @param $id
     * @return PDF file for stream
     */
    public function pdfForVendedorHTML($id){
        
    }
    public function pdfForVendedor($id)
    {
        $dompdf = new Dompdf();
        $orden = Order::find($id);
        
        if (!$orden || $orden->vendedor_id != Auth::id()) {
            return redirect('/vendedor/ordenes');
        }
        PDF::setOptions(['dpi' => 50]);
        if ($orden->has_coat) {
            $saco = $orden->Coat;
        }
        if ($orden->has_pants) {
            $pantalon = $orden->Pants;
        }
        if ($orden->has_vest) {
            $chaleco = $orden->Vest;
        }
        //  return $saco;
        return PDF::loadview('pdf.order',compact('orden','saco','pantalon','chaleco'))->setPaper('a4', 'landscape')->stream('PRIV-OC'.$id.$orden->client->name.'.pdf');
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
        // Validate user is Admin or Validador
        if (!(Auth::user()->isAdmin() || Auth::user()->isValidador())) {
            return redirect('/vendedor/ordenes/'.$id);
        }
        // Get the order
        $orden = Order::find($id);
        // Validate order existence
        if (!$orden) {
            return redirect('/'.(Auth::user()->isAdmin() ? 'admin' : 'validador').'/ordenes'.$id);
        }
        // Validate order previously approved for Admin
        if ($orden->approved && Auth::user()->isAdmin()) {
            $orden->approved = false;
            return redirect('/admin/ordenes/'.$id);
        }
        // Approve Order and save
        $orden->approved = true;
        $orden->date_approved = Carbon::now();
        $orden->save();

        // Notify users
        if ($this->configuracion->notificar_vendedor_orden_aprobada) {
            Notification::send($orden->vendedor, new OrderApproved($orden->vendedor,$orden));
        }
        if ($this->configuracion->notificar_validador_orden_aprobada) {
            foreach (Validador::all() as $validador) {
                Notification::send($validador, new OrderApproved($validador,$orden));
            }
        }
        if ($this->configuracion->notificar_admin_orden_aprobada) {
            foreach (Admin::all() as $admin) {
                Notification::send($admin, new OrderApproved($admin,$orden));
            }
        }

        // Redirect
        if (Auth::user()->isAdmin()) {
            return redirect('/admin/ordenes/'.$id);
        } else {
            return redirect('/validador/ordenes/'.$id);
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
        // Validate user is admin or validador
        if (!(Auth::user()->isAdmin() || Auth::user()->isValidador())) {
            return redirect('/vendedor/ordenes/'.$id);
        }
        // Find the order
        $orden = Order::find($id);
        // Validate order existence
        if (!$orden) {
            return redirect('/'.(Auth::user()->isAdmin() ? 'admin' : 'validador').'/ordenes'.$id);
        }
        // Validate order already in production for admin toggle
        if ($orden->production && Auth::user()->isAdmin()) {
            $orden->production = false;
            return redirect('/admin/ordenes/'.$id);
        }
        // Set status to 1 and save
        $orden->production = true;
        $orden->date_production = Carbon::now();
        $orden->save();

        // Notify users
        if ($this->configuracion->notificar_vendedor_orden_produccion) {
            Notification::send($orden->vendedor, new OrderProduction($orden->vendedor,$orden));
        }
        if ($this->configuracion->notificar_validador_orden_produccion) {
            foreach (Validador::all() as $validador) {
                Notification::send($validador, new OrderProduction($validador,$orden));
            }
        }
        if ($this->configuracion->notificar_admin_orden_produccion) {
            foreach (Admin::all() as $admin) {
                Notification::send($admin, new OrderProduction($admin,$orden));
            }
        }

        // Redirect
        if (Auth::user()->isAdmin()) {
            return redirect('/admin/ordenes/'.$id);
        } else {
            return redirect('/validador/ordenes/'.$id);
        }
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
        // Validate user is admin or validador
        if (!(Auth::user()->isAdmin() || Auth::user()->isValidador())) {
            return redirect('/vendedor/ordenes/'.$id);
        }
        // Find the order
        $orden = Order::find($id);
        // Validate order existence
        if (!$orden) {
            return redirect('/'.(Auth::user()->isAdmin() ? 'admin' : 'validador').'/ordenes'.$id);
        }
        // Validate order already set and user admin for toggle
        if ($orden->corte && Auth::user()->isAdmin()) {
            $orden->corte = false;
            return redirect('/admin/ordenes/'.$id);
        }
        // Set status to true and save
        $orden->corte = true;
        $orden->date_corte = Carbon::now();
        $orden->save();

        // Notify users
        if ($this->configuracion->notificar_validador_orden_produccion_corte) {
            foreach (Validador::all() as $validador) {
                Notification::send($validador, new OrderProductionCut($validador,$orden));
            }
        }
        if ($this->configuracion->notificar_admin_orden_produccion_corte) {
            foreach (Admin::all() as $admin) {
                Notification::send($admin, new OrderProductionCut($admin,$orden));
            }
        }

        // Redirect
        if (Auth::user()->isAdmin()) {
            return redirect('/admin/ordenes/'.$id);
        } else {
            return redirect('/validador/ordenes/'.$id);
        }
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
        // Validate user is admin or validador
        if (!(Auth::user()->isAdmin() || Auth::user()->isValidador())) {
            return redirect('/vendedor/ordenes/'.$id);
        }
        // Find the order
        $orden = Order::find($id);
        // Validate order existence
        if (!$orden) {
            return redirect('/'.(Auth::user()->isAdmin() ? 'admin' : 'validador').'/ordenes'.$id);
        }
        // Toggle for admin if order already set
        if ($orden->ensamble && Auth::user()->isAdmin()) {
            $orden->ensamble = false;
            return redirect('/admin/ordenes/'.$id);
        }
        // Set to true and save
        $orden->ensamble = true;
        $orden->date_ensamble = Carbon::now();
        $orden->save();

        // Notify users
        if ($this->configuracion->notificar_validador_orden_produccion_ensamble) {
            foreach (Validador::all() as $validador) {
                Notification::send($validador, new OrderProductionAssemble($validador,$orden));
            }
        }
        if ($this->configuracion->notificar_admin_orden_produccion_ensamble) {
            foreach (Admin::all() as $admin) {
                Notification::send($admin, new OrderProductionAssemble($admin,$orden));
            }
        }

        // Redirect
        if (Auth::user()->isAdmin()) {
            return redirect('/admin/ordenes/'.$id);
        } else {
            return redirect('/validador/ordenes/'.$id);
        }
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
        // Validate user is admin or validador
        if (!(Auth::user()->isAdmin() || Auth::user()->isValidador())) {
            return redirect('/vendedor/ordenes/'.$id);
        }
        // Find the order
        $orden = Order::find($id);
        // Validate order existence
        if (!$orden) {
            return redirect('/'.(Auth::user()->isAdmin() ? 'admin' : 'validador').'/ordenes'.$id);
        }
        // Toggle status for admin
        if ($orden->plancha && Auth::user()->isAdmin()) {
            $orden->plancha = false;
            return redirect('/admin/ordenes/'.$id);
        }
        // Set status to true and save
        $orden->plancha = true;
        $orden->date_plancha = Carbon::now();
        $orden->save();

        // Notify users
        if ($this->configuracion->notificar_validador_orden_produccion_plancha) {
            foreach (Validador::all() as $validador) {
                Notification::send($validador, new OrderProductionIron($validador,$orden));
            }
        }
        if ($this->configuracion->notificar_admin_orden_produccion_plancha) {
            foreach (Admin::all() as $admin) {
                Notification::send($admin, new OrderProductionIron($admin,$orden));
            }
        }

        // Redirect
        if (Auth::user()->isAdmin()) {
            return redirect('/admin/ordenes/'.$id);
        } else {
            return redirect('/validador/ordenes/'.$id);
        }
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
        // Validate user is admin or validador
        if (!(Auth::user()->isAdmin() || Auth::user()->isValidador())) {
            return redirect('/vendedor/ordenes/'.$id);
        }

        // Find the order
        $orden = Order::find($id);
        // Validate order existence
        if (!$orden) {
            return redirect('/'.(Auth::user()->isAdmin() ? 'admin' : 'validador').'/ordenes'.$id);
        }
        // Toggle order status for admin
        if ($orden->revision && Auth::user()->isAdmin()) {
            $orden->revision = false;
            return redirect('/admin/ordenes/'.$id);
        }
        // Set status to true and save
        $orden->revision = true;
        $orden->date_revision = Carbon::now();
        $orden->save();

        // Notify users
        if ($this->configuracion->notificar_validador_orden_produccion_revision) {
            foreach (Validador::all() as $validador) {
                Notification::send($validador, new OrderProductionReview($validador,$orden));
            }
        }
        if ($this->configuracion->notificar_admin_orden_produccion_revision) {
            foreach (Admin::all() as $admin) {
                Notification::send($admin, new OrderProductionReview($admin,$orden));
            }
        }

        // Redirect
        if (Auth::user()->isAdmin()) {
            return redirect('/admin/ordenes/'.$id);
        } else {
            return redirect('/validador/ordenes/'.$id);
        }
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
        // Validate user is admin or validador
        if (!(Auth::user()->isAdmin() || Auth::user()->isValidador())) {
            return redirect('/vendedor/ordenes/'.$id);
        }

        // Find the order
        $orden = Order::find($id);
        // Validate order existence
        if (!$orden) {
            return redirect('/'.(Auth::user()->isAdmin() ? 'admin' : 'validador').'/ordenes'.$id);
        }
        // Toggle order status if admin
        if ($orden->pickup && Auth::user()->isAdmin()) {
            $orden->pickup = false;
            return redirect('/admin/ordenes/'.$id);
        }
        // Set status to true and save
        $orden->pickup = true;
        $orden->date_pickup = Carbon::now();
        $orden->save();

        // Notify users
        if ($this->configuracion->notificar_validador_orden_pickup) {
            foreach (Validador::all() as $validador) {
                Notification::send($validador, new OrderPickup($validador,$orden));
            }
        }
        if ($this->configuracion->notificar_admin_orden_pickup) {
            foreach (Admin::all() as $admin) {
                Notification::send($admin, new OrderPickup($admin,$orden));
            }
        }

        // Redirect
        if (Auth::user()->isAdmin()) {
            return redirect('/admin/ordenes/'.$id);
        } else {
            return redirect('/validador/ordenes/'.$id);
        }
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
        // Validate user is admin or validador
        if (!(Auth::user()->isAdmin() || Auth::user()->isValidador())) {
            return redirect('/vendedor/ordenes/'.$id);
        }
        // Find the order
        $orden = Order::find($id);
        // Validate order existence
        if (!$orden) {
            return redirect('/'.(Auth::user()->isAdmin() ? 'admin' : 'validador').'/ordenes'.$id);
        }
        // Toggle order status if admin
        if ($orden->delivered && Auth::user()->isAdmin()) {
            $orden->delivered = false;
            return redirect('/admin/ordenes/'.$id);
        }
        // Set status to true and save
        $orden->delivered = true;
        $orden->date_delivered = Carbon::now();
        $orden->save();

        // Notify users
        if ($this->configuracion->notificar_validador_orden_entregada) {
            foreach (Validador::all() as $validador) {
                Notification::send($validador, new OrderDelivered($validador,$orden));
            }
        }
        if ($this->configuracion->notificar_admin_orden_entregada) {
            foreach (Admin::all() as $admin) {
                Notification::send($admin, new OrderDelivered($admin,$orden));
            }
        }

        // Redirect
        if (Auth::user()->isAdmin()) {
            return redirect('/admin/ordenes/'.$id);
        } else {
            return redirect('/validador/ordenes/'.$id);
        }
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
        // Validate if user is admin or validador
        if (!(Auth::user()->isAdmin() || Auth::user()->isValidador())) {
            return redirect('/vendedor/ordenes/'.$id);
        }
        // Find order
        $orden = Order::find($id);
        // Validate order existence
        if (!$orden) {
            return redirect('/'.(Auth::user()->isAdmin() ? 'admin' : 'validador').'/ordenes'.$id);
        }
        // Toggle order status if admin
        if ($orden->facturado && Auth::user()->isAdmin()) {
            $orden->facturado = false;
            return redirect('/admin/ordenes/'.$id);
        }
        // Set status to true and save
        $orden->facturado = true;
        $orden->date_facturado = Carbon::now();
        $orden->save();

        // Notify users
        if ($this->configuracion->notificar_validador_orden_facturada) {
            foreach (Validador::all() as $validador) {
                Notification::send($validador, new OrderInvoiced($validador,$orden));
            }
        }
        if ($this->configuracion->notificar_admin_orden_facturada) {
            foreach (Admin::all() as $admin) {
                Notification::send($admin, new OrderInvoiced($admin,$orden));
            }
        }

        // Redirect
        if (Auth::user()->isAdmin()) {
            return redirect('/admin/ordenes/'.$id);
        } else {
            return redirect('/validador/ordenes/'.$id);
        }
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
        // Validate if user is admin or validador
        if (!(Auth::user()->isAdmin() || Auth::user()->isValidador())) {
            return redirect('/vendedor/ordenes/'.$id);
        }
        // Find order
        $orden = Order::find($id);
        // Validate order existence
        if (!$orden) {
            return redirect('/'.(Auth::user()->isAdmin() ? 'admin' : 'validador').'/ordenes'.$id);
        }
        // Toggle order status if admin
        if ($orden->cobrado && Auth::user()->isAdmin()) {
            $orden->cobrado = false;
            return redirect('/admin/ordenes/'.$id);
        }
        // Set statu to true and save
        $orden->cobrado = true;
        $orden->date_cobrado = Carbon::now();
        $orden->save();

        // Notify users
        if ($this->configuracion->notificar_validador_orden_cobrada) {
            foreach (Validador::all() as $validador) {
                Notification::send($validador, new OrderCharged($validador,$orden));
            }
        }
        if ($this->configuracion->notificar_admin_orden_cobrada) {
            foreach (Admin::all() as $admin) {
                Notification::send($admin, new OrderApproved($admin,$orden));
            }
        }

        // Redirect
        if (Auth::user()->isAdmin()) {
            return redirect('/admin/ordenes/'.$id);
        } else {
            return redirect('/validador/ordenes/'.$id);
        }
    }

    /**
     * API ACTIONS
     */

    /**
     * Find OP, returns the order matching an OP
     *
     * @param $op
     */
    public function findOP($op)
    {
        return Order::where('consecutivo_op',$op)->get();
    }

    /** Modulo de Validador **/
    public function index()
    {   
        /**
         * Òrdenes de la vista principal del Validador
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
        $noAprobadas = Order::where('approved','0')->paginate(5,['*'],'noAprobadas');

        // Órdenes aprobadas (pero no en producción)
        $aprobadas = Order::where('approved','1')
                        ->where('production','0')
                        ->paginate(5,['*'],'aprobadas');

        // Órdenes listas para recolección (pero no entregadas)
        $listosEntrega = Order::where('pickup','1')
                            ->where('delivered','0')
                            ->paginate(5,['*'],'recoger');

        // Órdenes ya entregadas
        $entregados = Order::where('delivered','1')
                            ->where('facturado','0')
                            ->paginate(5,['*'],'entregados');

        // Órdenes facturadas
        $facturados = Order::where('facturado','1')
                            ->paginate(5,['*'],'facturados');

        // Órdenes cobradas
        $cobrados = Order::where('cobrado','1')->paginate(5,['*'],'cobrados');

        // Todas las ordenes paginadas en grupos de 15.
        $ordenes = Order::paginate(15,['*'],'general');

        return view('validador.order.home',compact('ordenes','aprobadas','noAprobadas','listosEntrega','entregados','facturados','cobrados'));
    }
    public function create()
    {
        $clientes = Client::all();
        return view('validador.order.create',compact('clientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $configuracion = new Configuration;
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
            'tipoTela' => 'nullable', // "cliente",
            'codigoTelaCliente' => 'nullable', // "suodfoashudf",
            'codigoColorTelaCliente' => 'nullable', // "aisdhfaidhsf",
            'mtsTelaCliente' => 'nullable', // "123.3",
            'codigoTelaIsco' => 'nullable', // null,
            'tipoForro' => 'nullable', // "cliente",
            'codigoBoton' => 'nullable', // "asoufhs",
            'colorBoton' => 'nullable', // "sadiuhasdiu",
            'tipoGancho' => 'nullable', // "1",
            'tipoPortatrajes' => 'nullable', // "1",

            // Datos de Saco Externo
            'fitSaco' => 'nullable|numeric',
            'tallaSaco' => 'nullable|numeric',
            'corteSaco' => 'nullable|numeric',
            'largoMangaSaco' => 'nullable|numeric',
            'largoEspaldaSaco' => 'nullable|numeric',
            'notasSacoExt' => 'nullable',

            // Datos de Saco Interno
            'notasSacoInt' => 'nullable',

            // Datos de Chaleco
            'fitChaleco' => 'nullable|numeric',
            'tallaChaleco' => 'nullable|numeric',
            'corteChaleco' => 'nullable|numeric',
            'espaldaChaleco' => 'nullable|numeric',
            'notasChaleco' => 'nullable',

            // Datos Pantalón
            'fitPantalon' => 'nullable|numeric',
            'largoPantalonExt' => 'nullable|numeric',
            'largoPantalonInt' => 'nullable|numeric',
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
            $orden->nombre_tela = $request->nombreTelaCliente;
            $orden->codigo_color_tela = $request->codigoColorTelaCliente;
            $orden->color_tela = $request->colorTelaCliente;
            $orden->mts_tela_cliente = $request->mtsTelaCliente; 
        } else if($request->tipoTela === 'isco'){
            $orden->tela_isco = true;
            $orden->codigo_tela = $request->codigoTelaIsco;
            $orden->nombre_tela = $request->nombreTelaIsco;
            $orden->codigo_color_tela = $request->codigoColorTelaIsco;
            $orden->color_tela = $request->colorTelaIsco;     
        }

        // Forro
        if ($request->tipoForro === 'cliente') {
            $orden->forro_isco = false;
            $orden->codigo_forro = $request->codigoForroCliente;
            $orden->nombre_forro = $request->nombreForroCliente;            
            $orden->codigo_color_forro = $request->codigoColorForroCliente;
            $orden->color_forro = $request->colorForroCliente;
            $orden->mts_forro_cliente = $request->mtsForroCliente;
        } else if($request->tipoForro === 'isco'){
            $orden->forro_isco = true;
            $orden->codigo_forro = $request->codigoForroIsco;
            $orden->nombre_forro = $request->nombreForroIsco;
            $orden->codigo_color_forro = $request->codigoColorForroIsco;
            $orden->color_forro = $request->colorForroIsco;  

        }

        // Botones
        $orden->tipo_botones = $request->botonesCliente ? true : false;
        $orden->codigo_botones = $request->codigoBotones;
        $orden->color_botones = $request->colorBotones;
        $orden->cantidad_botones = $request->cantidadBotones;

        // Etiquetas
        $orden->etiquetas_tela = $request->etiquetaTela ? true : false;
        $orden->etiquetas_marca = $request->etiquetaMarca ? true : false;

        // Marca de la Etiqueta
        if ($request->etiquetaMarca) {
            $orden->marca_en_etiqueta = $request->marcaEtiqueta;
        }
        // Marca de la Tela
        if ($request->etiquetaTela) {
            $orden->marca_en_tela = $request->marcaTela;
        }

        // Gancho
        $orden->gancho = $request->tipoGancho;
        if ($orden->gancho == 2) {
            $orden->gancho_personalizacion = $request->perGancho;
        }

        // Portatrajes
        $orden->portatrajes = $request->tipoPortatrajes;
        if ($orden->portatrajes == 2) {
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

        $orden->notasBordado = $request->notasBordado;

        // Componentes del Traje
        $orden->has_vest = $request->chaleco ? true : false;
        $orden->has_coat = $request->saco ? true : false;
        $orden->has_pants = $request->pantalon ? true : false;

        $orden->consecutivo_op = $request->consecutivoOperacion;
        $orden->precio = $request->precio;
        // Guardar la Orden;
        $orden->save();

        // Chaleco
        if ($orden->has_vest) {
            $chaleco = new Vest;

            // Medidas Corporales
            $chaleco->fit_id = $request->fitChaleco;
            $chaleco->talla = $request->tallaChaleco;

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

            $chaleco->notas = $request->notasChaleco;

            // Guardar Datos de Chaleco
            $chaleco->save();
        }

        // Pantalón
        if ($orden->has_pants) {
            $pantalon = new Pants;

            // Medidas Corporales
            $pantalon->fit_id = $request->fitPantalon;
            $pantalon->notas = $request->notasPantalon;

            // Datos del Pantalón
            $pantalon->order_id = $orden->id;
            $pantalon->pase = $request->tipoPase;
            $pantalon->pliegues = $request->numPliegues;
            $pantalon->bolsas_traseras = $request->bolsasTraseras;
            $pantalon->tipo_vivo = $request->tipoVivo;
            // Color Ojalera, Encuarte y Pretina
            if ($request->otroColorOjaleraEncuarte) {
                $pantalon->color_ojalera = $request->otroColorOjaleraEncuarte;
                $pantalon->color_pretina = $request->otroColorOjaleraEncuarte;
            } else {
                $pantalon->color_ojalera = $request->colorOjaleraEncuarte;
                $pantalon->color_pretina = $request->colorOjaleraEncuarte;
            }
              

            //Dobladillo
            $pantalon->dobladillo = $request->dobladillo;
            

            // Guardar Datos de Pantalón
            $pantalon->save();
        }

        // Saco
        if ($orden->has_coat) {
            $saco = new Coat;
            // Medidas Corporales
            $saco->fit_id = $request->fitSaco;
            $saco->personalizacion_holgura_saco = $request->personalizacionHolguraSaco;
            $saco->largo_manga_izquierda_saco = $request->largoMangaIzquierdaSaco;
            $saco->largo_manga_derecha_saco = $request->largoMangaDerechaSaco;
            $saco->largo_espalda_deseado = $request->largoEspaldaSaco;

            $saco->order_id = $orden->id;
            $saco->tipo_solapa = $request->tipoSolapa; //Solapa 
            // Todo lo referente a Mangas 
            $saco->botones_mangas = $request->botonesMangas; // Número de botones en mangas
            $saco->tipo_ojal_manga = $request->tipoOjalManga; //Al tono o en contraste
            //Color de ojal de manga
            if ($request->tipoOjalManga == 1) {
                $saco->posicion_ojales_contraste = $request->posicionOjalesContrasteMangas;
            }            
            // Color de Ojal de Solapa
            $saco->tipo_ojal_solapa = $request->tipoOjalSolapa; //Al tono o en contraste
            // Otro color del ojal para solapa y manga  
            $saco->color_ojal_manga = $request->colorOjalSolapa;
            $saco->color_ojal_solapa = $request->colorOjalSolapa;         

            
            if ($request->otroColorOjalSolapa) {
                $saco->color_ojal_manga = $request->otroColorOjalSolapa;
                $saco->color_ojal_solapa = $request->otroColorOjalSolapa;
            }
            
            //ojal activo en solapa
            $saco->ojal_activo_solapa = $request->ojalActivoSolapa ? true : false;
            //Posición de los ojales en contraste para solapa
            $saco->posicion_ojal_solapa = $request->posicionOjalesSolapa;
            //Botones
            $saco->botones_frente = $request->botonesFrente;
            //Aberturas
            $saco->aberturas_detras = $request->aberturasDetras;
            

            $saco->posicion_ojal_manga = $request->posicionOjalesManga;
            $saco->ojales_activos_manga = $request->ojalesActivosManga ? true : false;
            if ($saco->ojales_activos_manga) {
                $saco->posicion_ojales_activos_manga = $request->posicionOjalesActivosManga;
            }

            // Bolsas Exteriores
            $saco->tipo_bolsas_ext = $request->bolsasExt;
            $saco->pickstitch = $request->pickstitch ? true : false;
            $saco->sin_aletilla = $request->sinaletilla ? true : false;
            

            // Datos de Saco Interno
            $saco->tipo_vista = $request->tipoVista;
            //Bies y pinpoint
            $saco->tipo_accesorio = $request->tipoAccesorio;
            if ($saco->tipo_accesorio === 0) {
                // Color Pinpoint
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código de Pinpoint
                $saco->accesorio_codigo = $request->pinPointInternoCodigo;
                
            }elseif ($saco->tipo_accesorio === 1) {
                //Color de Bies
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código Bies
                $saco->accesorio_codigo = $request->biesInternoCodigo;
            }else{
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código Bies y pinpoint
                $saco->accesorio_codigo = $request->pinpointbiesInternoCodigo;
            }
            

            // Tipo de Bolsas Internas
            $saco->bolsas_int = $request->bolsasInt;
            
            // Puntadas
            $saco->puntada_filos = $request->pickstitch ? true : false;
            $saco->puntada_aletillas = $request->pickstitch ? true : false;
            $saco->puntada_carteras = $request->pickstitch ? true : false;
            // Notas del Saco
            $saco->notas_ext = $request->notasSacoExt;
            $saco->notas_int = $request->notasSacoInt;

            // Guardar los datos del Saco
            $saco->save();
        }

        // Notify the user about the new order
        $request->session()->flash('success', '¡Se ha registrado correctamente la orden #'.$orden->id.'!');

        // Send Emails about new Order
        if ($this->configuracion->notificar_vendedor_nueva_orden) {
            Notification::send($orden->vendedor, new NewOrder($orden->vendedor,$orden));
        }
        if ($this->configuracion->notificar_validador_nueva_orden) {
            foreach (Validador::all() as $validador) {
                Notification::send($validador, new NewOrder($validador,$orden));
            }
        }
        if ($this->configuracion->notificar_admin_nueva_orden) {
            foreach (Admin::all() as $admin) {
                Notification::send($admin, new NewOrder($admin,$orden));
            }
        }

        // Redirect to Orders:Home
        return redirect('/validador/ordenes');
    }
    public function show($id)
    {
        $orden = Order::find($id);
        if (!$orden) {
            Session::flash('danger','La orden que deseas ver no puede ser mostrada porque no existe.');
            return redirect('/validador/ordenes');
        }
        return view('validador.order.show',compact('orden'));
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
        $clientes = Client::all();
        $saco = Coat::find($id);        
        $chaleco = Vest::find($id);
        $pantalon = Pants::find($id);
        if (!$orden) {
            Session::flash('danger','La orden que deseas editar no existe.');
            return redirect('/validador/ordenes');
        }
        //return $saco;
        //return $orden;
        return view('validador.order.edit',compact('orden','clientes','saco','chaleco','pantalon'));
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
        //return $request;
        $orden = Order::find($id);
        $clientes = Vendedor::find(Auth::id())->clients;
        $saco = Coat::find($id);
        $chaleco = Vest::find($id);
        $pantalon = Pants::find($id);
        if (!$orden) {
            Session::flash('danger','La orden que deseas editar no puede ser mostrada porque no tienes autorización para verla o no existe.');
            return redirect('/validador/ordenes');
        }

        // Tela
        if ($request->tipoTela === 'cliente') {
            $orden->tela_isco = false;
            $orden->codigo_tela = $request->codigoTelaCliente;
            $orden->nombre_tela = $request->nombreTelaCliente;
            $orden->codigo_color_tela = $request->codigoColorTelaCliente;
            $orden->color_tela = $request->colorTelaCliente;
            $orden->mts_tela_cliente = $request->mtsTelaCliente; 
        } else if($request->tipoForro === 'isco'){
            $orden->tela_isco = true;
            $orden->codigo_tela = $request->codigoTelaIsco;
            $orden->nombre_tela = $request->nombreTelaIsco;
            $orden->codigo_color_tela = $request->codigoColorTelaIsco;
            $orden->color_tela = $request->colorTelaIsco;
        }


        // Forro
        if ($request->tipoForro === 'cliente') {
            $orden->forro_isco = false;
            $orden->codigo_forro = $request->codigoForroCliente;
            $orden->nombre_forro = $request->nombreForroCliente;            
            $orden->codigo_color_forro = $request->codigoColorForroCliente;
            $orden->color_forro = $request->colorForroCliente;
            $orden->mts_forro_cliente = $request->mtsForroCliente;
        } else if($request->tipoForro === 'isco'){
            $orden->forro_isco = true;
            $orden->codigo_forro = $request->codigoForroIsco;
            $orden->nombre_forro = $request->nombreForroIsco;
            $orden->codigo_color_forro = $request->codigoColorForroIsco;
            $orden->color_forro = $request->colorForroIsco;  

        }

        // Botones
        $orden->tipo_botones = $request->botonesCliente ? true : false;
        $orden->codigo_botones = $request->codigoBotones; 
        $orden->color_botones = $request->colorBotones;
        $orden->cantidad_botones = $request->cantidadBotones;

        // Etiquetas
        $orden->etiquetas_tela = $request->etiquetaTela ? true : false;
        $orden->etiquetas_marca = $request->etiquetaMarca ? true : false;

        // Marca de la Etiqueta
        if ($request->etiquetaMarca) {
            $orden->marca_en_etiqueta = $request->marcaEtiqueta;
        }
         if ($request->etiquetaTela) {
            $orden->marca_en_tela = $request->marcaTela;
        }

        // Gancho
        $orden->gancho = $request->tipoGancho;
        if ($orden->gancho == 2) {
            $orden->gancho_personalizacion = $request->perGancho;
        }

        // Portatrajes
        $orden->portatrajes = $request->tipoPortatrajes;
        if ($orden->portatrajes == 2) {
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

        $orden->notasBordado = $request->notasBordado;

        // Componentes del Traje
        $orden->has_vest = $request->chaleco ? true : false;
        $orden->has_coat = $request->saco ? true : false;
        $orden->has_pants = $request->pantalon ? true : false;


        // Guardar la Orden;
        $orden->save();

        // Chaleco
        if (isset($chaleco) && $orden->has_vest) {
            

            // Medidas Corporales
            $chaleco->fit_id = $request->fitChaleco;
            $chaleco->talla = $request->tallaChaleco;
            $chaleco->order_id = $orden->id;
            $chaleco->tipo_cuello = $request->cuelloChaleco;
            $chaleco->tipo_bolsas = $request->bolsasChaleco;

            $chaleco->tipo_espalda = $request->forroTela;

            if ($request->tipoForroChaleco) {
                $chaleco->tipo_forro = $request->tipoForroChaleco;
            } else {
                $chaleco->tipo_forro = $request->codigoOtroForroChaleco;
            }

            $chaleco->notas = $request->notasChaleco;

            // Guardar Datos de Chaleco
            $chaleco->save();
        }else if(!isset($chaleco) && $orden->has_vest){
            $chaleco = new Vest;
            // Medidas Corporales

            $chaleco->order_id = $orden->id;
            $chaleco->fit_id = $request->fitChaleco;
            $chaleco->talla = $request->tallaChaleco;
            $chaleco->tipo_cuello = $request->cuelloChaleco;
            $chaleco->tipo_bolsas = $request->bolsasChaleco;

            $chaleco->tipo_espalda = $request->forroTela;
            if ($request->tipoForroChaleco) {
                $chaleco->tipo_forro = $request->tipoForroChaleco;
            } else {
                $chaleco->tipo_forro = $request->codigoOtroForroChaleco;
            }

            $chaleco->notas = $request->notasChaleco;

            // Guardar Datos de Chaleco
            $chaleco->save();
        }

        // Pantalón
        if (isset($pantalon) && $orden->has_pants) {
           

            // Medidas Corporales
            $pantalon->fit_id = $request->fitPantalon;
            $pantalon->notas = $request->notasPantalon;

            // Datos del Pantalón
            $pantalon->order_id = $orden->id;
            $pantalon->pase = $request->tipoPase;
            $pantalon->pliegues = $request->numPliegues;
            $pantalon->bolsas_traseras = $request->bolsasTraseras;
            $pantalon->tipo_vivo = $request->tipoVivo;
            // Color Ojalera, Encuarte y Pretina
            if ($request->otroColorOjaleraEncuarte) {
                $pantalon->color_ojalera = $request->otroColorOjaleraEncuarte;
                $pantalon->color_pretina = $request->otroColorOjaleraEncuarte;
            } else {
                $pantalon->color_ojalera = $request->colorOjaleraEncuarte;
                $pantalon->color_pretina = $request->colorOjaleraEncuarte;
            }
            
            //Dobladillo
            $pantalon->dobladillo = $request->dobladillo;
            

            // Guardar Datos de Pantalón
            $pantalon->save();
            //return $pantalon;
        }else if (!isset($pantalon) && $orden->has_pants) {
            $pantalon = new Pants;
            // Medidas Corporales
            $pantalon->fit_id = $request->fitPantalon;
            $pantalon->notas = $request->notasPantalon;

            // Datos del Pantalón
            $pantalon->order_id = $orden->id;
            $pantalon->pase = $request->tipoPase;
            $pantalon->pliegues = $request->numPliegues;
            $pantalon->bolsas_traseras = $request->bolsasTraseras;
            $pantalon->tipo_vivo = $request->tipoVivo;
            // Color Ojalera, Encuarte y Pretina
            if ($request->otroColorOjaleraEncuarte) {
                $pantalon->color_ojalera = $request->otroColorOjaleraEncuarte;
                $pantalon->color_pretina = $request->otroColorOjaleraEncuarte;
            } else {
                $pantalon->color_ojalera = $request->colorOjaleraEncuarte;
                $pantalon->color_pretina = $request->colorOjaleraEncuarte;
            }
            
            //Dobladillo
            $pantalon->dobladillo = $request->dobladillo;
            

            // Guardar Datos de Pantalón
            $pantalon->save();
        }
       
        // Saco
         if (isset($saco) && $orden->has_coat) {

            // Medidas Corporales
            $saco->fit_id = $request->fitSaco;
            $saco->personalizacion_holgura_saco = $request->personalizacionHolguraSaco;
            $saco->largo_manga_izquierda_saco = $request->largoMangaIzquierdaSaco;
            $saco->largo_manga_derecha_saco = $request->largoMangaDerechaSaco;
            $saco->largo_espalda_deseado = $request->largoEspaldaSaco;

            $saco->order_id = $orden->id;
            $saco->tipo_solapa = $request->tipoSolapa; //Solapa 
            // Todo lo referente a Mangas 
            $saco->botones_mangas = $request->botonesMangas; // Número de botones en mangas
            $saco->tipo_ojal_manga = $request->tipoOjalManga; //Al tono o en contraste
            $saco->posicion_ojales_contraste = $request->posicionOjalesContrasteMangas;            

            // Color Ojal de Solapa
            $saco->tipo_ojal_solapa = $request->tipoOjalSolapa; //Al tono o en contraste
            // Color del ojal en solapa y manga
            $saco->color_ojal_manga = $request->colorOjalSolapa;
            $saco->color_ojal_solapa = $request->colorOjalSolapa;         

            
            if ($request->otroColorOjalSolapa) {
                $saco->color_ojal_manga = $request->otroColorOjalSolapa;
                $saco->color_ojal_solapa = $request->otroColorOjalSolapa;
            }
           
            //ojal activo en solapa
            $saco->ojal_activo_solapa = $request->ojalActivoSolapa ? true : false;
            //Posición de los ojales en contraste para solapa
            $saco->posicion_ojal_solapa = $request->posicionOjalesSolapa;
            //Botones
            $saco->botones_frente = $request->botonesFrente;
            //Aberturas
            $saco->aberturas_detras = $request->aberturasDetras;
            
            $saco->posicion_ojal_manga = $request->posicionOjalesManga;
            $saco->ojales_activos_manga = $request->ojalesActivosManga ? true : false;
            $saco->posicion_ojales_activos_manga = $request->posicionOjalesActivosManga;

            // Bolsas Exteriores
            $saco->tipo_bolsas_ext = $request->bolsasExt;
            $saco->pickstitch = $request->pickstitch ? true : false;
            $saco->sin_aletilla = $request->sinaletilla ? true : false;
            

            // Datos de Saco Interno
            $saco->tipo_vista = $request->tipoVista;

                        

            //Bies y pinpoint
            $saco->tipo_accesorio = $request->tipoAccesorio;
            if ($saco->tipo_accesorio === 0) {
                // Color Pinpoint
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código de Pinpoint
                $saco->accesorio_codigo = $request->pinPointInternoCodigo;
                
            }elseif ($saco->tipo_accesorio === 1) {
                //Color de Bies
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código Bies
                $saco->accesorio_codigo = $request->biesInternoCodigo;
            }else{
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código Bies y pinpoint
                $saco->accesorio_codigo = $request->pinpointbiesInternoCodigo;
            }
            

            // Tipo de Bolsas Internas
            $saco->bolsas_int = $request->bolsasInt;

            
            // Puntadas
            $saco->puntada_filos = $request->pickstitch ? true : false;
            $saco->puntada_aletillas = $request->pickstitch ? true : false;
            $saco->puntada_carteras = $request->pickstitch ? true : false;
            // Notas del Saco
            $saco->notas_ext = $request->notasSacoExt;
            $saco->notas_int = $request->notasSacoInt;
            // Guardar los datos del Saco
            $saco->save();
        }else if (!isset($saco) && $orden->has_coat) {
            $saco = new Coat;

            // Medidas Corporales
            $saco->fit_id = $request->fitSaco;
            $saco->personalizacion_holgura_saco = $request->personalizacionHolguraSaco;
            $saco->largo_manga_izquierda_saco = $request->largoMangaIzquierdaSaco;
            $saco->largo_manga_derecha_saco = $request->largoMangaDerechaSaco;
            $saco->largo_espalda_deseado = $request->largoEspaldaSaco;

            $saco->order_id = $orden->id;
            $saco->tipo_solapa = $request->tipoSolapa; //Solapa 
            // Todo lo referente a Mangas 
            $saco->botones_mangas = $request->botonesMangas; // Número de botones en mangas
            $saco->tipo_ojal_manga = $request->tipoOjalManga; //Al tono o en contraste
            $saco->posicion_ojales_contraste = $request->posicionOjalesContrasteMangas;
            
            // Tipo de Ojal de Solapa
            $saco->tipo_ojal_solapa = $request->tipoOjalSolapa; //Al tono o en contraste
            // Color del ojal en solapa
            $saco->color_ojal_manga = $request->colorOjalSolapa;
            $saco->color_ojal_solapa = $request->colorOjalSolapa;         

            
            if ($request->otroColorOjalSolapa) {
                $saco->color_ojal_manga = $request->otroColorOjalSolapa;
                $saco->color_ojal_solapa = $request->otroColorOjalSolapa;
            }
            //ojal activo en solapa
            $saco->ojal_activo_solapa = $request->ojalActivoSolapa ? true : false;
            //Posición de los ojales en contraste para solapa
            $saco->posicion_ojal_solapa = $request->posicionOjalesSolapa;
            //Botones
            $saco->botones_frente = $request->botonesFrente;
            //Aberturas
            $saco->aberturas_detras = $request->aberturasDetras;
            
            $saco->posicion_ojal_manga = $request->posicionOjalesManga;
            $saco->ojales_activos_manga = $request->ojalesActivosManga ? true : false;
          

            // Bolsas Exteriores
            $saco->tipo_bolsas_ext = $request->bolsasExt;
            $saco->pickstitch = $request->pickstitch ? true : false;
            $saco->sin_aletilla = $request->sinaletilla ? true : false;
            

            // Datos de Saco Interno
            $saco->tipo_vista = $request->tipoVista;                        

            //Bies y pinpoint
            $saco->tipo_accesorio = $request->tipoAccesorio;
            if ($saco->tipo_accesorio === 0) {
                // Color Pinpoint
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código de Pinpoint
                $saco->accesorio_codigo = $request->pinPointInternoCodigo;
                
            }elseif ($saco->tipo_accesorio === 1) {
                //Color de Bies
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código Bies
                $saco->accesorio_codigo = $request->biesInternoCodigo;
            }else{
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código Bies y pinpoint
                $saco->accesorio_codigo = $request->pinpointbiesInternoCodigo;
            }
            

            // Tipo de Bolsas Internas
            $saco->bolsas_int = $request->bolsasInt;
            
            // Puntadas
            $saco->puntada_filos = $request->pickstitch ? true : false;
            $saco->puntada_aletillas = $request->pickstitch ? true : false;
            $saco->puntada_carteras = $request->pickstitch ? true : false;
            // Notas del Saco
            $saco->notas_ext = $request->notasSacoExt;
            $saco->notas_int = $request->notasSacoInt;
            // Guardar los datos del Saco
            $saco->save();
            //return $saco;
        }

        

        // Notify the user about the new order
        $request->session()->flash('success', '¡Se ha editado correctamente la orden #'.$orden->id.'!');

        // Send Emails about new Order
        if ($this->configuracion->notificar_vendedor_nueva_orden) {
            Notification::send($orden->vendedor, new NewOrder($orden->vendedor,$orden));
        }
        if ($this->configuracion->notificar_validador_nueva_orden) {
            foreach (Validador::all() as $validador) {
                Notification::send($validador, new NewOrder($validador,$orden));
            }
        }
        if ($this->configuracion->notificar_admin_nueva_orden) {
            foreach (Admin::all() as $admin) {
                Notification::send($admin, new NewOrder($admin,$orden));
            }
        }
        // Redirect to Orders:Home
        return redirect('/validador/ordenes');
    }

    public function indexForAdmin(){
        /**
         * Òrdenes de la vista principal del Administrador
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
        $noAprobadas = Order::where('approved','0')->paginate(5,['*'],'noAprobadas');

        // Órdenes aprobadas (pero no en producción)
        $aprobadas = Order::where('approved','1')
                        ->where('production','0')
                        ->paginate(5,['*'],'aprobadas');

        // Órdenes listas para recolección (pero no entregadas)
        $listosEntrega = Order::where('pickup','1')
                            ->where('delivered','0')
                            ->paginate(5,['*'],'recoger');

        // Órdenes ya entregadas
        $entregados = Order::where('delivered','1')
                            ->where('facturado','0')
                            ->paginate(5,['*'],'entregados');

        // Órdenes facturadas
        $facturados = Order::where('facturado','1')
                            ->paginate(5,['*'],'facturados');

        // Órdenes cobradas
        $cobrados = Order::where('cobrado','1')->paginate(5,['*'],'cobrados');

        // Todas las ordenes paginadas en grupos de 15.
        $ordenes = Order::paginate(15,['*'],'general');

        return view('admin.order.home',compact('ordenes','aprobadas','noAprobadas','listosEntrega','entregados','facturados','cobrados'));
    }

    public function createForAdmin()
    {
        $clientes = Client::all();
        return view('admin.order.create',compact('clientes'));
    }
    public function storeForAdmin(Request $request)
    {
        //return $request;
        $configuracion = new Configuration;
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
            'tipoTela' => 'nullable', // "cliente",
            'codigoTelaCliente' => 'nullable', // "suodfoashudf",
            'codigoColorTelaCliente' => 'nullable', // "aisdhfaidhsf",
            'mtsTelaCliente' => 'nullable', // "123.3",
            'codigoTelaIsco' => 'nullable', // null,
            'tipoForro' => 'nullable', // "cliente",
            'codigoBoton' => 'nullable', // "asoufhs",
            'colorBoton' => 'nullable', // "sadiuhasdiu",
            'tipoGancho' => 'nullable', // "1",
            'tipoPortatrajes' => 'nullable', // "1",

            // Datos de Saco Externo
            'fitSaco' => 'nullable|numeric',
            'tallaSaco' => 'nullable|numeric',
            'corteSaco' => 'nullable|numeric',
            'largoMangaSaco' => 'nullable|numeric',
            'largoEspaldaSaco' => 'nullable|numeric',
            'notasSacoExt' => 'nullable',

            // Datos de Saco Interno
            'notasSacoInt' => 'nullable',

            // Datos de Chaleco
            'fitChaleco' => 'nullable|numeric',
            'tallaChaleco' => 'nullable|numeric',
            'corteChaleco' => 'nullable|numeric',
            'espaldaChaleco' => 'nullable|numeric',
            'notasChaleco' => 'nullable',

            // Datos Pantalón
            'fitPantalon' => 'nullable|numeric',
            'largoPantalonExt' => 'nullable|numeric',
            'largoPantalonInt' => 'nullable|numeric',
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
            $orden->nombre_tela = $request->nombreTelaCliente;
            $orden->codigo_color_tela = $request->codigoColorTelaCliente;
            $orden->color_tela = $request->colorTelaCliente;
            $orden->mts_tela_cliente = $request->mtsTelaCliente; 
        } else if($request->tipoTela === 'isco'){
            $orden->tela_isco = true;
            $orden->codigo_tela = $request->codigoTelaIsco;
            $orden->nombre_tela = $request->nombreTelaIsco;
            $orden->codigo_color_tela = $request->codigoColorTelaIsco;
            $orden->color_tela = $request->colorTelaIsco;     
        }

        // Forro
        if ($request->tipoForro === 'cliente') {
            $orden->forro_isco = false;
            $orden->codigo_forro = $request->codigoForroCliente;
            $orden->nombre_forro = $request->nombreForroCliente;            
            $orden->codigo_color_forro = $request->codigoColorForroCliente;
            $orden->color_forro = $request->colorForroCliente;
            $orden->mts_forro_cliente = $request->mtsForroCliente;
        } else if($request->tipoForro === 'isco'){
            $orden->forro_isco = true;
            $orden->codigo_forro = $request->codigoForroIsco;
            $orden->nombre_forro = $request->nombreForroIsco;
            $orden->codigo_color_forro = $request->codigoColorForroIsco;
            $orden->color_forro = $request->colorForroIsco;  

        }

        // Botones
        $orden->tipo_botones = $request->botonesCliente ? true : false;
        $orden->codigo_botones = $request->codigoBotones;
        $orden->color_botones = $request->colorBotones;
        $orden->cantidad_botones = $request->cantidadBotones;

        // Etiquetas
        $orden->etiquetas_tela = $request->etiquetaTela ? true : false;
        $orden->etiquetas_marca = $request->etiquetaMarca ? true : false;

        // Marca de la Etiqueta
        if ($request->etiquetaMarca) {
            $orden->marca_en_etiqueta = $request->marcaEtiqueta;
        }
        // Marca de la Tela
        if ($request->etiquetaTela) {
            $orden->marca_en_tela = $request->marcaTela;
        }

        // Gancho
        $orden->gancho = $request->tipoGancho;
        if ($orden->gancho == 2) {
            $orden->gancho_personalizacion = $request->perGancho;
        }

        // Portatrajes
        $orden->portatrajes = $request->tipoPortatrajes;
        if ($orden->portatrajes == 2) {
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

        $orden->notasBordado = $request->notasBordado;

        // Componentes del Traje
        $orden->has_vest = $request->chaleco ? true : false;
        $orden->has_coat = $request->saco ? true : false;
        $orden->has_pants = $request->pantalon ? true : false;

        $orden->consecutivo_op = $request->consecutivoOperacion;
        $orden->precio = $request->precio;
        // Guardar la Orden;
        $orden->save();

        // Chaleco
        if ($orden->has_vest) {
            $chaleco = new Vest;

            // Medidas Corporales
            $chaleco->fit_id = $request->fitChaleco;
            $chaleco->talla = $request->tallaChaleco;

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

            $chaleco->notas = $request->notasChaleco;

            // Guardar Datos de Chaleco
            $chaleco->save();
        }

        // Pantalón
        if ($orden->has_pants) {
            $pantalon = new Pants;

            // Medidas Corporales
            $pantalon->fit_id = $request->fitPantalon;
            $pantalon->notas = $request->notasPantalon;

            // Datos del Pantalón
            $pantalon->order_id = $orden->id;
            $pantalon->pase = $request->tipoPase;
            $pantalon->pliegues = $request->numPliegues;
            $pantalon->bolsas_traseras = $request->bolsasTraseras;
            $pantalon->tipo_vivo = $request->tipoVivo;
            // Color Ojalera, Encuarte y Pretina
            if ($request->otroColorOjaleraEncuarte) {
                $pantalon->color_ojalera = $request->otroColorOjaleraEncuarte;
                $pantalon->color_pretina = $request->otroColorOjaleraEncuarte;
            } else {
                $pantalon->color_ojalera = $request->colorOjaleraEncuarte;
                $pantalon->color_pretina = $request->colorOjaleraEncuarte;
            }
              

            //Dobladillo
            $pantalon->dobladillo = $request->dobladillo;
            

            // Guardar Datos de Pantalón
            $pantalon->save();
        }

        // Saco
        if ($orden->has_coat) {
            $saco = new Coat;
            // Medidas Corporales
            $saco->fit_id = $request->fitSaco;
            $saco->personalizacion_holgura_saco = $request->personalizacionHolguraSaco;
            $saco->largo_manga_izquierda_saco = $request->largoMangaIzquierdaSaco;
            $saco->largo_manga_derecha_saco = $request->largoMangaDerechaSaco;
            $saco->largo_espalda_deseado = $request->largoEspaldaSaco;

            $saco->order_id = $orden->id;
            $saco->tipo_solapa = $request->tipoSolapa; //Solapa 
            // Todo lo referente a Mangas 
            $saco->botones_mangas = $request->botonesMangas; // Número de botones en mangas
            $saco->tipo_ojal_manga = $request->tipoOjalManga; //Al tono o en contraste
            //Color de ojal de manga
            if ($request->tipoOjalManga == 1) {
                $saco->posicion_ojales_contraste = $request->posicionOjalesContrasteMangas;
            }            
            // Color de Ojal de Solapa
            $saco->tipo_ojal_solapa = $request->tipoOjalSolapa; //Al tono o en contraste
            // Otro color del ojal para solapa y manga  
            $saco->color_ojal_manga = $request->colorOjalSolapa;
            $saco->color_ojal_solapa = $request->colorOjalSolapa;         

            
            if ($request->otroColorOjalSolapa) {
                $saco->color_ojal_manga = $request->otroColorOjalSolapa;
                $saco->color_ojal_solapa = $request->otroColorOjalSolapa;
            }
            
            //ojal activo en solapa
            $saco->ojal_activo_solapa = $request->ojalActivoSolapa ? true : false;
            //Posición de los ojales en contraste para solapa
            $saco->posicion_ojal_solapa = $request->posicionOjalesSolapa;
            //Botones
            $saco->botones_frente = $request->botonesFrente;
            //Aberturas
            $saco->aberturas_detras = $request->aberturasDetras;
            

            $saco->posicion_ojal_manga = $request->posicionOjalesManga;
            $saco->ojales_activos_manga = $request->ojalesActivosManga ? true : false;
            if ($saco->ojales_activos_manga) {
                $saco->posicion_ojales_activos_manga = $request->posicionOjalesActivosManga;
            }

            // Bolsas Exteriores
            $saco->tipo_bolsas_ext = $request->bolsasExt;
            $saco->pickstitch = $request->pickstitch ? true : false;
            $saco->sin_aletilla = $request->sinaletilla ? true : false;
            

            // Datos de Saco Interno
            $saco->tipo_vista = $request->tipoVista;
            //Bies y pinpoint
            $saco->tipo_accesorio = $request->tipoAccesorio;
            if ($saco->tipo_accesorio === 0) {
                // Color Pinpoint
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código de Pinpoint
                $saco->accesorio_codigo = $request->pinPointInternoCodigo;
                
            }elseif ($saco->tipo_accesorio === 1) {
                //Color de Bies
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código Bies
                $saco->accesorio_codigo = $request->biesInternoCodigo;
            }else{
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código Bies y pinpoint
                $saco->accesorio_codigo = $request->pinpointbiesInternoCodigo;
            }
            

            // Tipo de Bolsas Internas
            $saco->bolsas_int = $request->bolsasInt;
            
            // Puntadas
            $saco->puntada_filos = $request->pickstitch ? true : false;
            $saco->puntada_aletillas = $request->pickstitch ? true : false;
            $saco->puntada_carteras = $request->pickstitch ? true : false;
            // Notas del Saco
            $saco->notas_ext = $request->notasSacoExt;
            $saco->notas_int = $request->notasSacoInt;

            // Guardar los datos del Saco
            $saco->save();
        }

        // Notify the user about the new order
        $request->session()->flash('success', '¡Se ha registrado correctamente la orden #'.$orden->id.'!');

        // Send Emails about new Order
        if ($this->configuracion->notificar_vendedor_nueva_orden) {
            Notification::send($orden->vendedor, new NewOrder($orden->vendedor,$orden));
        }
        if ($this->configuracion->notificar_validador_nueva_orden) {
            foreach (Validador::all() as $validador) {
                Notification::send($validador, new NewOrder($validador,$orden));
            }
        }
        if ($this->configuracion->notificar_admin_nueva_orden) {
            foreach (Admin::all() as $admin) {
                Notification::send($admin, new NewOrder($admin,$orden));
            }
        }

        // Redirect to Orders:Home
        return redirect('/admin/ordenes');
    }
    public function showForAdmin($id)
    {
        $orden = Order::find($id);
        if (!$orden) {
            Session::flash('danger','La orden que deseas editar no existe.');
            return redirect('/admin/ordenes');
        }
        return view('admin.order.show',compact('orden'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vendedor  $vendedor
     * @return \Illuminate\Http\Response
     */
    public function editForAdmin($id)
    {
        $orden = Order::find($id);
        $clientes = Client::all();
        $saco = Coat::find($id);        
        $chaleco = Vest::find($id);
        $pantalon = Pants::find($id);
        if (!$orden) {
            Session::flash('danger','La orden que deseas editar no existe.');
            return redirect('/admin/ordenes');
        }
        //return $saco;
        //return $orden;
        return view('admin.order.edit',compact('orden','clientes','saco','chaleco','pantalon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vendedor  $vendedor
     * @return \Illuminate\Http\Response
     */
    public function updateForAdmin(Request $request, $id)
    {
        //return $request;
        $orden = Order::find($id);
        $clientes = Vendedor::find(Auth::id())->clients;
        $saco = Coat::find($id);
        $chaleco = Vest::find($id);
        $pantalon = Pants::find($id);
        if (!$orden) {
            Session::flash('danger','La orden que deseas editar no puede ser mostrada porque no existe.');
            return redirect('/admin/ordenes');
        }

        // Tela
        if ($request->tipoTela === 'cliente') {
            $orden->tela_isco = false;
            $orden->codigo_tela = $request->codigoTelaCliente;
            $orden->nombre_tela = $request->nombreTelaCliente;
            $orden->codigo_color_tela = $request->codigoColorTelaCliente;
            $orden->color_tela = $request->colorTelaCliente;
            $orden->mts_tela_cliente = $request->mtsTelaCliente; 
        } else if($request->tipoForro === 'isco'){
            $orden->tela_isco = true;
            $orden->codigo_tela = $request->codigoTelaIsco;
            $orden->nombre_tela = $request->nombreTelaIsco;
            $orden->codigo_color_tela = $request->codigoColorTelaIsco;
            $orden->color_tela = $request->colorTelaIsco;
        }


        // Forro
        if ($request->tipoForro === 'cliente') {
            $orden->forro_isco = false;
            $orden->codigo_forro = $request->codigoForroCliente;
            $orden->nombre_forro = $request->nombreForroCliente;            
            $orden->codigo_color_forro = $request->codigoColorForroCliente;
            $orden->color_forro = $request->colorForroCliente;
            $orden->mts_forro_cliente = $request->mtsForroCliente;
        } else if($request->tipoForro === 'isco'){
            $orden->forro_isco = true;
            $orden->codigo_forro = $request->codigoForroIsco;
            $orden->nombre_forro = $request->nombreForroIsco;
            $orden->codigo_color_forro = $request->codigoColorForroIsco;
            $orden->color_forro = $request->colorForroIsco;  

        }

        // Botones
        $orden->tipo_botones = $request->botonesCliente ? true : false;
        $orden->codigo_botones = $request->codigoBotones; 
        $orden->color_botones = $request->colorBotones;
        $orden->cantidad_botones = $request->cantidadBotones;

        // Etiquetas
        $orden->etiquetas_tela = $request->etiquetaTela ? true : false;
        $orden->etiquetas_marca = $request->etiquetaMarca ? true : false;

        // Marca de la Etiqueta
        if ($request->etiquetaMarca) {
            $orden->marca_en_etiqueta = $request->marcaEtiqueta;
        }
         if ($request->etiquetaTela) {
            $orden->marca_en_tela = $request->marcaTela;
        }

        // Gancho
        $orden->gancho = $request->tipoGancho;
        if ($orden->gancho == 2) {
            $orden->gancho_personalizacion = $request->perGancho;
        }

        // Portatrajes
        $orden->portatrajes = $request->tipoPortatrajes;
        if ($orden->portatrajes == 2) {
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

        $orden->notasBordado = $request->notasBordado;

        // Componentes del Traje
        $orden->has_vest = $request->chaleco ? true : false;
        $orden->has_coat = $request->saco ? true : false;
        $orden->has_pants = $request->pantalon ? true : false;


        // Guardar la Orden;
        $orden->save();

        // Chaleco
        if (isset($chaleco) && $orden->has_vest) {
            

            // Medidas Corporales
            $chaleco->fit_id = $request->fitChaleco;
            $chaleco->talla = $request->tallaChaleco;
            $chaleco->order_id = $orden->id;
            $chaleco->tipo_cuello = $request->cuelloChaleco;
            $chaleco->tipo_bolsas = $request->bolsasChaleco;

            $chaleco->tipo_espalda = $request->forroTela;

            if ($request->tipoForroChaleco) {
                $chaleco->tipo_forro = $request->tipoForroChaleco;
            } else {
                $chaleco->tipo_forro = $request->codigoOtroForroChaleco;
            }

            $chaleco->notas = $request->notasChaleco;

            // Guardar Datos de Chaleco
            $chaleco->save();
        }else if(!isset($chaleco) && $orden->has_vest){
            $chaleco = new Vest;
            // Medidas Corporales

            $chaleco->order_id = $orden->id;
            $chaleco->fit_id = $request->fitChaleco;
            $chaleco->talla = $request->tallaChaleco;
            $chaleco->tipo_cuello = $request->cuelloChaleco;
            $chaleco->tipo_bolsas = $request->bolsasChaleco;

            $chaleco->tipo_espalda = $request->forroTela;
            if ($request->tipoForroChaleco) {
                $chaleco->tipo_forro = $request->tipoForroChaleco;
            } else {
                $chaleco->tipo_forro = $request->codigoOtroForroChaleco;
            }

            $chaleco->notas = $request->notasChaleco;

            // Guardar Datos de Chaleco
            $chaleco->save();
        }

        // Pantalón
        if (isset($pantalon) && $orden->has_pants) {
           

            // Medidas Corporales
            $pantalon->fit_id = $request->fitPantalon;
            $pantalon->notas = $request->notasPantalon;

            // Datos del Pantalón
            $pantalon->order_id = $orden->id;
            $pantalon->pase = $request->tipoPase;
            $pantalon->pliegues = $request->numPliegues;
            $pantalon->bolsas_traseras = $request->bolsasTraseras;
            $pantalon->tipo_vivo = $request->tipoVivo;
            // Color Ojalera, Encuarte y Pretina
            if ($request->otroColorOjaleraEncuarte) {
                $pantalon->color_ojalera = $request->otroColorOjaleraEncuarte;
                $pantalon->color_pretina = $request->otroColorOjaleraEncuarte;
            } else {
                $pantalon->color_ojalera = $request->colorOjaleraEncuarte;
                $pantalon->color_pretina = $request->colorOjaleraEncuarte;
            }
            
            //Dobladillo
            $pantalon->dobladillo = $request->dobladillo;
            

            // Guardar Datos de Pantalón
            $pantalon->save();
            //return $pantalon;
        }else if (!isset($pantalon) && $orden->has_pants) {
            $pantalon = new Pants;
            // Medidas Corporales
            $pantalon->fit_id = $request->fitPantalon;
            $pantalon->notas = $request->notasPantalon;

            // Datos del Pantalón
            $pantalon->order_id = $orden->id;
            $pantalon->pase = $request->tipoPase;
            $pantalon->pliegues = $request->numPliegues;
            $pantalon->bolsas_traseras = $request->bolsasTraseras;
            $pantalon->tipo_vivo = $request->tipoVivo;
            // Color Ojalera, Encuarte y Pretina
            if ($request->otroColorOjaleraEncuarte) {
                $pantalon->color_ojalera = $request->otroColorOjaleraEncuarte;
                $pantalon->color_pretina = $request->otroColorOjaleraEncuarte;
            } else {
                $pantalon->color_ojalera = $request->colorOjaleraEncuarte;
                $pantalon->color_pretina = $request->colorOjaleraEncuarte;
            }
            
            //Dobladillo
            $pantalon->dobladillo = $request->dobladillo;
            

            // Guardar Datos de Pantalón
            $pantalon->save();
        }
       
        // Saco
         if (isset($saco) && $orden->has_coat) {

            // Medidas Corporales
            $saco->fit_id = $request->fitSaco;
            $saco->personalizacion_holgura_saco = $request->personalizacionHolguraSaco;
            $saco->largo_manga_izquierda_saco = $request->largoMangaIzquierdaSaco;
            $saco->largo_manga_derecha_saco = $request->largoMangaDerechaSaco;
            $saco->largo_espalda_deseado = $request->largoEspaldaSaco;

            $saco->order_id = $orden->id;
            $saco->tipo_solapa = $request->tipoSolapa; //Solapa 
            // Todo lo referente a Mangas 
            $saco->botones_mangas = $request->botonesMangas; // Número de botones en mangas
            $saco->tipo_ojal_manga = $request->tipoOjalManga; //Al tono o en contraste
            $saco->posicion_ojales_contraste = $request->posicionOjalesContrasteMangas;            

            // Color Ojal de Solapa
            $saco->tipo_ojal_solapa = $request->tipoOjalSolapa; //Al tono o en contraste
            // Color del ojal en solapa y manga
            $saco->color_ojal_manga = $request->colorOjalSolapa;
            $saco->color_ojal_solapa = $request->colorOjalSolapa;         

            
            if ($request->otroColorOjalSolapa) {
                $saco->color_ojal_manga = $request->otroColorOjalSolapa;
                $saco->color_ojal_solapa = $request->otroColorOjalSolapa;
            }
           
            //ojal activo en solapa
            $saco->ojal_activo_solapa = $request->ojalActivoSolapa ? true : false;
            //Posición de los ojales en contraste para solapa
            $saco->posicion_ojal_solapa = $request->posicionOjalesSolapa;
            //Botones
            $saco->botones_frente = $request->botonesFrente;
            //Aberturas
            $saco->aberturas_detras = $request->aberturasDetras;
            
            $saco->posicion_ojal_manga = $request->posicionOjalesManga;
            $saco->ojales_activos_manga = $request->ojalesActivosManga ? true : false;
            $saco->posicion_ojales_activos_manga = $request->posicionOjalesActivosManga;

            // Bolsas Exteriores
            $saco->tipo_bolsas_ext = $request->bolsasExt;
            $saco->pickstitch = $request->pickstitch ? true : false;
            $saco->sin_aletilla = $request->sinaletilla ? true : false;
            

            // Datos de Saco Interno
            $saco->tipo_vista = $request->tipoVista;

                        

            //Bies y pinpoint
            $saco->tipo_accesorio = $request->tipoAccesorio;
            if ($saco->tipo_accesorio === 0) {
                // Color Pinpoint
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código de Pinpoint
                $saco->accesorio_codigo = $request->pinPointInternoCodigo;
                
            }elseif ($saco->tipo_accesorio === 1) {
                //Color de Bies
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código Bies
                $saco->accesorio_codigo = $request->biesInternoCodigo;
            }else{
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código Bies y pinpoint
                $saco->accesorio_codigo = $request->pinpointbiesInternoCodigo;
            }
            

            // Tipo de Bolsas Internas
            $saco->bolsas_int = $request->bolsasInt;

            
            // Puntadas
            $saco->puntada_filos = $request->pickstitch ? true : false;
            $saco->puntada_aletillas = $request->pickstitch ? true : false;
            $saco->puntada_carteras = $request->pickstitch ? true : false;
            // Notas del Saco
            $saco->notas_ext = $request->notasSacoExt;
            $saco->notas_int = $request->notasSacoInt;
            // Guardar los datos del Saco
            $saco->save();
        }else if (!isset($saco) && $orden->has_coat) {
            $saco = new Coat;

            // Medidas Corporales
            $saco->fit_id = $request->fitSaco;
            $saco->personalizacion_holgura_saco = $request->personalizacionHolguraSaco;
            $saco->largo_manga_izquierda_saco = $request->largoMangaIzquierdaSaco;
            $saco->largo_manga_derecha_saco = $request->largoMangaDerechaSaco;
            $saco->largo_espalda_deseado = $request->largoEspaldaSaco;

            $saco->order_id = $orden->id;
            $saco->tipo_solapa = $request->tipoSolapa; //Solapa 
            // Todo lo referente a Mangas 
            $saco->botones_mangas = $request->botonesMangas; // Número de botones en mangas
            $saco->tipo_ojal_manga = $request->tipoOjalManga; //Al tono o en contraste
            $saco->posicion_ojales_contraste = $request->posicionOjalesContrasteMangas;
            
            // Tipo de Ojal de Solapa
            $saco->tipo_ojal_solapa = $request->tipoOjalSolapa; //Al tono o en contraste
            // Color del ojal en solapa
            $saco->color_ojal_manga = $request->colorOjalSolapa;
            $saco->color_ojal_solapa = $request->colorOjalSolapa;         

            
            if ($request->otroColorOjalSolapa) {
                $saco->color_ojal_manga = $request->otroColorOjalSolapa;
                $saco->color_ojal_solapa = $request->otroColorOjalSolapa;
            }
            //ojal activo en solapa
            $saco->ojal_activo_solapa = $request->ojalActivoSolapa ? true : false;
            //Posición de los ojales en contraste para solapa
            $saco->posicion_ojal_solapa = $request->posicionOjalesSolapa;
            //Botones
            $saco->botones_frente = $request->botonesFrente;
            //Aberturas
            $saco->aberturas_detras = $request->aberturasDetras;
            
            $saco->posicion_ojal_manga = $request->posicionOjalesManga;
            $saco->ojales_activos_manga = $request->ojalesActivosManga ? true : false;
          

            // Bolsas Exteriores
            $saco->tipo_bolsas_ext = $request->bolsasExt;
            $saco->pickstitch = $request->pickstitch ? true : false;
            $saco->sin_aletilla = $request->sinaletilla ? true : false;
            

            // Datos de Saco Interno
            $saco->tipo_vista = $request->tipoVista;                        

            //Bies y pinpoint
            $saco->tipo_accesorio = $request->tipoAccesorio;
            if ($saco->tipo_accesorio === 0) {
                // Color Pinpoint
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código de Pinpoint
                $saco->accesorio_codigo = $request->pinPointInternoCodigo;
                
            }elseif ($saco->tipo_accesorio === 1) {
                //Color de Bies
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código Bies
                $saco->accesorio_codigo = $request->biesInternoCodigo;
            }else{
                if ($request->otroColorPuntada) {
                    $saco->accesorio_color = $request->otroColorPuntada;
                } else {
                    $saco->accesorio_color = $request->colorPuntada;
                }

                // Código Bies y pinpoint
                $saco->accesorio_codigo = $request->pinpointbiesInternoCodigo;
            }
            

            // Tipo de Bolsas Internas
            $saco->bolsas_int = $request->bolsasInt;
            
            // Puntadas
            $saco->puntada_filos = $request->pickstitch ? true : false;
            $saco->puntada_aletillas = $request->pickstitch ? true : false;
            $saco->puntada_carteras = $request->pickstitch ? true : false;
            // Notas del Saco
            $saco->notas_ext = $request->notasSacoExt;
            $saco->notas_int = $request->notasSacoInt;
            // Guardar los datos del Saco
            $saco->save();
            //return $saco;
        }

        

        // Notify the user about the new order
        $request->session()->flash('success', '¡Se ha editado correctamente la orden #'.$orden->id.'!');

        // Send Emails about new Order
        if ($this->configuracion->notificar_vendedor_nueva_orden) {
            Notification::send($orden->vendedor, new NewOrder($orden->vendedor,$orden));
        }
        if ($this->configuracion->notificar_validador_nueva_orden) {
            foreach (Validador::all() as $validador) {
                Notification::send($validador, new NewOrder($validador,$orden));
            }
        }
        if ($this->configuracion->notificar_admin_nueva_orden) {
            foreach (Admin::all() as $admin) {
                Notification::send($admin, new NewOrder($admin,$orden));
            }
        }
        // Redirect to Orders:Home
        return redirect('/admin/ordenes');
    }

    public function editPrecioOP($id){
        $orden = Order::find($id);
        $clientes = Client::all();
        $saco = Coat::find($id);        
        $chaleco = Vest::find($id);
        $pantalon = Pants::find($id);
        if (!$orden ) {
            Session::flash('danger','La orden que deseas editar no puede ser mostrada porque no tienes autorización para verla o no existe.');
            return redirect('/admin/ordenes');
        }
        return view('admin.order.editPrecioOP', compact('orden', 'clientes', 'saco', 'chaleco', 'pantalon'));
    }
    public function updatePrecioOP(Request $request, $id)
    {
        //return $request;
        $orden = Order::find($id);
        
        if (!$orden) {
            Session::flash('danger','La orden que deseas editar no puede ser mostrada porque no tienes autorización para verla o no existe.');
            return redirect('/admin/ordenes');
        }

        $orden->precio = $request->precio;
        $orden->consecutivo_op = $request->consecutivo_op;
        

        $orden->save();

        // Redirect to Orders:Home
        return redirect('/admin/ordenes/'.$id);
    }
    public function editPrecioOPForVendedor($id){
        $orden = Order::find($id);
        $clientes = Client::all();
        $saco = Coat::find($id);        
        $chaleco = Vest::find($id);
        $pantalon = Pants::find($id);
        if (!$orden ) {
            Session::flash('danger','La orden que deseas editar no puede ser mostrada porque no tienes autorización para verla o no existe.');
            return redirect('/vendedor/ordenes');
        }
        return view('vendedor.order.editPrecioOP', compact('orden', 'clientes', 'saco', 'chaleco', 'pantalon'));
    }
    public function updatePrecioOPForVendedor(Request $request, $id)
    {
        $orden = Order::find($id);
        
        if (!$orden) {
            Session::flash('danger','La orden que deseas editar no puede ser mostrada porque no tienes autorización para verla o no existe.');
            return redirect('/vendedor/ordenes');
        }

        $orden->precio = $request->precio;
        $orden->consecutivo_op = $request->consecutivo_op;
        

        $orden->save();

        // Redirect to Orders:Home
        return redirect('/vendedor/ordenes/'.$id);
    }
}
