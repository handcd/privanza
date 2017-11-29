<?php

namespace App\Http\Controllers\Vendedor;

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
    public function index()
    {
        $vendedor = Vendedor::find(Auth::id());
        return view('vendedor.profile',compact('vendedor'));
    }

    public function askDataChange()
    {
        // TODO: notify admin with data change...
        $msg = "¡Listo! Hemos enviado una notificación al administrador. En breve se pondrán en contacto contigo para actualizar tus datos.";

        return redirect()->back()->with('msg', $msg);
    }
}
