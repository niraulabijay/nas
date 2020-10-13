<?php

namespace App\Model;

use App\Model\Advertise;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
	protected $fillable = [
		'area'
	];
	
	public function advertises()
	{
		return $this->hasMany(Advertise::class);
	}
}
