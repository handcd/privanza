<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	/**
	 * Get the Vendedorthat registered the order
	 * @param null
	 * @return Vendedor
	 */
	public function vendedor()
	{
		return $this->belongsTo(Vendedor::class);
	}
	/**
	 * Get the Client that owns the order
	 */
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

    /**
    * Determines the status of the current order
    * @param null
    * @return string - the name of the current status of the order
    */
    public function currentStatus()
    {
    	if ($this->cobrado) {
    		return 'cobrado';
    	} elseif ($this->facturado) {
    		return 'facturado';
    	} elseif ($this->delivered) {
    		return 'delivered';
    	} elseif ($this->pickup) {
    		return 'pickup';
    	} elseif ($this->revision) {
    		return 'revision';
    	} elseif ($this->plancha) {
    		return 'plancha';
    	} elseif ($this->ensamble) {
    		return 'ensamble';
    	} elseif ($this->corte) {
    		return 'corte';
    	} elseif ($this->production) {
    		return 'production';
    	} elseif ($this->approved) {
    		return 'approved';
    	} else {
    		return 'unapproved';
    	}
    }
}
