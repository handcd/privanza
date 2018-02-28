<?php

namespace App\Jobs;

// Mails
use Mail;
use App\Mail\ValidadorUpdateVendedorProfile;

// Models
use App\Validador;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendVendedorProfileUpdateEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Protected Vendedor
    protected $vendedor;

    /**
     * Create a new job instance.
     *
     * @param App\Vendedor
     * @return void
     */
    public function __construct($vendedor)
    {
        $this->vendedor = $vendedor;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Notification Email
        $notificacionValidador = new ValidadorUpdateVendedorProfile($this->vendedor);

        // Notify All Validadores
        foreach (Validador::all() as $validador) {
            Mail::to($validador->email)->send($notificacionValidador);
        }
    }
}
