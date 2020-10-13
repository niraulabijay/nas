<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $fillable=['order_id','paidby', 'payment_method', 'amount'];
}
