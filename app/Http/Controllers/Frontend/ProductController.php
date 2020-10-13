<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\NotifyInstock;
use App\Model\Product;
use App\Model\ProductRelation;
use App\Model\Referral;
use App\Model\VendorDetail;
use App\Model\Wallet;
use App\Model\Wishlist;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function getProduct($slug){

        $product    = Product::where('slug',$slug)->where('status', '=','published')->where('approved','1')->first();
       
        if(isset($product)){
            $colours    = $product->additionals->pluck('color')->toArray();
            $sizes  = $product->additionals->pluck('size')->toArray();
            $shop= VendorDetail::where('user_id', $product->user_id)->first();
            // dd($shop);
            $shop_name = $shop ? $shop->name: 'Nepal All Shop';
            $shop_slug = $shop ? strtolower($shop->vendor_code): 'nepalallshop';
            $user = auth()->id();
            $wishlist = Wishlist::where('user_id', $user)->where('product_id', $product->id)->first();

            $categories = $product->categories()->get()->pluck( 'id' )->toArray();
            $relatedProducts = Product::whereHas( 'categories', function ( $query ) use ( $categories ) {
                $query->whereIn( 'categories.id', $categories );
            } )->whereNotIn( 'name', [ $product->name ] )->where('status','published')->take( 15 )->get();

            $product->view= $product->view+1;
            $product->update();

            $relation = $product->relation ? $product->relation->product_id : $product->id;
            $relation_ids = ProductRelation::where('product_id', $relation)->pluck('relation_id')->toArray();
            $products = Product::whereIn('id', $relation_ids)->where('status','published')->get();
            
            
        session()->push('recently_viewed', $product->id);

            $recentlyViewedProduct = array_unique(session()->get('recently_viewed'));
          
foreach($recentlyViewedProduct as $p){
   
    $recentlyViewedProducts[]=Product::where('id',$p)->first();
    $lastestProducts = Product::where('status', '=','published')->where('approved','1')->take(10)->get();
}
            return view('front.single_page',compact('product','sizes','colours','shop_name','wishlist','relatedProducts','recentlyViewedProducts', 'products', 'shop_slug', 'lastestProducts'));

        }
        else{
            abort(404,'Product Not Found');
        }
    }

    public function storeNotifyInstockEmail(Request $request)
    {
        $request->validate(['email' => 'required|string|email|max:255']);

        $product = NotifyInstock::where('product_id', $request->product_id)->where('email', $request->email)->first();
        if(isset($product) && !empty($product))
        {
            return redirect()->back()->with('success', 'Your email is already saved.');
        }

        $notify = new NotifyInstock();
        $notify->product_id = $request->product_id;
        $notify->email = $request->email;
        $notify->save();

        return redirect()->back()->with('success', 'Email successfully saved.');
    }

    public function countReferral($slug,$token){
        $product = Product::where('slug',$slug)->first();
        $user=User::where('token',$token)->first();
        if(empty($product) || empty($user)){
            return redirect('/');
        }

        $referral=Referral::where('user_id',$user->id)->where('product_id',$product->id)->first();
        if($referral){
            $referral->visit_with_referral= $referral->visit_with_referral+1;
            $referral->update();
        }
        else{
            $new_refer= new Referral();
            $new_refer->user_id= $user->id;
            $new_refer->product_id= $product->id;
            $new_refer->visit_with_referral= 1;
            $new_refer->save();
        }

        $colours    = $product->additionals->pluck('color')->toArray();
        $sizes      = $product->additionals->pluck('size')->toArray();
        $shop       = VendorDetail::where('user_id', $product->user_id)->first();
        $shop_name  = $shop?$shop->name:'NA';
        $wishlist   = Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->first();

        return view('front.single_page',compact('product','sizes','colours','shop_name','wishlist'));
    }

     /*public function getPayperClickProduct($slug,$token){
        $product    = Product::where('slug',$slug)->first();
        $user=User::where('token',$token)->first();
        $provider_user = Wallet::where('user_id',$user->id)->first();
        if($provider_user){
            $provider_user->amount = $provider_user->amount + 1;
            $provider_user->update();
        }else{
            $new_user= new Wallet();
            $new_user->user_id=$user->id;
            $new_user->amount=1;
            $new_user->save();
        }
        $colours    = $product->additionals->pluck('color')->toArray();
        $sizes  = $product->additionals->pluck('size')->toArray();
        $shop= VendorDetail::where('user_id', $product->user_id)->first();
        $shop_name = $shop?$shop->name:'NA';
        

        return view('front.single_page',compact('product','sizes','colours','shop_name'));
    }*/
}