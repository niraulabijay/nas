<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
       'user_id',
        'name',
        'description',
        'type',
        'pan_number',
        'registration_no',
    	'primary_email',
        'secondary_email',
        'primary_phone',
        'secondary_phone',
        'bank_name',
        'bank_branch',
        'bank_account_name',
        'bank_account_number',
        'vendor_image',
        'address',
        'verified',
        'tax_clearance'
    ];

    protected $table = 'vendor_details';

    public function vendor_address_details()
    {
    	return $this->hasMany(VendorAddressDetail::class);
    }

//    public function vendor_details()
//    {
//    	return $this->hasMany(VendorDetail::class);
//    }

    public function documents()
    {
        return $this->hasMany(VendorDocument::class, 'vendor_detail_id');
    }

    public function seos()
    {
        return $this->hasOne(VendorSeo::class, 'vendor_detail_id');
    }

    public function socials()
    {
        return $this->hasOne(VendorSocial::class, 'vendor_detail_id');
    }

    public function category()
    {
       return $this->hasMany(VendorCategory::class, 'vendor_detail_id');
    }

    public function withdrawl()
    {
        return $this->hasMany(WithDraw::class, 'user_id');
    }
    
}
