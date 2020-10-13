<?php

namespace App\Model;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        	'user_id',
        	'first_name',
            'last_name', 
            'phone',
            'address', 
            'email',
            'city', 
            'state',
    ];

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
