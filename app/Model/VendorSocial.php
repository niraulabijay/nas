<?php

namespace App\Model;

use App\Model\VendorDetail;
use Illuminate\Database\Eloquent\Model;

class VendorSocial extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        	'vendor_detail_id',
        	'facebook_url',
        	'google_url',
        	'twitter_url',
        	'instagram_url'
    ];

    public function vendors(){
        return $this->belongsTo(Vendor::class);
    }
}
