<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class DeliveryBoy extends Model
{
    protected $fillable = [
        'user_id',
        'delivery_destination_id'
    ];
    
    public function destinations()
    {
        return $this->belongsTo(DeliveryDestination::class, 'delivery_destination_id');
    }
    
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
