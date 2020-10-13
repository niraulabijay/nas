<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Model\Chat;
use App\Model\Commission;
use App\Model\Product;
use App\Model\ReviewProduct;
use App\Model\Order;
use App\Model\OrderProduct;
use App\Model\WithDraw;
use App\Model\OrderReturnRequest;
use App\Model\Role;
use App\Model\VendorDetails;
use App\Model\DeliveryDestination;
use App\Repositories\Contracts\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
    	$this->userRepository = $userRepository;
    }

    public function index()
    {
    	// $id = Auth::user()->id;
    	// $vendor_details = VendorDetails::where('user_id',$id)->get();
    	return view('vendors.index');
    }

    public function vendorDetails()
    {
    	return view('vendors.index');
    }

//    public function storeVendorDetails(UserRequest $request)
//    {
//	   	$this->userRepository->vendorDetailsStore($request->all());
//	   	return redirect()->back();
//    }

    public function getVendorDetails()
    {
    	// $id = Auth::user()->id;
    	$vendor_details = VendorDetails::all();
    	return datatables($vendor_details)->toJson();
    }

    public function delete($id)
    {
    	$delete = VendorDetails::findOrFail($id);
    	$delete->delete();
    }

    public function editVendorDetails($id)
    {
        $vendor_details = VendorDetails::where('id',$id)->first();
        return view('vendors.edit_vendor_details', compact('vendor_details'));
    }

    public function updateVendorDetails(UserRequest $request)
    {
		$vendorDetails=VendorDetails::findOrFail($request->id);
		$vendorDetails->update($request->all());
    }

    public function viewVendorDetails($id)
    {
    	$vendor_details = VendorDetails::where('id', $id)->first();
    	$user_id = $vendor_details->user_id;
    	$vendor_info = User::where('id', $user_id)->get();
    	return view('vendors.view_vendor_details', compact('vendor_details', 'vendor_info'));
    }

    public function getVendors()
    {
        return view('admin.vendors.index');
    }

    public function getVendorsJson()
    {
        $vendors = $this->userRepository->getByRole( 'vendor' );
        foreach ( $vendors as $vendor ) {
            $vendor->name = $vendor->full_name;
            $vendor->avatar = null !== $vendor->getImage() ? $vendor->getImage()->smallUrl : $vendor->getDefaultImage()->smallUrl;
            $vendor->role = optional( $vendor->roles->first() )->display_name;
            $vendor->shopname = $vendor->vendorDetails['name'];
            $vendor->address = $vendor->vendorDetails['address'];
            $vendor->totalProduct =  Product::where('user_id', $vendor->id)->where('approved', 1)->where('status', '!=', 'deleted')->count();
        }
        return datatables($vendors)->toJson();
    }

    public function getVendorStats($id)
    {
        $vendor = User::findOrFail($id);
        $products = Product::where('user_id', $vendor->id)->where('status', '!=', 'deleted')->count();
        $approved = Product::where('user_id', $vendor->id)->where('approved', 1)->where('status', '!=', 'deleted')->count();
        $pending = Product::where('user_id', $vendor->id)->where('approved', 0)->where('status', '!=', 'deleted')->count();
        $reviews = ReviewProduct::whereHas('products', function ($query) use ($vendor) {
            $query->where('user_id', $vendor->id)->where('status', '!=', 'deleted');
        })->count();
        $orders = Order::whereHas('orderProduct',function ($query) use ($vendor) {
            $query->where('owner_id', $vendor->id);
        })->count();
        $ordersPending = Order::whereHas('orderProduct',function ($query) use ($vendor) {
            $query->where('owner_id', $vendor->id)
            ->where('status', 1);
        })->count();
        $ordersApproved = Order::whereHas('orderProduct',function ($query) use ($vendor) {
            $query->where('owner_id', $vendor->id)
                ->where('status', 2);
        })->count();
        $ordersReceived = Order::whereHas('orderProduct',function ($query) use ($vendor) {
            $query->where('owner_id', $vendor->id)
                ->where('status', 3);
        })->count();
        $ordersDelivered = Order::whereHas('orderProduct',function ($query) use ($vendor) {
            $query->where('owner_id', $vendor->id)
                ->where('status', 4);
        })->count();
        $ordersCancelled = Order::whereHas('orderProduct',function ($query) use ($vendor) {
            $query->where('owner_id', $vendor->id)
                ->where('status', 5);
        })->count();
        $ordersReview = Order::whereHas('orderProduct',function ($query) use ($vendor) {
            $query->where('owner_id', $vendor->id)
                ->where('status', 6);
        })->count();
        $orderReturns = OrderReturnRequest::whereHas('orderReturnProducts',function ($query) use ($vendor) {
            $query->whereHas('order_product',function ($query) use ($vendor) {
                $query->where('owner_id', $vendor->id);
            });
        })->count();
        $orderReturnsPending = OrderReturnRequest::where('status_id', 1)->whereHas('orderReturnProducts',function ($query) use ($vendor) {
            $query->whereHas('order_product',function ($query) use ($vendor) {
                $query->where('owner_id', $vendor->id);
            });
        })->count();
        $orderReturnsApproved = OrderReturnRequest::where('status_id', 2)->whereHas('orderReturnProducts',function ($query) use ($vendor) {
            $query->whereHas('order_product',function ($query) use ($vendor) {
                $query->where('owner_id', $vendor->id);
            });
        })->count();
        $commission = Commission::where('user_id', $vendor->id)->first();
        $sales = OrderProduct::where('owner_id', $vendor->id)->where('status', 4)->get();
        // dd($sales);
        $total_balance = 0;
        foreach($sales as $sale)
        {
            $price = $sale->price * $sale->qty;
            $commissions = $price * ($sale->products->commission / 100);
            $total_balance += ($price - $commissions);
        }
        
        $total_withdraws = Withdraw::where('vendor_id', $vendor->id)->where('status', 2)->pluck('amount');
        $total_withdraw = 0;
        foreach($total_withdraws as $withdraw)
        {
            $total_withdraw += $withdraw;
        }
        $last_withdraw = Withdraw::where('vendor_id', $vendor->id)->where('status', 2)->orderBy('id', 'DESC')->first();
        
        $total_orders = OrderProduct::where('owner_id', $vendor->id)->where('status', 4)->get();
        $total_balance = 0;
        $total_commission = 0;
        $tax = 0;
        foreach($total_orders as $order)
        {
            $price = $order->price * $order->qty;
            $tax += $price * ($order->tax / 100);
            $commissions = $price * ($order->products->commission / 100);
            $total_commission += $commissions;
            $total_balance += ($price - $commissions);
        }
        
        return view('admin.vendors.view', compact('vendor', 'products','approved','pending', 'reviews',
            'commission', 'orders', 'ordersPending', 'ordersApproved', 'ordersReceived',
            'ordersDelivered', 'ordersCancelled', 'ordersReview', 'orderReturns', 'orderReturnsPending', 'orderReturnsApproved', 'total_balance', 'total_withdraw', 'last_withdraw', 'tax', 'total_commission'));
    }

    public function getVendorTable($id)
    {
        return view('admin.vendors.table');
    }

    public function getVendorStatsJson($id)
    {
        $products = Product::where('user_id', 1)->get();
        return datatables($products)->toJson();
    }

    public function main() {
        $usersCount = \request()->has( 'role' ) && \request( 'role' ) != 'client' ? $this->userRepository->getByRole( \request( 'role' ) ) : $this->userRepository->getVisitors();

        return view( 'admin.users.index' )
            ->with( [ 'usersCount' => count( $usersCount ) ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $roles = array( '' => 'Select Role' ) + Role::pluck( 'display_name', 'id' )->toArray();

        return view( 'admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest|Request $request
     *
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function store( Request $request )
    {

        $this->validate( $request, [
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|string|email|max:255|unique:users,email,',
            'phone'      => 'min:10',
            'role'       => 'required|numeric',
            'image'      => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password'   => 'required|confirmed|min:6',
        ] );

        try {
            $this->userRepository->store( $request->all() );
        } 
        catch ( Exception $e ) {
            throw new Exception( 'Error in saving user: ' . $e->getMessage() );
        }

        return redirect()->back()->with( 'success', 'User successfully created!!' );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {
        $user = $this->userRepository->find( $id );

        return view( 'admin.users.show', compact( 'user' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        $user       = $this->userRepository->find( $id );
        $activeRole = $user->roles->first();

        if ( ! auth()->user()->hasRole( 'admin' ) ) {
            $roles = Role::whereNotIn( 'name', [ 'admin' ] )->pluck( 'display_name', 'id' )->toArray();
        } else {
            $roles = Role::pluck( 'display_name', 'id' )->toArray();
        }
        
        $destinations = DeliveryDestination::pluck('name', 'id')->toArray();

        return view( 'admin.users.edit', compact( 'user', 'activeRole', 'roles', 'destinations' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest|Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function update( $id, Request $request )
    {
        $this->validate( $request, [
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|string|email|max:255',
            'phone'      => 'min:10',
            'role'       => 'required|numeric',
            'image'      => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ] );
        if ($request->password) {
            $this->validate($request, [
                'password'   => 'confirmed|min:6'
            ]);

        }

        try {

            $this->userRepository->updateUser( $id, $request->all() );

        } catch ( Exception $e ) {

            throw new Exception( 'Error in updating user: ' . $e->getMessage() );
        }

        return redirect()->back()->with( 'success', 'User successfully updated!!' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function destroy( $id )
    {
        try {

            $this->userRepository->deleteUser( $id );

        } catch ( Exception $e ) {

            throw new Exception( 'Error in deleting user: ' . $e->getMessage() );
        }

        return response()->json('User Sucessfullly Deleted');
    }

    public function getUsersJson( Request $request ) {

        switch ( $request->input( 'role' ) ) {
            case 'admin':
                $users = $this->userRepository->getByRole( $request->input( 'role' ) );
                break;
            case 'manager':
                $users = $this->userRepository->getByRole( $request->input( 'role' ) );
                break;
            case 'vendor':
                $users = $this->userRepository->getByRole( $request->input( 'role' ) );
                break;
            case 'client':
                $users = $this->userRepository->getVisitors();
                break;
            default:
                $users = $this->userRepository->all();
        }

        foreach ( $users as $user ) {
            $user->name   = $user->full_name;
            $user->avatar = null !== $user->getImage() ? $user->getImage()->smallUrl : $user->getDefaultImage()->smallUrl;
            $user->role   = optional( $user->roles->first() )->display_name;
        }

        return datatables( $users )->toJson();
    }

    public function chat($id)
    {
        $vendor = User::findOrFail($id);
        $messages = Chat::where('admin_id', auth()->id())->where('vendor_id', $vendor->id)->get();
        return view('admin.vendors.chat', compact('vendor', 'messages'));
    }

    public function chatStore(Request $request)
    {
        $request->validate([
            'image' => 'mimes:jpeg,png,gif'
        ]);

        $chat =  new Chat();
        $chat->admin_id = auth()->id();
        $chat->vendor_id = $request->id;
        $chat->message =$request->chat;

        if($request->image) {
            $chat->image = 'data:image/jpeg/png/gif;base64,' . base64_encode(file_get_contents($request->file('image')));
        }

        $chat->active = 0;
        $chat->save();
        return redirect()->back();
    }
}
