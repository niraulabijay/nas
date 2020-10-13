<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Referal extends Model
{
    protected $fillable = [
        'user_id',
        'referal_code'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
