<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ForumAnswerRepository;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    private $forumAnswerRepository;
    public function __construct(ForumAnswerRepository $forumAnswerRepository){
        $this->forumAnswerRepository=$forumAnswerRepository;
    }
    public function answerStore($id, Request $request)
    {
        $user=auth()->id();
        $request['user_id']=$user;
        $request['forum_id']=$id;

        $request['type']='FORUM';
        $this->forumAnswerRepository->create($request->all());
return redirect()->back();
    }
}
