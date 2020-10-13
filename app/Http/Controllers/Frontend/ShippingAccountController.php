<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingAccountRequest;
use App\Http\Requests\UserInfoRequest;
use App\Http\Requests\UserPasswordRequest;
use App\Model\MainShipping;
use App\Model\Negotaible;
use App\Model\Order;
use App\Model\OrderProduct;
use App\Model\OrderReturnRequest;
use App\Model\Product;
use App\Model\ProductAdditional;
use App\Model\Referral;
use App\Model\ShippingAccount;
use App\Model\Wishlist;
use App\Repositories\Contracts\OrderRepository;
use App\User;
use App\User_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ShippingAccountController extends Controller
{
    private $order;

    public function __construct( OrderRepository $order ) {
        $this->order = $order;
    }

    public function getIndex()
    {
        $user   = auth()->id();
        $verified = User::find($user)->verified;
        $orders =  Order::where('user_id', '=', $user)->orderBy('id','DESC')->take(15)->get();
        $prebookingOrders = Order::whereHas('prebookings', function($query) {
            $query->where('status', 0);
        })->where('user_id', $user)->get();
        $user_info = User_info::where('user_id',auth()->id())->first();
        $shipping = ShippingAccount::where('user_id',auth()->id())->take(15)->get();
        $order_returns = OrderReturnRequest::where('user_id', auth()->id())->get();
        $nego_topic = Negotaible::where('user_id', $user)->take(15)->get();
        $wishlists = Wishlist::where('user_id', $user)->take(15)->get();
        $used_add = ShippingAccount::where('is_default', 1)->where('user_id', auth()->id())->first();
        $referrals= Referral::where('user_id',auth()->id())->get();
    	return view('front.my_account.index',compact('user_info', 'shipping','orders', 'order_returns','nego_topic','wishlists', 'used_add','verified','referrals', 'prebookingOrders'));
    }

    public function postShippingStore(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|max:255|email',
            'area' => 'required|max:255',
            'district' => 'required|max:255',
            'zone' => 'required|max:255',
            'mobile' => 'required|min:9|max:15',
        ]);

        $shipping = new ShippingAccount();
        $shipping->user_id = auth()->id();
        $shipping->first_name = $request->first_name;
        $shipping->last_name = $request->last_name;
        $shipping->email = $request->email;
        $shipping->country = $request->country;
        $shipping->zone = $request->zone;
        $shipping->area = $request->area;
        $shipping->district = $request->district;
        $shipping->location_type = $request->location_type;
        $shipping->mobile = $request->mobile;
        $shipping->phone = $request->phone;
        $shipping->save();
        
        Session::flash('success',"New Address is successfully Saved!");

        return redirect()->back();
    }
    
    public function postShippingEdit($id){
        
        $shipping = ShippingAccount::find($id);
        return view('front.my_account.edit_shipping_account',compact('shipping'));
        
        
    }
    
    public function updateShipping($id, Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|max:255|email',
            'area' => 'required|max:255',
            'district' => 'required|max:255',
            'zone' => 'required|max:255',
            'mobile' => 'required|min:9|max:15',
        ]);

        $shipping = ShippingAccount::findOrFail($id);
        $shipping->user_id = auth()->id();
        $shipping->first_name = $request->first_name;
        $shipping->last_name = $request->last_name;
        $shipping->email = $request->email;
        $shipping->country = $request->country;
        $shipping->zone = $request->zone;
        $shipping->area = $request->area;
        $shipping->district = $request->district;
        $shipping->location_type = $request->location_type;
        $shipping->mobile = $request->mobile;
        $shipping->phone = $request->phone;
        $shipping->update();
        
        Session::flash('success',"Your Address is successfullyuUpdated!");

        return redirect()->route('user.account');
    }
    
    public function postShippingDelete($id){
        
        $shipping = ShippingAccount::find($id);
        if (Order::whereColumn('address_id', $shipping->id)->exists()) {
            return redirect()->back()->with('error', 'Your Address is being used in your order!');
        }

        $shipping->delete();
        
        Session::flash('success',"Your Address is successfully deleted!");

        return redirect()->back();
    }

    public function postInfoStore(UserInfoRequest $request)
    {
        if($request->hasFile('user_image')){
            if (isset(User_info::where('user_id', auth()->id())->first()->image)) {
                $existFile = User_info::where('user_id', auth()->id())->first()->image;
// dd($existFile);
           File::delete($existFile);
            $images= $request->file('user_image');
             $name = Storage::disk('public')->putFile('user_avatar', $images);
            $filename= basename($name);

            $request->request->add(['image' => 'user_avatar' . '/' . $filename]);
        }

        $request->request->add(['user_id' => auth()->id()]);

        $user_info = User_info::updateOrCreate(['user_id'=>auth()->id()],$request->all());

        Session::flash('success','Personal Info Updated!');

        return redirect()->back();
    }
    }

    public function postUserStore(UserPasswordRequest $request)
    {
        $user = Auth::User();
        if ( Hash::check( $request->input( 'current_password' ), $user->password ) ) {
            $user->update( [ 'password' => bcrypt( $request->input( 'password' )) ] );

            return redirect()->back()->with('success', 'Password Changed Successfully!' );
        } else {
            return redirect()->back()->with('error','Your current password is wrong!' );
        }
    }

    public function cancelOrder( $id ) {
        $order = $this->order->find( $id );

        if($order->order_status_id != 1 && $order->order_status_id != 5)
        {
            $pid=DB::table('order_product')->where('order_id',$id)->get();
            foreach($pid as $pid){
                $product=Product::where('id',$pid->product_id)->first();
                $product->stock_quantity = (int)( $product->stock_quantity) + (int)($pid->qty);
                $product->update();
                if(isset($product->additionals) && $product->additionals->isNotEmpty())
                {
                    $size = OrderProduct::where('order_id', $order->id)->where('product_id', $product->id)->first()->size;
                    $additional = ProductAdditional::where('product_id', $pid)->where('size', $size)->first();
                    $additional->quantity = (int)($additional->quantity) + (int)($qty);
                    $additional->update();
                }
            }
        }

        $order->update( [ 'order_status_id' => 5 ] );

        return redirect()->back()->with( 'success', 'Your Order has been Cancelled!' );
    }

    public function viewOrderDetails($id)
    {
        $order = Order::findOrFail($id);
        return view('front.my_account.order_details', compact('order'));
    }

    public function myWishlist(){
        return view('front.cart.wishlist');
    }
    
    public  function wishlist($product_id){

        $wishlist = Wishlist::where('product_id',$product_id)->where('user_id',auth()->id())->first();
        if($wishlist){
            return redirect()->back()->with('error', 'Item already in Wishlist');

        }
        $new= new Wishlist();
        $new->product_id = $product_id;
        $new->user_id= auth()->id();
        $new->save();

        return redirect()->route('user.account')->with('success', 'Wishlist has been Updated');

    }

    public function wishlistDestory($id){

        $wishlist = Wishlist::find($id);
        if($wishlist->delete()){
            return redirect()->back()->with('success', 'Wishlist has been Deleted');
        }
        return redirect()->back()->with('error', 'Error occured while Deleting');
    }
    
    public function accountInfoStore(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'user_name' => 'required|string|max:50|unique:users,user_name,' . auth()->id(),
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
        ]);
            
        $user = User::findOrFail(auth()->id());
        
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->update();
        
        return redirect()->back()->with('success', 'Account Info Successfully Updated');
    }
    
    public function useAddress(Request $request)
    {
        $add = ShippingAccount::where('is_default', 1)->where('user_id', auth()->id())->first();
        if(!empty($add) && $add->id == $request->id)
        {
            $add->is_default = 0;
            $add->update();
            return $request->id;
        }
        if(!empty($add))
        {
            $add->is_default = 0;
            $add->update();
        }
        $used = ShippingAccount::findOrFail($request->id);
        $used->is_default = 1;
        $used->update();
        
        return $request->id;
    }
    
}
