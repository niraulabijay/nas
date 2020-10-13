<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryCharge extends Model
{
    protected $fillable=[
        'name',
        'value',
        'parent_id'
    ];
    public function parent()
    {
        return $this->belongsTo('App\Model\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Model\Category', 'parent_id');
    }

}
