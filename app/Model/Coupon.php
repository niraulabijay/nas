<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'name',
        'description',
        'code',
        'discount_value',
        'max_discount_value',
        'start_date',
        'end_date',
        'categories',
        'brands',
        'products',
        'uses_per_coupon',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

//    public function couponProduct()
//    {
//        return $this->belongsTo(CouponProduct::class);
//    }
}
