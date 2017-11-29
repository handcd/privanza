@extends('validador.client.create')

@section('editId',$cliente->id)
@section('editNombreClient',$cliente->name)
@section('editApellidoClient',$cliente->lastname)
@section('editEmailClient', $cliente->email)
@section('editPhoneClient', $cliente->phone)

@section('editMethod')
    {{method_field('PUT')}}
@endsection