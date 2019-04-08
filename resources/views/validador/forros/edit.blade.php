@extends('validador.forros.create')

{{-- Info General --}}
@section('editId',$forro->id)
@section('editCodigoForro', $forro->codigo_forro)
@section('editColorForro', $forro->color_forro)
@section('editNombreForro', $forro->nombre_forro)
@section('editComposicion', $forro->composicion)
@section('editEstado', $forro->estado)

@section('editMethod')
    {{method_field('PUT')}}
@endsection