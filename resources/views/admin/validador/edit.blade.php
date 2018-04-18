@extends('admin.validador.create')

@section('editId',$validador->id)
@section('editName',$validador->name)
@section('editLastname',$validador->lastname)
@section('editEmail', $validador->email)
@section('editPhone', $validador->phone)
@section('editBirthday',$validador->birthday)
@section('editEnabled',$validador->enabled)
@section('editJobPosition',$validador->job_position)

@section('editMethod')
    {{method_field('PUT')}}
@endsection