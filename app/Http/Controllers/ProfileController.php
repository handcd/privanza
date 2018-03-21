<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Facades
use Auth;
use Notification;

// Models
use App\Vendedor;
use App\Validador;
use App\Admin;

// Notifications
use App\Notifications\ValidadorVendedorProfile;
use App\Notifications\AdminValidadorProfile;

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
     * Display the Validador's Profile
     * @return \Illuminate\Http\Response
     */
    public function perfilValidador()
    {
        $validador = Validador::find(Auth::id());
        if (!$validador) {
            $request->session()->flash('danger', 'Ha ocurrido un problema al tratar de mostrar tu perfil.');
            return redirect()->back();
        }
        return view('validador.profile',compact('validador'));
    }

    /**
     * Send an email to the validadores asking
     * for a information review.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataChangeVendedor(Request $request)
    {
        $vendedor = Vendedor::find(Auth::id());
        // Validate vendedor
        if (!$vendedor) {
            $request->session()->flash('danger', 'Ha ocurrido un problema al tratar de notificar al validador sobre tu cambio de información.');
            return redirect()->back();
        }

        // Dispatch Email Job
        Notification::send(Validador::all(), new ValidadorVendedorProfile($vendedor));

        // Flash feedback to user
        $request->session()->flash('success','¡Listo! Hemos enviado una notificación a los validadores. En breve se pondrán en contacto contigo para actualizar tus datos.');

        // Redirect back
        return redirect()->back();
    }

    /**
     * Send an email to the admin asking
     * for a data change for the validador.
     *
     * @param null
     * @return \Illuminate\Http\Response
     */
    public function dataChangeValidador(Request $request)
    {
        $validador = Validador::find(Auth::id());

        // Validate the data
        if (!$validador) {
            $request->session()->flash('danger','Ha ocurrido un problema al tratar de notificar al Administrador sobre tu cambio de información.');
            return redirect()->back();
        }

        // Dispatch Email Job
        Notification::send(Admin::all(),new AdminValidadorProfile($validador));

        // Flash feedback to the user
        $request->session()->flash('success', '¡Listo! Hemos enviado una notificación al administrador. En breve se pondrá en contacto contigo para actualizar tus datos.');

        // Redirect back
        return redirect()->back();
    }
}
