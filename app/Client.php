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
}
