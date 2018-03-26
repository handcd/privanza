<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdjustmentOrder extends Model
{
	/**
	 * Get the related adjustments for this order.
	 * @return App\Adjustments
	 */
	public function adjustments()
	{
		return $this->hasMany(Adjustment::class);
	}

	/**
	 * Get the related Client for this adjustment order.
	 * @return App\Client
	 */
	public function client()
	{
		return $this->belongsTo(Client::class);
	}
}
