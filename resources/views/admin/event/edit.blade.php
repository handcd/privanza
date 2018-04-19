@extends('admin.event.create')

@section('editId',$evento->id)
@section('editCliente',$evento->client->id)
@section('editFecha', Carbon\Carbon::parse($evento->fechahora)->format('Y-m-d\TH:i:s'))
@section('editNotes', $evento->notes)

@section('editMethod')
    {{method_field('PUT')}}
@endsection