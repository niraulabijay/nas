<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Prebooking extends Model
{
    protected $fillable = [
    	'order_id',
    	'product_id',
    	'price',
        'status'
    ];

    public function orders()
    {
    	return $this->belongsTo(Order::class, 'order_id');
    }

    public function products()
    {
    	return $this->belongsTo(Product::class, 'product_id');
    }
}
