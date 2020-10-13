<?php

namespace App\Model;

use App\Model\VendorDetail;
use Illuminate\Database\Eloquent\Model;

class VendorCategory extends Model
{
    protected $fillable = [
        	'vendor_detail_id',
        	'category',
    ];

    public function vendors(){
    	return $this->belongsTo(Vendor::class);
    }
}
