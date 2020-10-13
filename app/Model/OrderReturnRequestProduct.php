<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderReturnRequestProduct extends Model
{
    protected $fillable = [
        'order_return_request_id',
        'order_product_id',
        'qty'
    ];

    public function order_returns()
    {
        return $this->belongsTo(OrderReturnRequest::class);
    }

    public function order_product()
    {
        return $this->belongsTo(OrderProduct::class);
    }
}
