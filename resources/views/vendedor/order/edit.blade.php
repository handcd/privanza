@extends('vendedor.order.create')

{{-- Primer Sección --}}
@section('editCliente',$orden->client->id)
@section('editCoat',$orden->has_coat)
@section('editVest',$orden->has_vest)
@section('editPants',$orden->has_pants)
@section('tipoTelaIsco',$orden->tela_isco)


{{--
@section('editId',$evento->id)
@section('editCliente',$evento->client->id)
@section('editFecha', Carbon\Carbon::parse($evento->fechahora)->format('Y-m-d\TH:i:s'))
--}}

@section('editMethod')
    {{method_field('PUT')}}
@endsection