<?php

namespace App\Http\Controllers\Backend;

use App\Model\ReferalTransaction;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReferalController extends Controller
{
    public function index()
    {
        return view('admin.referals.index');
    }

    public function destroy($id)
    {
        $referal = ReferalTransaction::findOrFail($id);
        $referal->delete();
        return response()->json('Referral successfully deleted.');
    }

    public function getReferalJson()
    {
        $referals = ReferalTransaction::all();
        foreach ($referals as $referal)
        {
            $referal->sender_id = User::where('id', $referal->sender_id)->first()->user_name;
            $referal->receiver_id = User::where('id', $referal->receiver_id)->first()->user_name;
        }
        return datatables($referals)->toJson();
    }
}
