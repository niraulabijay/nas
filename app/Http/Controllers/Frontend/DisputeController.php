<?php

namespace App\Http\Controllers\Frontend;

use App\Model\Dispute;
use App\Model\DisputeMessage;
use App\Model\OrderProduct;
use App\Model\ReturnProductTopic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DisputeController extends Controller
{
    public function index($id)
    {
        $order_product_id = OrderProduct::findorfail($id);
        $dispute = Dispute::where('order_product_id',$order_product_id->id)->first();

        if($dispute)
        {
            if (auth()->id() == $order_product_id->order->user_id) {

                $order_product = $order_product_id;
                return view('front.disputes.index', compact('order_product','dispute'));
            } else {
                return redirect()->back()->with('error', 'Something went wrong');
            }
        }
        else {
            if (auth()->id() == $order_product_id->order->user_id) {
                $topic = ReturnProductTopic::all();
                return view('front.disputes.message', compact('order_product_id', 'topic'));
            } else {
                return redirect()->back()->with('error', 'Something went wrong');
            }
        }
    }

    public function save(Request $request)
    {
        $request->validate([

            'topic_id' => 'required',
            'return_message' => 'required|max:500|min:10'
        ]);
        $dispute = new Dispute();
        $dispute->order_product_id = $request->order_product_id;
        $dispute->topic_id = $request->topic_id;
        $dispute->message = $request->return_message;
        $dispute->save();


        $order_product = OrderProduct::findorfail($request->order_product_id);


        return redirect()->route('user.disputes', $order_product->id);
    }

    public function storeDisputes($id, Request $request)
    {

        $dispute = Dispute::findorfail($id);
        $message = $request->message;

        $dispute1 = DisputeMessage::where('dispute_id',$dispute->id)->get();
        foreach($dispute1 as $row) {
            $row->active = 0;
            $row->update();
        }

        $dispute -> disputeMessages()->create( [
            'message' => $message,
            'user_id' => auth()->id(),
            'active'=>1
        ] );

        return redirect()->back()->with('success','Message Sucessfully Sent');
    }
}
