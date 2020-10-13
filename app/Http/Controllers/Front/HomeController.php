<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Model\Category;
use App\Model\Deal;
use App\Model\VendorDetail;

use App\User;
use App\Model\Product;
use App\Model\Slideshow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
	public function index()
	{
		$slideshows = Slideshow::where('status', '=', 1)->orderBy('id', 'DESC')->take(5)->get();
		$brands = Brand::all();
		return view('front.index', compact('slideshows', 'brands'));
	}

    public function single($id)
    {
    	$products = Product::findOrFail($id);
    	return view('front.single', compact('products'));
    }

    public function sellWithUs(){

        return view('front.sell');
    }

    public function sellonLogin(){
        if(Auth::check()){
            if(Auth::user()->hasRole('vendor')){
                    return redirect('vendors');
            }
        }
        return view('front.vendorlogin');
    }

    public function vendorRegistration()
    {
        if(Auth::check()){
                    Auth::logout();
                }
//        dd('test');
//    	$user_id= auth()->id();
//    	$user = User::find($user_id);
        if (Auth::user()) {
//            if (Auth::user()->verified == 0) {
//                return redirect()->back()->with('error', 'Your Account has not been verified. Please check your email and verified! To resend email, go to your account.');
//            }
            if (Auth::user()->hasrole('vendor')) {
                return redirect()->route('vendor.dashboard');
            }
        }
        $categories = Category::where('parent_id', 0)->get();
        foreach($categories as $key => $category){
            if($category->id == 609 || $category->id == 723){
           unset($categories[$key]);
            }
        }
    	return view('front.vendorregistration', compact('categories'));
    }
    public function completeRegistration()
    {
        // dd('test');
        if (Auth::user()) {
            if(VendorDetail::where('user_id',auth()->id())->first()->verified == 0) {

                    return view('vendor_documents');
                }
            }
            if (Auth::user()->hasrole('vendor')) {

                return view('vendor_documents');
            }
            else{

                return redirect()->route('sell.index')->with('error','Please Fill Up There Forms First');

            }
        }
}
