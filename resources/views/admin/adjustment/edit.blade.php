@extends('admin.adjustment.create')

{{-- Info General --}}
@section('editId',$adjustmentOrder->id)
@section('editConsecutivoAjuste', $adjustmentOrder->consecutivo_ajuste)
@section('editConsecutivoOp', $adjustmentOrder->consecutivo_op)

@section('editMethod')
    {{method_field('PUT')}}
@endsection