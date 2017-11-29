<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	/**
	 * Get the Vendedors associated with the current Event
	 */
	public function vendedor()
	{
		return $this->belongsTo(Vendedor::class);
	}

	/**
	 * Get the Clients associated with the current Event
	 */
	public function client()
	{
		return $this->belongsTo(Client::class);
	}
}
