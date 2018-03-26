<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
	/**
	 * Get the related Adjustment Order for this Adjustment.
	 * @return App\AdjustmentOrder
	 */
	public function adjustmentOrder()
	{
		return $this->belongsTo(AdjustmentOrder::class);
	}
}
