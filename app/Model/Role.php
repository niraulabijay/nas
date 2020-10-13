<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    public function users()
    {
    	return $this->belongstoMany(User::class);
    }
}
