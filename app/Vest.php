<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vest extends Model
{
    /**
	 * Get the Order owner of this model
	 * @param null
	 * @return Order::class
	 */
	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	/**
	 * Get the Fit related to this Order
	 * @param null
	 * @return Fit:class
	 */
	public function fit()
	{
		return $this->belongsTo(Fit::class);
	}
}
