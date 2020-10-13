<?php

namespace App\Model;

use App\Concern\Mediable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
	use Sluggable, Mediable;

	/**
	 * Return the sluggable configuration array for this model.
	 *
	 * @return array
	 */
	public function sluggable() {
		return [
			'slug' => [
				'source' => 'name'
			]
		];
	}

    protected $fillable = [
    	'user_id',
    	'slug',
    	'name',
    	'position',
    	'content',
    	'facebook_link',
    	'twitter_link',
    	'googleplus_link',
    	'linkedin_link',
    	'status',
    	'priority'
    ];

    public function users()
    {
    	return $this->belongsTo(User::class);
    }
}
