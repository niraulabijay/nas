<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ReferralInfo extends Model
{
    public function referral(){
        return $this->belongsTo(Referral::class);
    }
}
