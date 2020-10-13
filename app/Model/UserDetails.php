<?php

namespace App\Model;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        	'user_id',
        	'gender',
            'DOB', 
    ];


    public function user(){
    	return $this->belongsTo(User::class);
    }
}
