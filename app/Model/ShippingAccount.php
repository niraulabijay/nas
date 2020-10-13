<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShippingAccount extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'country',
        'area',
        'district',
        'zone',
        'address',
        'is_default',
        'location_type',
        'mobile',
        'phone'
    ];
    
    public function shippingMain()
    {
        return $this->hasOne(MainShipping::class);
    }
}
