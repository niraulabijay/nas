<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    public function order(){
        return $this->hasOne(Order::class,'order_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }


    public function referralInfo(){
        return $this->hasOne(ReferralInfo::class);
    }

}
