<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telas extends Model
{
    public function order()
	{
		return $this->belongsTo(Order::class);
	}
}
