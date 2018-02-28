<?php

namespace App\Jobs;

use Mail;
use App\Validador;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Mail\VendedorNewOrder;
use App\Mail\ValidadorNewOrder;

class SendNewOrderEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Protected Order
    protected $order;

    /**
     * Create a new job instance.
     *
     * @param App\Order
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Prepare the emails
        $emailVendedor = new VendedorNewOrder($this->order);
        $emailValidador = new ValidadorNewOrder($this->order);

        // Send emails to all validators
        foreach (Validador::all() as $validador) {
            Mail::to($validador->email)->send($emailValidador);
        }
        // Send email to vendedor
        Mail::to($this->order->vendedor->email)->send($emailVendedor);
    }
}
