<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\VendorRequest;
use App\Http\Requests\WithDrawRequest;
use App\Model\Brand;
use App\Model\Category;
use App\Model\Order;
use App\Model\OrderProduct;
use App\Model\OrderReturnRequest;
use App\Model\Product;
use App\Model\VendorDocument;
use App\VendorRating;
use App\Model\ReviewProduct;
use App\Model\Commission;
use App\Model\Vendor;
use App\Model\VendorDetail;
use App\Model\WithDraw;
use App\Model\WithdrawStatus;
use App\Repositories\Contracts\BrandRepository;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\VendorRepository;
use App\User;
use App\VendorBankInfo;
use Illuminate\Http\Request;
use Exception;
use Session;
use App\Mail\EmailVerification;

use Illuminate\Foundation\Auth\RegistersUsers;


use Auth;
use File;
use Storage;

class VendorController extends Controller
{
    use RegistersUsers;

    private $vendorRepository;

    public function __construct(VendorRepository $vendorRepository)
    {
        $this->vendorRepository = $vendorRepository;
    }

    public function getDashboard()
    {
        $vendor = User::findOrFail(auth()->id());
        $ratings = VendorRating::where('vendor_id', $vendor->id)->whereNotIn('status',['deleted'])->count();
        $products = Product::where('user_id', $vendor->id)->whereNotIn('status',['deleted'])->count();
        $approved = Product::where('user_id', $vendor->id)->where('approved', 1)->whereNotIn('status',['deleted'])->count();
        $pending = Product::where('user_id', $vendor->id)->where('approved', 0)->whereNotIn('status',['deleted'])->count();
        $reviews = ReviewProduct::whereHas('products', function ($query) use ($vendor) {
            $query->where('user_id', $vendor->id);
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
        $order_products = OrderProduct::where('owner_id', auth()->id())->where('status','!=', 5)->where('status','!=', 9)->get();
        // dd($order_products);
        $total_balance = 0;
        foreach($order_products as $order)
        {
            // dd($order->products);
            $price = $order->price * $order->qty;
            $total_balance += $price;
        }
        
 
        $order12 = Order::whereHas('orderProduct',function ($query) use ($vendor) {
            $query->where('owner_id', $vendor->id)
                ->where('created_at', '<', date("Y-m-d H:i:s"))->where('created_at', '>', date("Y-m-d H:i:s",strtotime("-12 hour")));
        })->get();
        $order24 =Order::whereHas('orderProduct',function ($query) use ($vendor) {
            $query->where('owner_id', $vendor->id)
                ->where('created_at', '<', date("Y-m-d H:i:s"))->where('created_at', '>', date("Y-m-d H:i:s",strtotime("-24 hour")));
        })->get(); 
        
        // dd($order12);
        

        return view('merchant.dashboard', compact('vendor', 'ratings', 'reviews', 'products','approved','pending', 'reviews',
            'commission', 'orders', 'ordersPending', 'ordersApproved', 'ordersReceived',
            'ordersDelivered', 'ordersCancelled', 'ordersReview', 'orderReturns', 'orderReturnsPending', 'orderReturnsApproved', 'total_balance', 'order12', 'order24'));
    }

    public function getConfiguration()
    {
        
        $categories = Category::where('parent_id', 0)->get();
        
         foreach($categories as $key => $category){
            if($category->id == 609 || $category->id == 723){
           unset($categories[$key]);
            }
        }
        $vendor = Vendor::where('user_id', auth()->id())->first();
        $vendorCategory = json_decode($vendor->type);
        // $request = VendorDetail::where('user_id', auth()->id())->first();
        return view('merchant.configuration.index', compact('vendor', 'categories', 'vendorCategory'));
    }

    public function index()
    {
        // $id = Auth::user()->id;
        // $vendor_details = VendorDetails::where('user_id',$id)->get();
        return view('merchant.vendors.index');
    }

    public function vendorDetails()
    {
        return view('merchant.vendors.index');
    }

    public function updateVendorprofile(Request $request){
        // dd($request);
         $vendorDetails=VendorDetail::where('user_id',auth()->id())->first();
        
          if($request->vpicture){
           
            if($vendorDetails->vendor_image)
            {
                 $vimage=$vendorDetails->vendor_image;
                File::delete($vimage);
            }
            $images = $request['vpicture'];
            $name = Storage::disk('public')->putFile('documents', $images);
            $filename= basename($name);
            $vendorDetails->vendor_image ='documents'.'/'.$filename;
            $vendorDetails->update();

        }
        
        if($request->password || $request->cpassword){
             $user = User::where('id', auth()->id())->first();
               $user->password = bcrypt($request->password) ;
                $user->update();
        }
        return redirect()->back()->with('success', 'Profile Successfully Updated');
    }

    public function storeVendorDetails(Request $request)
    {
       
       $id = \Illuminate\Support\Facades\Auth::id();
        try
        {
            $request->vendor_code = 'NAS'.$id.rand(0,9);
            $this->vendorRepository->vendorDetailsStore($request->all());
        }
        catch (Exception $e)
        {
            throw new Exception( 'Error in saving details: ' . $e->getMessage() );
        }
        return redirect()->back()->with('success', 'Vendor Details Successfully Added');
    }
    public function sendVendorRequest(Request $request){
// dd($request);

        if (Auth::user()) {
            $request->validate([
                'name' => 'required|unique:vendor_details',
                'user_name' => 'unique:users',
                'shop_category' => 'required',
                'address' => 'required',
            ]);
        }
        else{
            $request->validate([
                'name' => 'required|unique:vendor_details',
                'user_name' => 'unique:users',
                'shop_category' => 'required',
                'address' => 'required',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|numeric|min:9',
                'password' => 'confirmed|required| min:5 |max:30',
                'password_confirmation' => 'required| min:5 |max:30',

            ]);

        }


        if(Auth::user())
        {
            $new=new VendorDetail();
            $new->user_id=auth()->id();
            $new->name=$request->name;
            $new->primary_email=Auth::User()->email;
            $new->type=json_encode($request->shop_category);
            $new->primary_phone=Auth::User()->phone;

            $new->address=$request->address;
            $new->verified='0';
            $new->vendor_code='NAS'.auth()->id().rand(0,9);
            $success = $new->save();
            $role=array(3);
            Auth::user()->roles()->sync( $role);
            if($success) {
                return response() ->json([
                    'status' => 'success',
                    'message' => 'Successfully Register'
                ]);

            }else{
                return response() ->json([
                    'status' => 'error',
                    'message' => 'Error While Registration!!'
                ]);
            }
        }


        else
        {
            $user = User::create([
                'user_name' => $request['name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'verified' => 0,
                'password' => bcrypt($request['password']),
                'token' => base64_encode($request['email'])

            ]);
            $data = [
                'email_token'=>$user->token
            ];
            $user->referral_code()->create([
                'user_id' => $user->id,
                'referal_code'=>$user->user_name.rand(0,9).rand(0,9).rand(0,9)
            ]);
            $user->wallets()->create([
                'user_id' => $user->id,
                'amount'=>0
            ]);
            // dd($user);
            
            $new=new VendorDetail();
            $new->user_id=$user->id;
            $new->name=$request->name;
//            $new->pan_number=$request->pan_number;
            $new->primary_email=$request->email;
            $new->type=json_encode($request->shop_category);
            $new->primary_phone=$request->phone;

            $new->address=$request->address;
            $new->verified='0';
            $new->vendor_code='NAS'.$user->id.rand(0,9);


            $success = $new->save();
            $role=array(3);
            $user->roles()->sync( $role);
            
            $this->guard()->login($user);
            if($success) {
                return response() -> json([
                    'status' => 'success',
                    'message' => 'Successfully Register'
                ]);

            }else{
                return response() -> json([
                    'status' => 'error',
                    'message' => 'Error While Registration!!'
                ]);
            }

        }



//
    }

    public function completeVendorRegistration(Request $request)
    {
        // dd($request);
        $request->validate([
            'pan_number' => 'required',
            'tax_clearance' => 'required',


            'pan_image' => 'required|image',

            'signature_image' => 'required|image',
            'company_image' => 'required|image',


        ]);
        $vendorDetail=VendorDetail::where('user_id',auth()->id())->first();
        $vendorDetail->pan_number=$request->pan_number;
        $vendorDetail->tax_clearance=$request->tax_clearance;
        $vendorDetail->update();

        
        if($request->pan_image){
            $pan=VendorDocument::where('vendor_detail_id',$vendorDetail->id)->where('title','pan_image')->first();
            if($pan)
            {


                $test=$pan->image;
                File::delete($test);
                $pan->delete();

            }
            $images = $request['pan_image'];

            $name = Storage::disk('public')->putFile('documents', $images);

            $filename= basename($name);
            $vendorDocument=new VendorDocument();
            $vendorDocument->vendor_detail_id=$vendorDetail->id;
            $vendorDocument->title='pan_image';
            $vendorDocument->image ='documents'.'/'.$filename;
            $vendorDocument->save();

        }
        if($request->company_image){
            $com=VendorDocument::where('vendor_detail_id',$vendorDetail->id)->where('title','company_image')->first();

            if($com)
            {
                $test=$com->image;
                File::delete($test);
                $com->delete();
            }
            $vendorDocument=new VendorDocument();
            $images = $request['company_image'];


            $name = Storage::disk('public')->putFile('documents', $images);
            $filename= basename($name);
            $vendorDocument->vendor_detail_id=$vendorDetail->id;

            $vendorDocument->title='company_image';
            $vendorDocument->image ='documents'.'/'.$filename;
            $vendorDocument->save();
        }
        if($request->signature_image){
            $sig=VendorDocument::where('vendor_detail_id',$vendorDetail->id)->where('title','signature_image')->first();
            if($sig)
            {$test=$sig->image;
                File::delete($test);
                $sig->delete();
            }
            $images = $request['signature_image'];


            $name = Storage::disk('public')->putFile('documents', $images);
            $filename= basename($name);
            $vendorDocument=new VendorDocument();
            $vendorDocument->vendor_detail_id=$vendorDetail->id;

            $vendorDocument->title='signature_image';
            $vendorDocument->image ='documents'.'/'.$filename;
            $vendorDocument->save();
        }
        return redirect()->route('vendor.dashboard')->with('success','Please Wait For Approval! Thank You');

    }
    public function getVendorDetails()
    {
        // $id = Auth::user()->id;
        $vendor_details = VendorDetail::all();
        return datatables($vendor_details)->toJson();
    }

    public function delete($id)
    {
        $delete = VendorDetail::findOrFail($id);
        $delete->delete();
    }

    public function editVendorDetails($id)
    {
        $vendor_details = VendorDetail::where('id', $id)->first();
        return view('merchant.vendors.edit_vendor_details', compact('vendor_details'));
    }

    public function updateVendorDetails(UserRequest $request)
    {

        $request->vendor_code = 'NAS'.$id.rand(0,9);
        $vendorDetails = VendorDetail::findOrFail($request->id);
        $vendorDetails->update($request->all());
    }

    public function viewVendorDetails($id)
    {
        $vendor_details = VendorDetail::where('id', $id)->first();
        $user_id = $vendor_details->user_id;
        $vendor_info = User::where('id', $user_id)->get();
        return view('merchant.vendors.view_vendor_details', compact('vendor_details', 'vendor_info'));
    }
    public function getWithdraw()
    {
        $orders = OrderProduct::where('owner_id', auth()->id())->where('status','!=', 5)->where('status','!=', 9)->get();
        $total_balance = 0;
        foreach($orders as $order)
        {
            $price = $order->price * $order->qty;
            $total_balance += $price;
        }
        
        $cancelledorders = OrderProduct::where('owner_id', auth()->id())->where('status', 5)->where('status', 9)->get();
        $total_cancelledorders = 0;
        foreach($cancelledorders as $order)
        {
            $price = $order->price * $order->qty;
            $total_cancelledorders += $price;
        }
        
        $returnorders = OrderProduct::where('owner_id', auth()->id())->where('status', 5)->get();
        $total_returnorders = 0;
        foreach($returnorders as $order)
        {
            $price = $order->price * $order->qty;
            $total_returnorders += $price;
        }
        $total_withdraws = Withdraw::where('vendor_id', auth()->id())->where('status', 4)->pluck('amount');
        $total_withdraw = 0;
        foreach($total_withdraws as $withdraw)
        {
            $total_withdraw += $withdraw;
        }
        // dd($total_withdraw);
        $last_withdraw = Withdraw::where('vendor_id', auth()->id())->where('status', 4)->orderBy('id', 'DESC')->first();
        $withdraws = WithDraw::where('vendor_id',auth()->id())->get();
        return view('merchant.withdraw.index',compact('withdraws', 'total_balance', 'total_withdraw', 'last_withdraw', 'total_commission', 'tax', 'total_returnorders', 'total_cancelledorders'));
    }

    public function getWithdrawRequest()
    {
        $vendor = Auth::user()->vendorDetails;

        return view('merchant.withdraw.create',compact('details', 'vendor'));
    }

    public function getWithdrawStore(WithDrawRequest $request)
    {
        $withdraw_status = WithdrawStatus::where('is_default',1)->first()->id;

        $withdraw = new WithDraw;

        $withdraw->vendor_id = auth()->id();
        $withdraw->amount = $request->amount;
        $withdraw->approve = $request->approve;
        $withdraw->bank_name = $request->bank_name;
        $withdraw->account_no = $request->account_no;
        $withdraw->account_name = $request->account_name;
        $withdraw->bank_branch = $request->bank_branch;
        $withdraw->additional_references = $request->reference;
        $withdraw->status = $withdraw_status;

        $withdraw->save();

    

        return redirect()->route('vendor.withdraw')->with('success',"Withdraw Request Received");
    }

    public function getEdit($id)
    {

        $withDrawStatus = WithdrawStatus::all();
        $details = WithDraw::findOrFail($id);
        return view('merchant.withdraw.edit',compact('details','withDrawStatus'));
    }

    public function getWithdrawAccount()
    {
        $vendor_id = auth()->id();
        $details = WithDraw::where('vendor_id', $vendor_id)->get();
        return view('merchant.withdraw.use',compact('details'));
    }


    public function getWithdrawUse($id){
        $details = WithDraw::findOrFail($id);
        return view('merchant.withdraw.use-create',compact('details'));

    }

    public function getWithdrawCancel($id)
    {
        $withdraw=WithDraw::findorfail($id);
        if($withdraw->status==1){
            $withdraw->status=3;
            $withdraw->update();
            return redirect()->back()->with('success','Your Withdraw Has been Canceled');
        }
        else
            return redirect()->back()->with('error','Something Went Wrong !!');

    }

    public function getVendorProfile($id)
    {
        $user = Auth::user();
        return view('merchant.vendor_profile', compact('user'));
    }
}
