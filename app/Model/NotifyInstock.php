<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class NotifyInstock extends Model
{
	use Notifiable;
	
    protected $fillable = ['product_id', 'email'];
}
