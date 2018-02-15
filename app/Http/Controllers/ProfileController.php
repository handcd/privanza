<?php

namespace App\Http\Controllers;

use App\Vendedor;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexVendedor()
    {
        $vendedor = Vendedor::find(Auth::id());
        return view('vendedor.profile',compact('vendedor'));
    }

    public function askDataChangeVendedor()
    {
        Session::flash('success','¡Listo! Hemos enviado una notificación al administrador. En breve se pondrán en contacto contigo para actualizar tus datos.');
        return redirect()->back();
    }
}
