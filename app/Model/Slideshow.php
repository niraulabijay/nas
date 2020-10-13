<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Concern\Mediable;
class Slideshow extends Model

{
    use Mediable;
    protected $fillable=[
    	'name',
        'link',
        'priority',
        'option',
        'status',
        'image',
    ];

}
