<?php

namespace App\Http\Controllers\Backend;

use App\Model\Dispute;
use App\Model\DisputeMessage;
use App\Model\DisputeResult;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DisputeController extends Controller
{
    public function index()
    {
        $dispute_list = Dispute::all();
        foreach ($dispute_list as $dispute)
        {
            $disputes[] = $dispute->product;
        }
        return view('admin.disputes.index', compact('disputes', 'dispute_list'));
    }

    public function statusUpdate($id)
    {
        $dispute = Dispute::where('order_product_id', $id)->first();
        if (!$dispute->status)
        {
            $dispute->status = 1;
        }
        if ($dispute->status == 0)
        {
            $dispute->status = 0;
        }
        $dispute->update();

        return redirect()->back();
    }

    public function viewDetails($id)
    {
        $dispute = Dispute::findOrFail($id);
        $order_product = $dispute->product;
        return view('admin.disputes.view', compact('dispute', 'order_product'));
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

    public function resultStore(Request $request)
    {
        $result = new DisputeResult();
        $result->dispute_id = $request->dispute_id;
        $result->result = $request->dispute_result;
        $result->user_id = $request->favour;
        $result->save();

        $status = Dispute::findOrFail($request->dispute_id);
        $status->status = 0;
        $status->update();

        return redirect()->route('admin.disputes')->with('success', 'Decision has been made.');
    }

    public function reload(Request $request)
    {
       $dispute = DisputeMessage::where('dispute_id',$request->id)->where('active',1)->first();
//        foreach($dispute as $row) {
//            $row->active = 0;
//            $row->save();
//        }
        if(Auth::user()->hasRole(['admin','vendor']))
        {
            return view('admin.disputes.reload', compact('dispute'));
        }
        else
        {
            return view('front.disputes.reload', compact('dispute'));
        }
    }
}
