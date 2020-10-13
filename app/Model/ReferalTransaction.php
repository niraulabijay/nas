<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ReferalTransaction extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'amount'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
