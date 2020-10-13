<?php

namespace App\Http\Controllers\Frontend;

use App\DeliveryCharge;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\PaymentMethod;

use App\Model\Referral;
use App\Model\ReferralInfo;
use App\Model\Order;
use App\Model\OrderProduct;
use App\Model\ShippingAccount;
use App\Model\ShippingAmount;
use App\Model\TempOrder;
use App\Model\Wallet;
use App\OrderPayment;
use App\Repositories\Contracts\OrderRepository;
use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Mail\OrderSent;
use Illuminate\Support\Facades\Auth;
use App\User;


class CheckoutController extends Controller
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        return $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $user = auth()->id();
        $verified = User::find($user)->verified;
        if ($verified == 0) {
            return redirect()->back()->with('error', 'Your Account has not been verified. Please check your email and verified! To resend email, go to your account.');
        }

        $shipping = ShippingAccount::where('user_id', auth()->id())->where('is_default', 1)->first();
        // dd($shipping);
        $shipping_places = ShippingAmount::all();
        $paymentMethod = PaymentMethod::all();
        return view('front.checkout.checkout', compact('shipping', 'shipping_places', 'paymentMethod'));
    }
    
    
    public function checkOrderProductDuplicate(Request $request){
        
        $requestedUser = ShippingAccount::where('mobile', $request->input('mobile'))->get()->pluck('id');
        $checkOrders = Order::whereIn('address_id', $requestedUser)->get()->pluck('id');
        $checkOrderProducts = OrderProduct::whereIn('order_id', $checkOrders)->get();


        foreach ($checkOrderProducts as $checkOrderProduct){
                $message[] = '<span>This User Already buy This Product : </span>'.$checkOrderProduct->products->name.' <span>Date: </span> '.$checkOrderProduct->created_at->diffForHumans().'<span>, Order Status : </span>'.$checkOrderProduct->order->orderStatus->name .'<br>';



        }
        
        return response()->json([
            'product' =>  $message,
                ],200);
    }


    public function handleCheckout(Request $request){
        
        
        // dd(ShippingAccount::where('mobile', $request->mobile)->get());
        
        // foreach($cartContents as $cartContent){
            
            
        // }
        // dd($request);
        
        
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|string|max:255',
            'country' => 'required',
            'area' => 'required',
            'district' => 'required',
            'zone' => 'required',
            'mobile' => 'required|min:9|max:15',
        ]);
        $ship_location = DeliveryCharge::where('id', $request->area)->first();
// dd($ship_location);
        if ($ship_location == null) {
            return redirect()->back()->with('error', 'Invalid location !');
        }
        
        $cartContents = Cart::content();
        
        try {
            if(isset($cartContents) && $cartContents->isEmpty()) {
                return redirect()->back()->with('error', 'There is no item in your cart');
            }
            
            $order = $this->orderRepository->store($request->all());
            $code = $order->code;
        } catch (\Exception $e) {
            throw new \Exception('Error in saving order: ' . $e->getMessage());
        }
        $data2 = [
            'name' => $request->first_name . '  ' . $request->last_name,
            'products' => $cartContents,
            'subject' => 'Order Received',
            'ship_amount' => $ship_location->value,
            'order' => $order
        ];
        
        
        foreach($order->orderProduct as $product){
            
            $product->totalPrice = $product->price * $product->qty;
        }
        
        $order->finalPrice = $order->orderProduct->sum('totalPrice');
        
        $finalAmount = $order->finalPrice + $order->shipping_amount;
        
            // dd($finalAmount);
            
        
        TempOrder::create([
           'order_id' => $order->id,
           'address_id' => $order->address_id,
           'shipping_amount' => $order->shipping_amount,
       ]);


            if($request->payment_method_id == 8) {
                
            TempOrder::create([
                'order_id' => $order->id,
                'address_id' => $order->address_id,
                'shipping_amount' => $order->shipping_amount,
            ]);
            
            
            return redirect('https://banksmarttest.nicasiabank.com/thirdparty-merchant-payment-web/?RU=' . url('/order/payment/conform') . '&PID=BOALNPKA&PRN=' . $order->id . '&MC=PASHUPATI&ITC=' . $order->id . '&AMT='. $finalAmount .'&UniqueId=' . $order->code . '&MN=PASHUPATI&Remark1=Nepal All Shop Pvt.ltd&Remark2=&MD=P');
        
                
            }else{
                   Cart::destroy();
            //  \Mail::to($request->email)->send(new OrderSent($data2));
        Session::flash('order', 'Saved!');
        return view('front.checkout.order_status', compact('code'));
        }



       
    }
    
    
    
    public function paymentConform(Request $request){
        
        
         
            
     
            if($request->PAID == 'Y'){

            OrderPayment::create([
                    'order_id' => $request->PRN,
                    'paidby' => $request->INT,
                    'payment_method' => 'NIC Asia mPay',
                    'amount'=>$request->AMT,
            ]);

            $tempOrder = TempOrder::where('order_id', $request->PRN)->first();
          
            $tempOrder->delete();
            
            
            
            Cart::destroy();
            

            return redirect()->route('order.payment.verify','trakingcode='.$request->UniqueId);

            }else{

            $order = Order::where('id', $request->PRN)->first();
            $order->delete();

            $tempOrder = TempOrder::where('order_id', $request->PRN)->first();
            
            $tempOrder->delete();

           return redirect()->route('checkout');

            // return redirect('https://banksmarttest.nicasiabank.com/thirdparty-merchant-payment-web?RU='.url('/order/payment/verify').'&PID=BOALNPKA&PRN='.$request->PRN.'&MC='.$request->MC.'&ITC='.$request->ITC.'&AMT='.$request->AMT.'&UniqueId='.$request->UniqueId.'&MN=PASHUPATI&Remark1=te2st1&Remark2=test22&MD=V');

        }

        

    }

    public  function paymentVerify(Request $request){
       
            $code = $request->trakingcode;
        return view('front.checkout.order_status', compact('code'));
    }
    
    

    public function handleOrderStatus()
    {
        if (session('order')) {
            $title = 'Order Received';
        } else {
            $title = 'Order';
        }

        return view('front.checkout.order_status', compact('title'));
    }

    public function shippingAmount(Request $request)
    {
        $subTotal = 0;
        $tax = 0;
        $amount = DeliveryCharge::where('id', $request->location)->first();
        $amount = $amount->value;

        if (Cart::count() != 0) {
            foreach (Cart::instance('default')->content() as $cartContent) {
                if(\App\Model\Product::where('id', $cartContent->id)->first()->prebooking == 1) {
                    $subTotal += ((($cartContent->qty * $cartContent->price) * 10) / 100);
                    if (\App\Model\Product::findOrFail($cartContent->id)->tax) {
                        $tax += 0;
                    }
                    $amount = 0;
                }
                else {
                    $subTotal += $cartContent->qty * $cartContent->price;
                    if (\App\Model\Product::findOrFail($cartContent->id)->tax) {
                        $tax += (($cartContent->qty * $cartContent->price) * (\App\Model\Product::where('id', $cartContent->id)->first()->tax)) / 100;
                    }
                }
                $grandTotal = $subTotal + $tax;
            }
        }
        if(session()->exists('coupon'))
        {
            $grandTotal = $grandTotal - session()->get('coupon')['discount_value'];
        }

        $data['cart'] = $grandTotal;
        $data['amount'] = $amount;
        $data['grandTotal'] = number_format($grandTotal + $amount, 2);

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'shipping_address' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|string|max:255',
            'country' => 'required',
            'area' => 'required',
            'district' => 'required',
            'zone' => 'required',
            'mobile' => 'required|min:9|max:15',
        ]);
        $ship_location = ShippingAmount::where('place', $request->shipping_address)->first();

        if ($ship_location == null) {
            return redirect()->back()->with('error', 'Invalid location !');
        }
        $cartContents = Cart::instance('prebooking')->content();
        try {
            $order = $this->orderRepository->update($id, $request->all());
            $code = $order->code;
        } catch (Exception $e) {
            throw new Exception('Error in updating order: ' . $e->getMessage());
        }
        $data2 = [
            'name' => $request->first_name . '  ' . $request->last_name,
            'products' => $cartContents,
            'subject' => 'Order Received',
            'ship_amount' => $ship_location->amount,

        ];

        \Mail::to(Auth::User()->email)->send(new OrderSent($data2));
        Session::flash('order', 'Saved!');
        return view('front.checkout.order_status', compact('code'));
    }
    public function zonechange(Request $request){
        $id=$request->zone;
        return view('front.checkout.zone',compact('id'));
    }

}
