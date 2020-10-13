<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'user_id',
        'vendor_id',
        'status'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(OrderProduct::class, 'order_product_id');
    }

    public function disputeMessages()
    {
        return $this->hasMany(DisputeMessage::class);
    }

    public function disputeResult()
    {
        return $this->hasOne(DisputeResult::class);
    }
}
