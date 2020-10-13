<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $fillable=[
      'user_id',
        'question',
        'type',
        'status'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function answers(){
        return $this->hasMany(ForumAnswer::class);
    }
}
