@extends('vendedor.client.create')

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

{{-- Info Saco --}}
@section('editFitSaco', $cliente->fit_saco)
@section('editCorteSaco', $cliente->corte_saco)
@section('editTallaSaco', $cliente->talla_saco)
@section('editLargoManga', $cliente->largo_manga)
@section('editLargoEspalda', $cliente->largo_espalda)
@section('editNotasSaco', $cliente->notas_saco)

{{-- Info Chaleco --}}
@section('editFitChaleco', $cliente->fit_chaleco)
@section('editCorteChaleco', $cliente->corte_chaleco)
@section('editTallaChaleco', $cliente->talla_chaleco)
@section('editlargoEspaldaChaleco', $cliente->largo_espalda_chaleco)
@section('editNotasChaleco', $cliente->notas_chaleco)

{{-- Info Pantalón --}}
@section('editFitPantalon', $cliente->fit_pantalon)
@section('editTallaPantalon', $cliente->talla_pantalon)
@section('editLargoExtPantalon', $cliente->largo_pantalon_ext)
@section('editLargoIntPantalon', $cliente->largo_pantalon_int)
@section('editNotasPantalon', $cliente->notas_pantalon)

{{-- Info Referencia --}}
@section('editContactoReferencia', $cliente->contacto)

@section('editMethod')
    {{method_field('PUT')}}
@endsection