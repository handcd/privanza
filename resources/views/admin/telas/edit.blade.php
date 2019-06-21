@extends('admin.telas.create')

{{-- Info General --}}
@section('editId',$tela->id)
@section('editCodigoTela', $tela->codigo_tela)
@section('editColorTela', $tela->color_tela)
@section('editNombreTela', $tela->nombre_tela)
@section('editComposicion', $tela->composicion)
@section('editEstado', $tela->estado)

@section('editMethod')
    {{method_field('PUT')}}
@endsection