<?php

namespace App\Model;

use App\Model\Product;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
	use Sluggable;

    protected $fillable = [
    	'name',
    	'slug'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function products()
    {
    	return $this->belongsToMany(Product::class);
    }

    public function deal_product()
    {
        return $this->hasMany(DealProduct::class, 'deal_id');
    }
}
