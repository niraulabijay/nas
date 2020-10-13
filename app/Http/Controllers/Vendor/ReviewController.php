<?php

namespace App\Http\Controllers\Vendor;

use App\Model\Product;
use App\Model\ReviewProduct;
use App\User;
use App\VendorRating;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function index() {


        return view( 'merchant.reviews.index' );
    }


    public function getReviewJson()
    {
        $reviews = ReviewProduct::where('owner_id',auth()->id());
        foreach ($reviews as $review) {
            $review->product_name= Product::where('id', $review->product_id)->first()->name;
            $review->user_name= User::where('id', $review->user_id)->first()->user_name;
        }
        return datatables( $reviews )->toJson();
    }
 public function vendorRating() {


        return view( 'merchant.reviews.vendor' );
    }


    public function getVendorReviewJson()
    {
        $reviews = VendorRating::where('vendor_id',auth()->id())->get();
        foreach ($reviews as $review) {
         
            $review->user_name= User::where('id', $review->user_id)->first()->user_name;
        }
        return datatables( $reviews )->toJson();
    }

    public function updateStatus( Request $request, $id ) {
//        dd($request);

        $r=ReviewProduct::findorfail($id);
        $r->status=$request->status==1?0:1;
        $r->update();

        return response()->json( [
            'success' => true,
            'message' => 'Review status successfully updated!!'
        ] );
    }


}
