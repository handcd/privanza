@extends('admin.client.create')

{{-- Info General --}}
@section('editId',$cliente->id)
@section('editNombreClient',$cliente->name)
@section('editApellidoClient',$cliente->lastname)
@section('editEmailClient', $cliente->email)
@section('editPhoneClient', $cliente->phone)
@section('editBirthdayClient', $cliente->birthday)
@section('editAddressDelivery', $cliente->address_delivery)
@section('editAddressVisit', $cliente->address_visit)
@section('editNotas', $cliente->notes)

{{-- Info Facturación --}}
@section('editAddressLegal', $cliente->address_legal)
@section('editRFC', $cliente->rfc)
@section('editBank', $cliente->bank)
@section('editConcept', $cliente->concept)
@section('editDigitos', $cliente->account_digits)

{{-- Info Referencia --}}
@section('editContactoReferencia', $cliente->contacto)

@section('editMethod')
    {{method_field('PUT')}}
@endsection