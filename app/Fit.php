<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fit extends Model
{
	public function client()
	{
		return $this->belongsTo(Client::class,'fit_saco');
	}
}
