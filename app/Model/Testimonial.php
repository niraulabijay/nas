<?php

namespace App\Model;

use App\Concern\Mediable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
	use Sluggable, Mediable;

	public function sluggable()
	{
		return [
			'slug' => [
				'source' => 'name'
			]
		];
	}

    protected $fillable = [
    	'name',
    	'description',
    	'profession',
    	'slug',
    	'status'
    ];

    public function users()
    {
    	return $this->belongsTo(User::class);
    }
}
