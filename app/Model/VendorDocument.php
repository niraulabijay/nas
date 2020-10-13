<?php

namespace App\Model;

use App\Model\VendorDetail;
use Illuminate\Database\Eloquent\Model;

class VendorDocument extends Model
{
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        	'vendor_detail_id',
        	'title',
        	'image',
    ];

    protected $table = 'vendor_documents';

    public function vendors(){
    	return $this->belongsTo(Vendor::class);
    }
}
