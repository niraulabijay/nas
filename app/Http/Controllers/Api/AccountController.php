<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserInfoRequest;
use App\Http\Requests\UserPasswordRequest;
use App\Http\Resources\Account\OrderCollection;
use App\Http\Resources\Account\OrderResource;
use App\Http\Resources\Account\ShippingAccountCollection;
use App\Http\Resources\Account\ShippingAccountResource;
use App\Http\Resources\Account\WishlistCollection;
use App\Model\Order;
use App\Model\OrderProduct;
use App\Model\Product;
use App\Model\ProductAdditional;
use App\Model\ShippingAccount;
use App\Model\Wishlist;
use App\Repositories\Contracts\OrderRepository;
use App\User;
use App\User_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends Controller
{
    private $order;

    public function __construct( OrderRepository $order ) 
    {
        $this->order = $order;
    }

    public function index()
    {
    	$shippingAddress = ShippingAccount::where( 'user_id', auth()->id() )->get();

    	return new ShippingAccountCollection($shippingAddress);
    }

    public function defaultAddress()
    {
        $shippingAddress = ShippingAccount::where( 'user_id', auth()->id() )->where('is_default', 1)->first();

        if (empty($shippingAddress) || $shippingAddress == null) {
            return response()->json(['msg' => 'No Default address has been set.'], Response::HTTP_NOT_FOUND);
        }

        return new ShippingAccountResource($shippingAddress);
    }

    public function getOrders()
    {
		$user   = auth()->id();
		$orders = Order::where('user_id', '=', $user)->orderBy('id','DESC')->paginate(10);

		return OrderCollection::collection($orders);
	}

	public function cancelOrder( $id )
    {
		$order = $this->order->getById( $id );

        if($order->order_status_id != 1 && $order->order_status_id != 5)
        {
            $pid = DB::table('order_product')->where('order_id',$id)->get();
            foreach($pid as $pid){
                $product = Product::where('id',$pid->product_id)->first();
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

        return response()->json( ['msg' => 'Order successfully cancelled!'], Response::HTTP_OK );
	}

	public function viewOrder( $id )
    {
		$order = $this->order->getById( $id );

		return new OrderResource($order);
	}

	public function postShippingStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|max:255|email',
            'area' => 'required|max:255',
            'district' => 'required|max:255',
            'zone' => 'required|max:255',
            'mobile' => 'required|min:9|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], Response::HTTP_NOT_ACCEPTABLE);
        }

        $shipping = new ShippingAccount();
        $shipping->user_id = auth()->id();
        $shipping->first_name = $request->first_name;
        $shipping->last_name = $request->last_name;
        $shipping->email = $request->email;
        $shipping->country = $request->country;
        $shipping->area = $request->area;
        $shipping->district = $request->district;
        $shipping->location_type = $request->location_type;
        $shipping->mobile = $request->mobile;
        $shipping->zone = $request->zone;
        $shipping->save();
        
        return response()->json(['msg' => 'Address successfully added!'], Response::HTTP_CREATED);
    }

	public function updateShippingAddress( $id, Request $request ) 
	{
		$validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|max:255|email',
            'area' => 'required|max:255',
            'district' => 'required|max:255',
            'zone' => 'required|max:255',
            'mobile' => 'required|min:9|max:15',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], Response::HTTP_NOT_ACCEPTABLE);
        }

        $shipping = ShippingAccount::findOrFail($id);
        $shipping->user_id = auth()->id();
        $shipping->first_name = $request->first_name;
        $shipping->last_name = $request->last_name;
        $shipping->email = $request->email;
        $shipping->country = $request->country;
        $shipping->area = $request->area;
        $shipping->district = $request->district;
        $shipping->location_type = $request->location_type;
        $shipping->mobile = $request->mobile;
        $shipping->zone = $request->zone;
        $shipping->update();

		return response()->json( ['msg' => 'Address successfully updated!'], Response::HTTP_CREATED );
	}

	public function postShippingDelete($id)
	{
        $shipping = ShippingAccount::find($id);
        if (Order::where('address_id', $shipping->id)->exists()) {
            return response()->json(['error' => 'Your Address is being used in your order!'], Response::HTTP_METHOD_NOT_ALLOWED);
        }

        $shipping->delete();
        
        return response()->json(['msg' => 'Your Address is successfully deleted!'], Response::HTTP_OK);
    }

	public function updateAccount( Request $request ) 
	{
		$validator = Validator::make($request->all(), [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'phone' => 'required',
            'user_name' => 'required|string|max:50|unique:users,user_name,' . auth()->id(),
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], Response::HTTP_NOT_ACCEPTABLE);
        }

		$user = User::findOrFail(auth()->id());
        
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->update();

		return response()->json( ['msg' => 'Account successfully updated!'], Response::HTTP_CREATED );
	}

	public function postInfoStore(UserInfoRequest $request)
    {
        if($request->hasFile('user_image')){
            if (isset(User_info::where('user_id', auth()->id())->first()->image)) {
                $existFile = User_info::where('user_id', auth()->id())->first()->image;
                Storage::disk('public')->delete($existFile);
            }
            $image = $request->file('user_image');
            $filename = time() . $image->getClientOriginalName();
            Storage::disk('public')->putFileAs('storage/user_avatar', $image, $filename);
            $request->request->add(['image' => 'user_avatar' . '/' . $filename]);
        }

        $request->request->add(['user_id' => auth()->id()]);

        $user_info = User_info::updateOrCreate(['user_id'=>auth()->id()],$request->all());

        return response()->json(['msg' => 'Your Personal Information updated!'], Response::HTTP_CREATED);
    }

	public function updatePassword( UserPasswordRequest $request ) 
	{
		$user = Auth::user();

		if ( Hash::check( $request->input( 'current_password' ), $user->password ) ) {
			$user->update( [ 'password' => bcrypt( $request->input( 'password' ) ) ] );

			return response()->json( ['msg' => 'Password successfully changed!'], Response::HTTP_CREATED );
		} else {
			return response()->json( [ 'msg' => 'Your current password is wrong!' ], Response::HTTP_NOT_ACCEPTABLE );
		}
	}

	public function userImage()
	{
		$user = User_info::where('user_id', auth()->id())->first();
		$image = isset($user) && $user->image != null ? url('storage') . '/' . $user->image : asset('/front/img/default-user.png');
		$data = [
			'image' => $image,
			'id' => auth()->id(),
			'first_name' => Auth::user()->first_name,
            'last_name' => Auth::user()->last_name,
			'user_name' => Auth::user()->user_name,
			'email' => Auth::user()->email,
			'phone' => Auth::user()->phone,
            'gender' => isset($user) ? $user->gender : '',
            'dob' => isset($user) ? $user->dob : ''
		];
		return response()->json($data, Response::HTTP_OK);
	}

	public function storeImage(Request $request)
	{
		if($request->hasFile('user_image')){
            if (isset(User_info::where('user_id', auth()->id())->first()->image)) {
                $existFile = User_info::where('user_id', auth()->id())->first()->image;
                Storage::disk('public')->delete($existFile);
            }
            $image = $request->file('user_image');
            $filename = time() . $image->getClientOriginalName();
            Storage::disk('public')->putFileAs('storage/user_avatar', $image, $filename);
            $request->request->add(['image' => 'user_avatar' . '/' . $filename]);
        }
        User_info::updateOrCreate(['user_id'=>auth()->id()],$request->all());

		return response()->json( ['msg' => 'User Image successfully updated!'], Response::HTTP_CREATED );
	}

	public function getWishlist()
	{
		$wishlists = Wishlist::where( [
			'user_id' => auth()->id()
		] )->get();

		return WishlistCollection::collection($wishlists);
	}

    public function storeWishlist( Request $request ) 
    {
    	$validator = Validator::make($request->all(), [
    		'product' => 'required|numeric'
    	]);
    	
    	if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], Response::HTTP_NOT_ACCEPTABLE);
        }

		if ( auth()->guest() ) {
			return response()->json( [
				'status'  => 'error',
				'message' => 'Please login to add this product in your wishlist!!'
			], 401 );
		}

		$productId = $request->input('product');

		$wishlist = new Wishlist();

		if ( $wishlist->isInWishlist( $productId ) ) {
			return response()->json( [
				'status'  => 'success',
				'message' => 'Product added into your wishlist!!'
			], 200 );
		}

		$product = Product::findOrFail( $productId );

		$wishlist->create( [
			'user_id'    => auth()->id(),
			'product_id' => $product->id,
		] );

		return response()->json( [
			'status'  => 'success',
			'message' => 'Product added into your wishlist!!'
		], Response::HTTP_CREATED );

	}

	public function destroyWishlist( $productId ) {
		$product = Product::findOrFail( $productId );

		Wishlist::where( [
			'user_id'    => auth()->id(),
			'product_id' => $product->id,
		] )->delete();

		return response()->json( [
			'status'  => 'success',
			'message' => 'Product removed into your wishlist!!'
		], Response::HTTP_OK );
	}

	public function useAddress(Request $request)
    {
        $add = ShippingAccount::where('is_default', 1)->where('user_id', auth()->id())->first();
        if(!empty($add) && $add->id == $request->id)
        {
            $add->is_default = 0;
            $add->update();
            return response()->json(['msg' => 'Default address removed!'], Response::HTTP_OK);
        }
        if(!empty($add))
        {
            $add->is_default = 0;
            $add->update();
        }
        $used = ShippingAccount::findOrFail($request->id);
        $used->is_default = 1;
        $used->update();
        
        return response()->json(['msg' => 'Default address changed!'], Response::HTTP_OK);
    }

    public function scanBarcode($order)
    {
    	$order = Order::where('barcode', $order)->first();

    	if(Auth::user()->hasRole('admin'))
    	{
    		$order->order_status_id = 7;
    		$order->update();

    		return response()->json(['msg' => 'Order status changed successfully!'], Response::HTTP_OK);
    	}

    	if($order->user_id == auth()->id())
    	{
	    	$order->order_status_id = 8;
			$order->update();
		}
		else 
		{
			return response()->json(['error' => 'This is not your order!'], Response::HTTP_UNAUTHORIZED);
		}

		return response()->json(['msg' => 'Order status changed successfully!'], Response::HTTP_OK);
    }

    public function scanOrderNumber($number)
    {
    	$order = Order::where('code', $number)->first();

    	if (isset($order) && $order->user_id == auth()->id()) {
    		return response()->json(['id' => $order->id], Response::HTTP_OK);
    	}
    	else {
    		return response()->json(['error' => 'This is not your order!'], Response::HTTP_UNAUTHORIZED);
    	}
    }
}
