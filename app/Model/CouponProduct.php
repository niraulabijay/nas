<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CouponProduct extends Model
{
    protected $table = 'coupon_product';

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_id');
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_id');
    }
}
