<?php

namespace App\Model;

use App\Model\VendorDetail;
use Illuminate\Database\Eloquent\Model;

class VendorSeo extends Model
{
    protected $fillable = [
        'vendor_detail_id',
    	'seo_keywords',
    	'seo_description'
    ];

    public function vendors(){
    	return $this->belongsTo(Vendor::class);
    }
}
