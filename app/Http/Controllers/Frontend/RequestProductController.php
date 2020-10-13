<?php

namespace App\Http\Controllers\Frontend;

use App\Model\RequestProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class RequestProductController extends Controller
{
	public function getIndex()
	{
		$requests = RequestProduct::all();
		return view('request_table',compact('requests'));
	}

    public function getCreate()
    {
    	return view('request_product');
    }

    public function postStore(Request $request)
    {
    	$this->validate($request,[
    		'name' => 'required',
    		'email' => 'required|email',
    		'phone' => 'required|digits:10',
    		'title' => 'required',
    		'product_specification' => 'required'
    	]);

    	$requests = new RequestProduct;
        $requests->user_id = auth()->id();
    	$requests->name = $request->name;
    	$requests->email = $request->email;
    	$requests->phone = $request->phone;
    	$requests->product_title = $request->title;
    	$requests->product_specification = $request->product_specification;
    	$requests->product_reference = $request->reference;
    	$requests->product_category = $request->category;

    	$requests->save();

    	Session::flash('success',"Thanks for sending request!!!");

    	return redirect()->back();
    }

    public function deleteRequestProduct($id)
    {
   		RequestProduct::where('id',$id)->delete();

   		Session::flash('success',"Your deleted one request successfully!!!");
   		
   		return redirect()->back();
    }
}
