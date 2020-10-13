<?php

namespace App\Model;

use App\Model\Product;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ReviewProduct extends Model
{
    protected $fillable = [
    	'user_id',
    	'product_id',
    	'stars',
    	'review',
        'owner_id'
    ];

    public function products()
    {
    	return $this->belongsTo(Product::class, 'product_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
