<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fit extends Model
{
	/**
	 * Get the Coats with this Fit
	 *
	 * @param null
	 * @return Coat::class collection
	 */
	public function coats()
	{
		return $this->hasMany(Coat::class);
	}

	/**
	 * Get the Pants with this Fit
	 *
	 * @param null
	 * @return Pants::class collection
	 */
	public function pants()
	{
		return $this->hasMany(Pants::class);
	}

	/**
	 * Get the Vests with this Fit
	 *
	 * @param null
	 * @return Vest::class collection
	 */
	public function vests()
	{
		return $this->hasMany(Vest::class);
	}
}
