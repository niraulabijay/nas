<?php

namespace App\Http\Controllers\Backend;

use App\Forum;
use App\Http\Controllers\Controller;
use App\Like;
use App\Repositories\Contracts\ForumRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Forumcontroller extends Controller
{
    private $forumRepository;
    public function __construct(ForumRepository $forumRepository){
        $this->forumRepository=$forumRepository;
    }
    public function index(){
        return view('forum.question');

    }
    public function create(Request $request){
//        dd($request);
        $user=auth()->id();
        $request['user_id']=$user;
        $request['type']='FORUM';
        $this->forumRepository->create($request->all());
    }
    public function getForum($id)
    {
        $forum=Forum::where('id',$id)->first();
        return view('forum.index',compact('forum'));

    }
    public function like($id,$value){

if (Auth::user()->likes()->where('forum_answer_id',$id)->count() == 0) {
    $like = new Like();
    $like->user_id = auth()->id();
    $like->forum_answer_id = $id;
    if ($value == 'dislike') {
        $like->vote = '0';
    } elseif ($value == 'like') {
        $like->vote = '1';
    }


    $like->save();

}



    return redirect()->back();


    }

}
