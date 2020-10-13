<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DealProduct extends Model
{
    protected $table = 'deal_product';

    public function deals()
    {
        return $this->belongsToMany(Deal::class);
    }
}
