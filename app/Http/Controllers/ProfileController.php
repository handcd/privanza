<?php

namespace App\Http\Controllers;

use App\Vendedor;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function perfilVendedor()
    {
        $vendedor = Vendedor::find(Auth::id());
        return view('vendedor.profile',compact('vendedor'));
    }

    /**
     * Send an email to the administrador and validador asking
     * for a information review.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataChangeVendedor(Request $request)
    {
        $request->session()->flash('success','¡Listo! Hemos enviado una notificación al administrador. En breve se pondrán en contacto contigo para actualizar tus datos.');
        return redirect()->back();
    }
}
