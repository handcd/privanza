<?php

namespace App;

use App\Notifications\VendedorResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Vendedor extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the orders by the current Vendedor
     * @param void
     * @return Orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the events associated with the current Vendedor
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new VendedorResetPassword($token));
    }
}
