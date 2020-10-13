<?php

namespace App\Model;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	use Sluggable;

	protected $fillable=[
		'name',
		'description',
		'title',
		'parent_id',
		'image'
	];
	public function sluggable() {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function products(){
	    return $this->belongsToMany(Product::class);
    }

	public function parent()
	{
	    return $this->belongsTo('App\Model\Category', 'parent_id');
	}

	public function children()
	{
	    return $this->hasMany('App\Model\Category', 'parent_id');
	}

}
