<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DisputeMessage extends Model
{
    protected $fillable = [
        'dispute_id',
        'message',
        'user_id',
        'active'
    ];

    protected $table = 'dispute_messages';

    public function disputes()
    {
        return $this->belongsTo(Dispute::class);
    }
}
