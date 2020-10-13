<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MainShipping extends Model
{
    protected $fillable = [
        'shipping_account_id',
        'user_id',
        'is_main'
    ];

    public function shipping()
    {
        return $this->belongsTo(ShippingAccount::class);
    }
}
