<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_info extends Model
{
    protected $fillable = [
        'user_id',
        'username',
//        'first_name',
//        'last_name',
        'gender',
        'image',
        'dob'
    ];

    public function users()
    {
    	return $this->belongsTo(User::class);
    }
}
