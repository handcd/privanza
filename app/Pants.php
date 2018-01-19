<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pants extends Model
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
}
