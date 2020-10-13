<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TempOrder extends Model
{

    protected $fillable=[
        'order_id',
        'address_id',
        'shipping_amount'
    ];



}
