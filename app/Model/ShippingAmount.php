<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShippingAmount extends Model
{
    protected $fillable = [
        'place',
        'amount'
    ];

    public function orders()
    {
        return $this->belongsTo(Order::class);
    }
}
