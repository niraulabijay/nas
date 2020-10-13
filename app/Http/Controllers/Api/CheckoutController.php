<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OrderSent;
use App\Model\Coupon;
use App\Model\CouponProduct;
use App\Model\Order;
use App\Model\OrderProduct;
use App\Model\OrderStatus;
use App\Model\PaymentMethod;
use App\Model\Product;
use App\Model\ShippingAccount;
use App\Model\ShippingAmount;
use App\Repositories\Contracts\OrderRepository;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CheckoutController extends Controller
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        return $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $shipping_places = ShippingAmount::all();
        $paymentMethod = PaymentMethod::all();
        foreach ($paymentMethod as $payment) {
        	$payment->image = $payment->getImage() ? $payment->getImage()->smallUrl : asset('/front/img/default-product.jpg');
        }

        $data = [
        	'shipping_places' => $shipping_places,
        	'payment_methods' => $paymentMethod
        ];

        return response()->json($data);
    }

    public function handleCheckout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_address' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|string|max:255',
            'country' => 'required',
            'area' => 'required',
            'district' => 'required',
            'zone' => 'required',
            'mobile' => 'required|min:9|max:15',
            'cartContents' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], Response::HTTP_NOT_ACCEPTABLE);
        }
        
        $ship_location = ShippingAmount::where('place', $request['shipping_address'])->first();

        if ($ship_location == null) {
            return response()->json(['error' => 'Invalid location !'], 401);
        }

        $addressData = [
            'user_id' => auth()->id(),
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'country' => isset($request['country']) ? $request['country'] : 'Nepal',
            'area' => $request['area'],
            'district' => $request['district'],
            'zone' => $request['zone'],
            'location_type' => $request['location_type'],
            'mobile' => $request['mobile'],
        ];

        $address = ShippingAccount::updateOrCreate(['id' => $request['address_id'], 'user_id' => auth()->id()], $addressData);
        $request['address_id'] = $address->id;
        $location= $request['shipping_address'];
        $shipdetail= ShippingAmount::where('place',$location)->first();
        $orderStatus = OrderStatus::whereIsDefault(1)->get()->first();
        $barcode = $this->generateBarcodeNumber();
        $order = Order::create([
            'address_id' => $request['address_id'],
            'payment_method_id' => $request['payment_method_id'],
            'user_id' => auth()->id(),
            'shipping_amount' => $shipdetail->amount,
            'order_place' => $shipdetail->place,
            'order_status_id' => $orderStatus->id,
            'order_date' => Carbon::now()->toDateTimeString(),
            'code'=>Carbon::now()->month.rand(0,9).auth()->id().rand(0,9).Carbon::now()->day.rand(0,9),
            'barcode' => $barcode
        ]);

        $cartContents = $request['cartContents'];
        foreach ($cartContents as $cartContent) {

            $order->products()->attach($cartContent['product_id'],
	            [
	                'owner_id' => Product::findorfail($cartContent['product_id'])->user_id ,
	                'qty' => $cartContent['qty'],
	                'price' => $cartContent['price'],
	                'discount' => isset($request['coupon']) && $request['coupon']['product_id'] == $cartContent['product_id'] ? $request['coupon']['discount_value'] : null,
	                'coupon_id' => isset($request['coupon']) && $request['coupon']['product_id'] == $cartContent['product_id'] ? $request['coupon']['id'] : null,
	                'status' =>'1',
	                'size' => isset($cartContent['size']) ? $cartContent['size'] : null,
	                'tax' => Product::where('id',$cartContent['product_id'])->first()->tax,
	                'prebooking' => Product::where('id',$cartContent['product_id'])->first()->prebooking == 1 ? 1 : 0
	            ]
	        );

            if (Product::where('id',$cartContent['product_id'])->first()->prebooking == 1) {
                $order->prebookings->create([
                    'order_id' => $order->id,
                    'product_id' => $cartContent['product_id'],
                    'price' => ((($cartContent['qty'] * $cartContent['price'])) * 10) / 100
                ]);
            }
        }

        $code = $order->code;
        
        $data2 = [
            'name' => $request['first_name'] . '  ' . $request['last_name'],
            'products' => $cartContents,
            'subject' => 'Order Received',
            'ship_amount' => $ship_location->amount,

        ];

        // \Mail::to(Auth::User()->email)->send(new OrderSent($data2));

        return response()->json(['success' => 'Order successfully placed!'], 201);
    }

    public function shippingAmount(Request $request)
    {
        $subTotal = 0;
        $tax = 0;
        $amount = \App\Model\ShippingAmount::where('place', $request->location)->first();
        $amount = $amount->amount;

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

        $data['cart'] = $grandTotal;
        $data['amount'] = $amount;
        $data['grandTotal'] = number_format($grandTotal + $amount, 2);

        return response()->json($data);
    }

    function generateBarcodeNumber() {
        $number = mt_rand(0000000000, 9999999999);

        if ($this->barcodeNumberExists($number)) {
            return $this->generateBarcodeNumber();
        }

        return $number;
    }

    function barcodeNumberExists($number) {
        return Order::whereBarcode($number)->exists();
    }

    public function couponCheck(Request $request)
    {

        $val = $request->input('coupon_code');
        if(session()->exists('coupon'))
        {
            return response()->json(['success' => 'Coupon has already applied!'], Response::HTTP_NOT_ACCEPTABLE);
        }
        if ($val != null) {
            $coupon = Coupon::where('code', $val)->first();
            if (!$coupon) {
                return response()->json(['error' => 'Coupon Does not exist!'], Response::HTTP_NOT_FOUND);
            }
            else
            {
                if(OrderProduct::where('coupon_id',$coupon->id)->get()->count() >= $coupon->uses_per_coupon )
                {
                    return response()->json(['error' => 'Coupon Maximum Limit Exceeded!'], Response::HTTP_NOT_ACCEPTABLE);

                }
                if(Carbon::now()->toDateString() < $coupon->start_date )
                {
                    return response()->json(['error' => 'Coupon Not Started Yet!'], Response::HTTP_NOT_ACCEPTABLE);

                }
                if(Carbon::now()->toDateString() > $coupon->end_date )
                {
                    return response()->json(['error' => 'Coupon Expired!'], Response::HTTP_NOT_ACCEPTABLE);

                }
                $coupon_product=CouponProduct::where('coupon_id',$coupon->id)->whereIn('product_id',$request->product_id)->get();
                if($coupon_product->count() > 0)
                {
                    $data = [
                        'id' => $coupon->id,
                        'product_id' => $coupon_product->first()->product_id,
                        'code' => $coupon->code,
                        'discount_value' => $coupon->discount_value
                    ];
                    return response()->json($data, Response::HTTP_OK);

                }
                else
                {
                    return response()->json(['error' => 'This Coupon Does not Applied to This Product!'], Response::HTTP_NOT_ACCEPTABLE);
                }

            }
        } 
        else 
        {
            return response()->json(['error' => 'Field is empty!'], Response::HTTP_NOT_FOUND);

        }

    }
}
