<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * Get the orders by the current Client
     * @param void
     * @return Orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    /**
     * Get the events associated with the current Client
     */
    public function events()
    {
    	return $this->hasMany(Event::class);
    }

    /**
     * Get the vendedor that owns this Client
     */
    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class);
    }

    /**
     * Fits de Saco, Pantalón y Chaleco
     */
    public function sacoFit()
    {
        return $this->hasOne(Fit::class,'id','fit_saco');
    }

    public function pantalonFit()
    {
        return $this->hasOne(Fit::class,'id','fit_pantalon');
    }

    public function chalecoFit()
    {
        return $this->hasOne(Fit::class,'id','fit_chaleco');
    }
}
