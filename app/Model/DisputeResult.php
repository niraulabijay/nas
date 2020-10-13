<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DisputeResult extends Model
{
    protected $fillable = [
        'dispute_id',
        'result',
        'user_id'
    ];

    public function disputes()
    {
        return $this->belongsTo(Dispute::class);
    }
}
