<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forro extends Model
{
    public function order()
	{
		return $this->belongsTo(Order::class);
	}
}
