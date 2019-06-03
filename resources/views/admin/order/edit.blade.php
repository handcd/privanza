@extends('admin.order.create')
{{-- Primer Sección --}}
@section('editOrden',$orden->id)
@section('editCliente',$orden->client)
@section('editCoat',$orden->has_coat)
@section('editVest',$orden->has_vest)
@section('editPants',$orden->has_pants)
{{-- Tipo de tela --}}
@if($orden->tela_isco === 1 )
	@section('editCodigoTela',$orden->tela)
@elseif($orden->tela_isco === 0)
	@section('editCodigoTela',$orden->codigo_tela)
	@section('editNombreTela',$orden->nombre_tela)
	@section('editColorTela',$orden->color_tela)
	@section('editCodigoColorTela',$orden->codigo_color_tela)
	@section('editMetrosTela',$orden->mts_tela_cliente)
@endif
{{-- Tipo de forro --}}
@if($orden->forro_isco === 1)
	@section('editCodigoForroIsco',$orden->codigo_forro)
	@section('editNombreForroIsco',$orden->nombre_forro)
	@section('editColorForroIsco',$orden->color_forro)
	@section('editCodigoColorForroIsco',$orden->codigo_color_forro)
@elseif($orden->forro_isco === 0)
	@section('editCodigoForro',$orden->codigo_forro)
	@section('editNombreForro',$orden->nombre_forro)
	@section('editColorForro',$orden->color_forro)
	@section('editCodigoColorForro',$orden->codigo_color_forro)
	@section('editMetrosForro',$orden->mts_forro_cliente)
@endif
{{-- Botones --}}
@section("editTipoBotones",$orden->tipo_botones)
@section("editCodigoBotones",$orden->codigo_botones)
@section("editColorBotones",$orden->color_botones)
@if($orden->tipo_botones == 1)
	@section("editCantidadBotones",$orden->cantidad_botones)
@endif	
{{-- Etiquetas --}}
@section("editEtiquetaTela",$orden->etiquetas_tela)
@section("editEtiquetaMarca", $orden->etiquetas_marca)
@if($orden->etiquetas_tela)
	@section("editMarcaTela",$orden->marca_en_tela)
@endif
@if($orden->etiquetas_marca)
	@section("editMarcaEtiqueta",$orden->marca_en_etiqueta)
@endif
{{-- Gancho --}}
@if($orden->gancho === 2)
	@section("editPerGancho",$orden->gancho_personalizacion)
@endif
{{-- Portatrajes --}}
@if($orden->portatrajes === 2)
	@section("editPerPortatrajes",$orden->portatrajes_personalizacion)
@endif
{{-- Bordado --}}
@section("editNombreBordado",$orden->bordado)
@if($orden->bordadoColor !== 'Gris Plata')
	@section("editColorBordado", $orden->bordadoColor)
@endif
@if(isset($orden->precio))
	@section("editPrecio", $orden->precio)
@endif

@if(isset($orden->consecutivo_op))
	@section("editCOP", $orden->consecutivo_op)
@endif

{{-- Segunda Sección --}}
@if($orden->has_coat && isset($saco))
	@if($saco->fit_id === 1)
		@section("editPerSaco",$saco->personalizacion_holgura_saco)
	@endif
	@section("editLargoMangaDerecha", $saco->largo_manga_derecha_saco)
	@section("editLargoMangaIzquierda", $saco->largo_manga_izquierda_saco)
	@section("editLargoEspalda", $saco->largo_espalda_deseado)
@endif
@if($orden->has_vest && isset($chaleco))
	@if($chaleco->fit_id === 1)
		@section("editPerChaleco",$chaleco->personalizacion_holgura_chaleco)
	@endif
	@section("editLargoEspaldaChaleco", $chaleco->talla)
	@section("editForroChaleco",$chaleco->tipo_forro)
@endif
@if($orden->has_pants && isset($pants))
	@if($pantalon->fit_id === 1)
		@section("editPerPants",$pantalon->personalizacion_holgura_pantalon)
	@endif
@endif


{{--
@section('editId',$evento->id)
@section('editCliente',$evento->client->id)
@section('editFecha', Carbon\Carbon::parse($evento->fechahora)->format('Y-m-d\TH:i:s'))
--}}


@section('editMethod')
    {{method_field('PUT')}}
@endsection

