<?php

namespace App;

use App\Notifications\AdminResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
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
     * To check if user is an Admin
     * 
     * @return boolean
     */
    public function isAdmin()
    {
        return true;
    }

    /**
     * To check if user is a Validador
     *
     * @return boolean
     */
    public function isValidador()
    {
        return false;
    }

    /**
     * To check if user is a Vendedor
     *
     * @return boolean
     */
    public function isVendedor()
    {
        return false;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }
}
