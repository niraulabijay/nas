<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorRating extends Model
{
    protected $fillable = [
    	'user_id',
    	'stars',
    	'review',
        'vendor_id',
        'status'
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
