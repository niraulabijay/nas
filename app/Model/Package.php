<?php

namespace App\Model;

use App\Model\Advertise;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
	protected $fillable = [
		'period'
	];
	
	public function advertises()
	{
		return $this->hasMany(Advertise::class);
	}
}
