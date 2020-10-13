<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable = ['user_id', 'commission'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
