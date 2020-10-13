<?php

namespace App\Model;

use App\Model\Area;
use App\Model\Package;
use App\Model\Type;
use Illuminate\Database\Eloquent\Model;

class Advertise extends Model
{
	protected $fillable = [
		'title',
		'image',
		'advertise_area',
		'package'
	];
	
	public function areas()
	{
		return $this->belongsToMany(Area::class);
	}

	public function packages()
	{
		return $this->belongsToMany(Package::class);
	}

	public function types()
	{
		return $this->belongsToMany(Type::class);
	}
}
