<?php

namespace App\Model;

use App\Model\Role;
use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    public function roles()
    {
    	return $this->belongsToMany(Role::class);
    }
}
