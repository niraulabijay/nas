<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewProductRequest;
use App\Model\Product;
use App\VendorRating;

use App\Model\ReviewProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReviewProductController extends Controller
{
    public function postReview(ReviewProductRequest $request)    {

    	$request->request->add(['user_id' => auth()->id()]);
        $request->request->add(['owner_id' => Product::where('id',$request->product_id)->first()->user_id]);

        $review = ReviewProduct::updateOrCreate(['user_id' => auth()->id(),'product_id' => $request->product_id],$request->all());

    	Session::flash('success',"Thank you for rating this product!");

        return redirect()->back();
    }
     public function vendorReview(Request $request){
         $request->request->add(['user_id' => auth()->id()]);
        $request->request->add(['vendor_id' => Product::where('id',$request->product_id)->first()->user_id]);

        $review = VendorRating::updateOrCreate(['user_id' => auth()->id(),'vendor_id' => $request->product_id],$request->all());

        Session::flash('success',"Thank you for rating!");

        return redirect()->back();
    }
}
