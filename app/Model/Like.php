<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
   protected  $fillable=[
       'user_id',
       'vote',
       'forum_answer_id'

   ];
   public function user(){
       return $this->belongsTo(User::class);
   }
    public function answer(){
        return $this->belongsTo(ForumAnswer::class);
    }
}


