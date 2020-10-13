<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeliveryDestination extends Model
{
    protected $fillable = [
        'name',
        'remark'
    ];
    
    public function orders()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function delivery_boys()
    {
        return $this->belongsTo(DeliveryBoy::class);
    }
}
