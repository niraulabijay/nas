<?php

namespace App\Http\Controllers\Vendor;

use App\Model\Chat;
use App\Model\Dispute;
use App\Model\DisputeMessage;
use App\Model\Order;
use App\Model\OrderProduct;
use App\Model\Product;
use App\Repositories\Contracts\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DisputeController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $disputes = Dispute::all();
        foreach ($disputes as $dispute) {
           if($dispute->product->owner_id==auth()->id()){
               $myDisputes[]=$dispute;
           }

        }

        return view('merchant.disputes.index', compact('myDisputes'));
    }

    public function show($id)
    {
        $dispute = Dispute::findOrFail($id);

        if($dispute->product->owner_id==auth()->id()){
        $order_product = $dispute->product;
        return view('merchant.disputes.view', compact('dispute', 'order_product'));}

        else{
            return redirect()->back()->with('error', 'Something went wrong');

        }

    }

    public function storeDisputes($id, Request $request)
    {
        $dispute = Dispute::findorfail($id);

        $dispute1 = DisputeMessage::where('dispute_id',$dispute->id)->get();
        foreach($dispute1 as $row) {
            $row->active = 0;
            $row->update();
        }

        $message = $request->message;

        $dispute -> disputeMessages()->create( [
            'message' => $message,
            'user_id' => auth()->id(),
            'active'  => 1

        ] );

        return redirect()->back();
    }

    public function chat()
    {
        $admin = User::whereHas( 'roles', function ( $q )  {
            $q->where( 'name', 'admin' );
        } )->first();

        $messages = Chat::where('admin_id', $admin->id)->where('vendor_id', auth()->id())->get();

        return view('merchant.disputes.chat', compact('admin', 'messages'));
    }

    public function chatStore(Request $request)
    {
        $request->validate([
            'image' => 'mimes:jpeg,png,gif'
        ]);

        $chat =  new Chat();
        $chat->admin_id = $request->id;
        $chat->vendor_id = auth()->id();
        $chat->message = $request->chat;

        if ($request->file('image')) {
            $chat->image = 'data:image/jpeg/png/gif;base64,' . base64_encode(file_get_contents($request->file('image')));
        }
        $chat->active = 1;
        $chat->save();

        return redirect()->back();
    }
}
