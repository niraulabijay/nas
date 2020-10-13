<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class NegotiablePrice extends Model
{

    protected $fillable = [
        'negotiable_id',
        'user_id',
        'message',
        'active'
    ];

   public  function  negotiable(){
       return $this->belongsTo(Negotaible::class);
   }
}
