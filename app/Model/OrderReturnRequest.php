<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class OrderReturnRequest extends Model
{
    protected $fillable = [
        'user_id',
        'user_option',
        'status_id'
    ];

    public function orderReturnProducts()
    {
        return $this->hasMany(OrderReturnRequestProduct::class, 'order_return_request_id');
    }

    public function orderReturnMessage()
    {
        return $this->hasMany(OrderReturnRequestMessage::class, 'order_return_request_id');
    }

    public function orderReturnStatus()
    {
        return $this->belongsTo(OrderReturnStatus::class, 'status_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
