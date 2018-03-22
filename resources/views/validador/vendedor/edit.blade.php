@extends('validador.vendedor.create')

@section('editId',$vendedor->id)
@section('editName',$vendedor->name)
@section('editLastname',$vendedor->lastname)
@section('editEmail', $vendedor->email)
@section('editAddress',$vendedor->address_home)
@section('editPhone', $vendedor->phone)
@section('editBirthday',$vendedor->birthday)
@section('editRFC',$vendedor->rfc)
@section('editDigits',$vendedor->account_digits)
@section('editBank',$vendedor->bank)
@section('editLegalAddress',$vendedor->address_legal)
@section('editConcept',$vendedor->concept)
@section('editType',$vendedor->name) {{-- Just setting data in order to create the section --}}
@section('editEnabled',$vendedor->enabled)

@section('editMethod')
    {{method_field('PUT')}}
@endsection