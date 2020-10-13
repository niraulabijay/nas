<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'user_id',
        'amount'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
