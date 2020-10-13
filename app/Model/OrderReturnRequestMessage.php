<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderReturnRequestMessage extends Model
{
    protected $fillable = [
        'order_return_request_id',
        'topic_id',
        'message_text'
    ];

    public function orderReturns()
    {
        return $this->belongsTo(OrderReturnRequest::class);
    }
}
