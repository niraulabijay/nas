<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $fillable = [
    	'keyword',
    	'link',
    	'status'
    ];
}
