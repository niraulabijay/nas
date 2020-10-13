<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ForumAnswer extends Model
{
    protected $fillable=[
        'user_id',
        'answer',
        'type',
        'forum_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function forums(){
        return $this->belongsTo(Forum::class);
    }
    public function likes(){
        return $this->hasMany(Like::class);
    }
}
