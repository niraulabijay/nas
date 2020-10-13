<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RequestProduct extends Model
{
    protected $fillable = [
    	'name', 'email', 'phone', 'product_title', 'product_reference', 'product_category', 'product_specification'
    ];
}
