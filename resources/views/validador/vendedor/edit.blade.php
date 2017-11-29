@extends('validador.vendedor.create')

@section('editId',$vendedor->id)
@section('editName',$vendedor->name)
@section('editAddress',$vendedor->address)
@section('editEmail', $vendedor->email)
@section('editPhone', $vendedor->phone)
@section('editEnabled',$vendedor->enabled ? "si" : "no")

@section('editMethod')
    {{method_field('PUT')}}
@endsection