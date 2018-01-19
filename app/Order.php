<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	/**
	 * Get the Vendedores that registered the order
	 * @param null
	 * @return Vendedores::array
	 */
	public function vendedor()
	{
		return $this->belongsTo(Vendedor::class);
	}

	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	/**
	* Get the Coat related to this order
	* @param null
	* @return Coat::class
	*/
	public function coat()
	{
		return $this->hasOne(Coat::class);
	}

	/**
	* Get the Vest related to this order
	* @param null
	* @return Vest::class
	*/
	public function vest()
	{
		return $this->hasOne(Vest::class);
	}

	/**
	* Get the Pants related to this order
	* @param null
	* @return Pants::class
	*/
	public function pants()
	{
		return $this->hasOne(Pants::class);
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
