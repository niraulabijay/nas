<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Model\WithDraw;
use App\Model\WithdrawStatus;
use Illuminate\Http\Request;

class WithDrawController extends Controller
{
    public function getIndex()
    {
    	$withdraws = WithDraw::all();
    	return view('admin.withdraw.index',compact('withdraws'));
    }

    public function getEdit($id)
    {
        $withDrawStatus = WithdrawStatus::all();
    	$details = WithDraw::findOrFail($id);
    	return view('admin.withdraw.edit',compact('details','withDrawStatus'));
    }

    public function getWithdrawCancel($id){
        $withdraw = WithDraw::findOrFail($id);

        $withdraw->delete();

        return redirect()->back()->with('success',"Withdraw is Deleted!!!");
    }
    public function getChangeStatus(Request $request,$id)
    {
        $this->validate($request,[
            'status' => 'required|digits:1|between:1,5'
        ]);

        $withdraw = WithDraw::findOrFail($id);

        $withdraw->status = $request->status;
        $withdraw->update();

        return redirect()->back()->with('success',"Status is updated!!!");
    }



    public function verifyUpdate($id)
    {

        $verify = WithDraw::where('id', $id)->first();
//        dd($verify);
        if ($verify->approve == 0)
        {
            $verify->approve = 1;
        }else
        {
            $verify->approve = 0;
        }
        $verify->update();

        return redirect()->back();
    }
}
