<?php

namespace App\Model;

use App\Model\Advertise;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
	protected $fillable = [
		'type',
		'size'
	];

	public function advertises()
	{
		return $this->hasMany(Advertise::class);
	}

}
