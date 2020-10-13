<?php

namespace App;

use App\Concern\Mediable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model {
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
		'name',
		'slug',
		'content'
	];

	/**
	 * Return the post's author
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {
		return $this->belongsTo( User::class );
	}
}
