<?php

namespace App\Http\Controllers\Validador;

use App\Validador;
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
        $validador = Validador::find(Auth::id());
        return view('validador.profile',compact('validador'));
    }

    public function askDataChange()
    {
        // TODO: notify admin with data change...
        $msg = "¡Listo! Hemos enviado una notificación al administrador. En breve se pondrán en contacto contigo para actualizar tus datos.";

        return redirect()->back()->with('msg', $msg);
    }
}
