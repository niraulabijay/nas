<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;
class VendorDetail extends Model
{
     use Sluggable;
     
     public function sluggable() {
        return [
            'slug' => [
                'source' => ['name']
            ]
        ];
    }

     
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'type',
        'pan_number',
        'registration_no',
    	'primary_email',
        'secondary_email',
        'primary_phone',
        'secondary_phone',
        'address',
        'verified',
        'tax_clearance'
    ];

    public function users()
    {
    	return $this->belongsTo(User::class);
    }
}
