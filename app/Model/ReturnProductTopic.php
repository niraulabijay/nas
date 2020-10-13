<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ReturnProductTopic extends Model
{
    protected $fillable = [
        'topic'
    ];

    public function returnproducts() {
        return $this->belongsTo(ReturnProduct::class);
    }
}
