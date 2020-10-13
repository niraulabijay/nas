<?php

namespace App\Http\Controllers\Backend;

use App\Model\VendorDetail;
use App\User;
use App\VendorRating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VendorReviewController extends Controller
{
    public function index() {


        return view( 'admin.reviews.vendor' );
    }


    public function getReviewJson()
    {
        $reviews = VendorRating::all();
        foreach ($reviews as $review) {
            $review->vendor_name= VendorDetail::where('user_id',$review->vendor_id)->first()?VendorDetail::where('user_id',$review->vendor_id)->first()->name:'NA';
            $review->user_name= User::where('id', $review->user_id)->first()->user_name;
        }
        return datatables( $reviews )->toJson();
    }


    public function updateStatus( Request $request, $id ) {
//        dd($request);

        $r=VendorRating::findorfail($id);
        $r->status=$request->status==1?0:1;
        $r->update();

        return response()->json( [
            'success' => true,
            'message' => 'Review status successfully updated!!'
        ] );
    }

    public function destroy( $id ) {
        VendorRating::findorfail($id)->delete();
        return redirect()->back()->with( 'success', 'Review successfully deleted!!' );

    }
}
