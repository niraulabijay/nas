<?php

namespace App\Http\Controllers\Frontend;

use App\Model\OrderProduct;
use App\Model\OrderReturnRequest;
use App\Model\OrderReturnRequestMessage;
use App\Model\OrderReturnStatus;
use App\Model\ReturnProductTopic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index($id)
    {
        $order_product_id = OrderProduct::findorfail($id);
        $order_return_message = OrderReturnRequestMessage::where('id', $order_product_id->id)->first();
        if ($order_return_message)  {

        }
        else{
            if (auth()->id() == $order_product_id->order->user_id) {
                $topic = ReturnProductTopic::all();
                return view('front.my_account.order_return_message', compact('order_product_id', 'topic'));
            } else {
                return redirect()->back()->with('error', 'Something went wrong');
            }
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'topic_id' => 'required',
            'user_option' => 'required',
            'qty' => 'required',
            'return_message' => 'required|max:500|min:10'
        ]);

        try
        {
            $order_return = new OrderReturnRequest();
            $order_return->user_id = auth()->id();
            $order_return->user_option = $request->user_option;

            $orderReturnStatus = OrderReturnStatus::whereIsDefault(1)->get()->first();
            $order_return->status_id = $orderReturnStatus->id;

            $order_return->save();

            $order_return->orderReturnProducts()->create([
                'order_product_id' => $request->order_product_id,
                'qty' => $request->qty,
            ]);

            $order_return->orderReturnMessage()->create([
                'topic_id' => $request->topic_id,
                'message_text' => $request->return_message
            ]);
        }
        catch (\Exception $e)
        {
            throw new \Exception('Error in saving returns:' . $e->getMessage());
        }

        return redirect()->route('user.account')
            ->with('success', 'Return Request Successfully Sent');
    }
}
