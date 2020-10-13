<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VendorAddressDetail extends Model
{
    protected $fillable = [
    	'name', 
    	'email', 
    	'showroom', 
    	'phone', 
    	'shop_name', 
    	'address',
    ];

    public function vendors()
    {
    	return $this->belongsTo(Vendor::class);
    }
}
