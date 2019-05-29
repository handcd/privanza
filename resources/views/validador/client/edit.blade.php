@extends('validador.client.create')

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

{{-- Información sobre medidas --}}
@section('editAltura', $cliente->altura)
@section('editPeso', $cliente->peso)
@section('editEdad', $cliente->edad)
@section('editCuello', $cliente->contornoCuello)
@section('editBiceps', $cliente->contornoBiceps)
@section('editContornoHombros', $cliente->medidaHombros)
@section('editBrazoDerecho', $cliente->brazoDerecho)
@section('editBrazoIzquierdo', $cliente->brazoIzquierdo)
@section('editHombroIzquierdo', $cliente->hombroIzquierdo )
@section('editHombroDerecho', $cliente->hombroDerecho )
{{--@section('editAnchoEspalda', $cliente->anchoEspalda )--}}
@section('editLargoTorso', $cliente->largoTorso )
@section('editContornoPecho', $cliente->contornoPecho )
@section('editPunio', $cliente->punio)
@section('editContornoAbdomen', $cliente->contornoAbdomen)
@section('editCintura', $cliente->contornoCintura)
@section('editCadera', $cliente->contornoCadera)
@section('editLargoTiro', $cliente->largoTiro)
@section('editLargoExterno', $cliente->largoExternoPantalon)
@section('editLargoInterno', $cliente->largoInternoPantalon)
@section('editMuslo', $cliente->contornoMuslo)
@section('editRodilla', $cliente->contornoRodilla)

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