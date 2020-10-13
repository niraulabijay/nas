<?php

namespace App\Repositories\Eloquent;

use App\Model\Coupon;
use App\DeliveryCharge;

use App\Model\Order;
use App\Model\OrderProduct;
use App\Model\OrderReturnRequest;
use App\Model\OrderReturnRequestProduct;
use App\Model\OrderStatus;
use App\Model\Product;
use App\Model\ProductAdditional;
use App\Model\Referral;
use App\Model\ReferralInfo;
use App\Model\ShippingAccount;
use App\Model\ShippingAmount;
use App\Model\Wallet;
use App\Repositories\Contracts\OrderRepository;
use App\User;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\CartItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentOrderRepository extends AbstractRepository implements OrderRepository
{
    public function entity()
    {
        return Order::class;
    }

    public function store(array $attributes)
    {
        
        $addressData = [
            'user_id' => auth()->id(),
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'email' => $attributes['email'],
            'country' => isset($attributes['country']) ? $attributes['country'] : 'Nepal',
            'area' => DeliveryCharge::where('id',$attributes['area'])->first()->name,
            'district' => DeliveryCharge::where('id',$attributes['district'])->first()->name,
            'zone' => DeliveryCharge::where('id',$attributes['zone'])->first()->name,
            'location_type' => null,
            'mobile' => $attributes['mobile'],
            'phone' => $attributes['phone'],
            'address' => $attributes['address'],
        ];
        $address = ShippingAccount::updateOrCreate( $addressData);
        $attributes['address_id'] = $address->id;
        $location= $attributes['area'];
        $shipdetail= DeliveryCharge::where('id',$location)->first();
        $orderStatus = OrderStatus::whereIsDefault(1)->get()->first();
        $barcode = $this->generateBarcodeNumber();
        $order_date = $attributes['order_date'];
        
        if($order_date != null){
            $order_date_time = Carbon::now()->addDays($attributes['order_date'])->toDateTimeString();
        }else{
            
            $order_date_time = Carbon::now()->toDateTimeString();
        }
        
        $order = $this->entity->create([
            'address_id' => $attributes['address_id'],
            'payment_method_id' => $attributes['payment_method_id'],
            'user_id' => auth()->id(),
            'shipping_amount' => $shipdetail->value,
            'order_place' => $shipdetail->name,
            'order_note' => $attributes['order_note'],
            'order_status_id' => $orderStatus->id,
            'order_date' => $order_date_time,
            'barcode' => $barcode
        ]);
       
       $order->code=rand(0, 9).auth()->id().$order->id.rand(0, 9) ;
       $order->update();
       
       
        $cartContents = Cart::content();
        if ( $cartContents ) {
            foreach ($cartContents as $cartContent) {
                $order->products()->attach($cartContent->id,
                    [
                        'owner_id' => Product::findorfail($cartContent->id)->user_id ,
                        'qty' => $cartContent->qty,
                        'price' => $cartContent->price,
                        'discount' => session()->exists('coupon') && session()->get('coupon')['product_id'] == $cartContent->id ? session()->get('coupon')['discount_value'] : null,
                        'coupon_id' => session()->exists('coupon') && session()->get('coupon')['product_id'] == $cartContent->id ? session()->get('coupon')['id'] : null,
                        'status'=>'1',
                        // 'colour'=> $cartContent->options->colour,
                        'size'=> $cartContent->options->size,
                        'tax' => Product::where('id',$cartContent->id)->first()->tax,
                        'prebooking' => Product::where('id',$cartContent->id)->first()->prebooking == 1 ? 1 : 0
                    ]
                );

                if (Product::where('id',$cartContent->id)->first()->prebooking == 1) {
                    $order->prebookings->create([
                        'order_id' => $order->id,
                        'product_id' => $cartContent->id,
                        'price' => ((($cartContent->qty * $cartContent->price)) * 10) / 100
                    ]);
                }
            }
        }
        if(session()->exists('coupon'))
        {
            session()->forget('coupon');
        }
        // Cart::destroy();
        return $order;
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

    public function getUserOrders( $id ) {
        $orders = Order::where('user_id', '=', $id)->orderBy('id','DESC')->paginate(10);
        return $orders;
    }

    public function getOrderedProducts(){
        $product=Producr::all();
    }

    public function getAll() {
        return $this->entity->all()->sortByDesc("id");
    }

    public function getById( $id ) {
        return $this->entity->findOrFail( $id );
    }

    public function create( array $attributes )
    {
        if ( isset( $attributes['customer'] ) && $this->checkUserAddress( [ 'user_id' => $attributes['customer'] ] ) ) {
            $address = $this->updateUserAddress( [
                'user_id'    => $attributes['customer'],
                'first_name' => $attributes['first_name'],
                'last_name'  => $attributes['last_name'],
                'email'      => $attributes['email'],
                'mobile'     => $attributes['mobile'],
                'phone'     => $attributes['phone'],
                'area'       => $attributes['area'],
                'district'   => $attributes['district'],
                'zone'       => $attributes['zone'],
                'country'    => isset($attributes['country']) ? $attributes['country'] : 'Nepal',
                'location_type'    => isset($attributes['location_type']) ? $attributes['location_type'] : 1,
            ] );

            $attributes['user_id']    = $address->user_id;
            $attributes['address_id'] = $address->id;
        } else {
            $address = $this->createUserAddress( [
                'first_name' => $attributes['first_name'],
                'last_name'  => $attributes['last_name'],
                'email'      => $attributes['email'],
                'mobile'     => $attributes['mobile'],
                'phone'     => $attributes['phone'],
                'area'       => $attributes['area'],
                'district'   => $attributes['district'],
                'zone'       => $attributes['zone'],
                'country'    => isset($attributes['country']) ? $attributes['country'] : 'Nepal',
                'location_type'    => isset($attributes['location_type']) ? $attributes['location_type'] : 1,
            ] );

            $attributes['address_id'] = $address->id;
        }

        $order = $this->entity->create( [
            'address_id'          => $attributes['address_id'],
            'user_id'             => isset( $attributes['user_id'] ) ? $attributes['user_id'] : null,
            'shipping_amount'     => $attributes['shipping_amount'],
            'order_status_id'     => $attributes['order_status'],
            'order_note'          => $attributes['order_note'],
            'order_date'          => Carbon::now(),
            'delivery_destination' =>null,
        ] );

        foreach ( $attributes['products'] as $orderProduct ) {
            DB::table( 'order_product' )->insert(
                [
                    'product_id' => $orderProduct['id'],
                    'order_id'   => $order->id,
                    'owner_id'   => Product::where('id',$orderProduct['id'])->first()->user_id,
                    'qty'        => $orderProduct['qty'],
                    'price'      => $orderProduct['price'],
                    'tax'        => $orderProduct['tax'],
                    'discount'   => $orderProduct['discount'],
                    'status'     => $attributes['order_status'],
                    'prebooking' => Product::where('id',$orderProduct['id'])->first()->prebooking == 1 ? 1 : 0
                ]
            );
        }
        // Cart::destroy();

        return $order;

    }

    public function update( $id, array $attributes )
    {
        // Update address
        $addressDetails = [
            'first_name' => $attributes['first_name'],
            'last_name'  => $attributes['last_name'],
            'email'      => $attributes['email'],
            'mobile'      => $attributes['mobile'],
            'phone'      => $attributes['phone'],
            'area'   => $attributes['area'],
            'district'=> $attributes['district'],
            'zone'       => $attributes['zone'],
            'location_type'   => isset($attributes['location_type']) ? $attributes['location_type'] : 1,
            'country'   => isset($attributes['country']) ? $attributes['country'] : 'Nepal',
        ];

        if ( isset( $attributes['address_id'] ) && $this->checkUserAddress( [ 'address_id' => $attributes['address_id'] ] ) ) {
            $address = ShippingAccount::findOrFail( $attributes['address_id'] );
            $address->update( $addressDetails );
        } else {
            $address = $this->createUserAddress( $addressDetails );
        }


        $attributes['user_id']    = $address->user_id;
        $attributes['address_id'] = $address->id;

        // Update order
        $order = $this->getById( $id );

        if(Cart::instance('prebooking')->count() > 0)
        {
            $order->update([
                'order_status_id' => 1,
                'delivery_destination_id' => null
            ]);

            foreach ( $order->orderProduct as $orderProduct ) {
                $orderProduct->prebooking = 0;
                $orderProduct->status = 1;
                $orderProduct->update();
            }
        }
        else
        {
            if($attributes['order_status'] == 2)
            {
                $date = Carbon::now()->format('Y-m-d');
                if($order->invoice_date == null)
                {
                    $order->update(['invoice_date' => $date]);
                }
            }

            /* decrease the quantity and update the Referral Amounts*/

            if ($attributes['order_status'] == 2 && $order->order_status_id == 1) {
                foreach ( $attributes['products'] as $orderProduct ) {
                    $pid = $orderProduct['id'];
                    $qty = $orderProduct['qty'];
                    $product = Product::where('id', $pid)->first();
                    $product->stock_quantity =(int)($product->stock_quantity) - (int)($qty);
                    $product->update();
                    if(isset($product->additionals) && $product->additionals->isNotEmpty())
                    {
                        $size = OrderProduct::where('order_id', $order->id)->where('product_id', $pid)->first()->size;
                        $additional = ProductAdditional::where('product_id', $pid)->where('size', $size)->first();
                        $additional->quantity = (int)($additional->quantity) - (int)($qty);
                        $additional->update();
                    }
                }
                $orders=OrderProduct::where('order_id',$id)->get();
                foreach($orders as $order_product){
                    $referUser= User::where('token',$order_product->referral)->first();
                    if($order_product->referral!='' && $referUser){
    //                    $referUser= User::where('token',$order_product->referral)->first();
                        $product= Product::where('id',$order_product->product_id)->first();
                        $referral= Referral::where('user_id',$referUser->id)->where('product_id',$product->id)->first();
                        $referral->buy_with_referral=$referral->buy_with_referral+$order_product->qty;
                        $referral->save();

                        $referInfo= new ReferralInfo();
                        $referInfo->referral_id=$referral->id;
                        $referInfo->order_id=$id;
                        $referInfo->user_id=$referUser->id;
                        $referInfo->referral_amount=($product->commission * 0.3 * $order_product->qty);
                        $referInfo->quantity=$order_product->qty;
                        $referInfo->total_amount=$product->sale_price;
                        $referInfo->save();

                        $userOrder= Order::find($id);
                        $userWallet=Wallet::where('user_id',$userOrder->user_id)->first();
                        if($userWallet){
                            $userWallet->amount= $userWallet->amount+ ($product->commission * 0.2 *$order_product->qty);
                            $userWallet->update();
                        }else{
                            $new_userwallet= new Wallet();
                            $new_userwallet->user_id=$userOrder->user_id;
                            $new_userwallet->amount=$product->commission*0.2 *$order_product->qty;
                            $new_userwallet->save();
                        }

                        $adminWallet=Wallet::where('user_id',auth()->id())->first();
                        if($adminWallet){
                            $adminWallet->amount= $adminWallet->amount+ ($product->commission * 0.5 *$order_product->qty);
                            $adminWallet->update();
                        }else{
                            $new_adminwallet= new Wallet();
                            $new_adminwallet->user_id=auth()->id();
                            $new_adminwallet->amount=$product->commission*0.5 *$order_product->qty;
                            $new_adminwallet->save();
                        }

                        $agentWallet=Wallet::where('user_id',$referUser->id)->first();
                        if($agentWallet){
                            $agentWallet->amount= $agentWallet->amount+($product->commission * 0.3 *$order_product->qty);
                            $agentWallet->update();
                        }
                        else{
                            $new_agentwallet= new Wallet();
                            $new_agentwallet->user_id= $referUser->id;
                            $new_agentwallet->amount= $product->commission*0.3 *$order_product->qty;
                            $new_agentwallet->save();
                        }

                    }
                }
            }
            if ($attributes['order_status'] == 4 && $order->order_status_id != 4) {
                $orders=OrderProduct::where('order_id',$id)->get();
                $total = 0;
                $userOrder= Order::find($id);
                foreach($orders as $order_product){
                    $actualprice = $order_product->qty * $order_product->price;
                    $subtotal = $actualprice + ($actualprice * $order_product->tax / 100);
                    if($order_product->coupon_id != null)
                    {
                        $coupon = Coupon::where('id', $order_product->coupon_id)->first();
                        $subtotal = $subtotal - $coupon->discount_value;
                    }
                    $total += $subtotal;
                }
                $wallet_amount = (($total + $userOrder->shipping_amount) * 5) / 100;
                $userWallet=Wallet::where('user_id',$userOrder->user_id)->first();
                if($userWallet){
                    $userWallet->amount = $userWallet->amount + $wallet_amount;
                    $userWallet->update();
                }else{
                    $new_userwallet = new Wallet();
                    $new_userwallet->user_id = $userOrder->user_id;
                    $new_userwallet->amount = $wallet_amount;
                    $new_userwallet->save();
                }
            }
            if ($attributes['order_status'] == 5 && $order->order_status_id != 1) {
                
                foreach ( $attributes['products'] as $orderProduct ) {
                    $pid=$orderProduct['id'];
                    $qty=$orderProduct['qty'];
                    $product = Product::where('id', $pid)->first();
                    $product->stock_quantity =(int)($product->stock_quantity) + (int)($qty);
                    $product->update();
                    if(isset($product->additionals) && $product->additionals->isNotEmpty())
                    {
                        // $size = OrderProduct::where('order_id', $order->id)->where('product_id', $pid)->first()->size;
                        // $additional = ProductAdditional::where('product_id', $pid)->where('size', $size)->first();
                        // $additional->quantity = (int)($additional->quantity) + (int)($qty);
                        // $additional->update();
                    }
                }
            }

            $order->update( [
                'address_id'          => $attributes['address_id'],
                'user_id'             => isset( $attributes['user_id'] ) ? $attributes['user_id'] : null,
                'order_status_id'     => $attributes['order_status'],
                'order_note'          => $attributes['order_note'],
                'order_date'          => $attributes['order_date'],
                'shipping_amount'     => $attributes['shipping_amount'],
                'tracking'            => $attributes['tracking'], 
                'delivery_destination_id' => null,
                
            ] );

            $orderedProducts = [];

            foreach ( $attributes['products'] as $orderProduct ) {
                $orderedProducts[ $orderProduct['id'] ] = [
                    'qty'      => $orderProduct['qty'],
                    'price'    => $orderProduct['price'],
                    'discount' => $orderProduct['discount'],
                    'tax'      => $orderProduct['tax'],
                    'status'   => $attributes['order_status'],
                    'prebooking' => Product::where('id',$orderProduct['id'])->first()->prebooking == 1 ? 1 : 0
                ];
            }
            
            $order->products()->sync( $orderedProducts );
        }
        return $order;
    }

    public function delete( $id ) {
        $order = Order::findOrFail($id);
        if ($order->orderProduct->isNotEmpty()) {
            foreach ($order->orderProduct as $product) {
                $order_return = OrderReturnRequestProduct::where('order_product_id', $product->id)->first();
                if(!empty($order_return)) {
                    $order_return_request = OrderReturnRequest::where('id', $order_return->order_return_request_id)->first();
                    $order_return_request->orderReturnMessage()->delete();
                    $order_return_request->orderReturnProducts()->delete();
                    $order_return_request->delete();
                }
            }
        }
        $order->orderProduct()->delete();
        $order->delete();
        return true;
    }

    protected function checkUserAddress( array $id ) {
        if ( ! isset( $id['address_id'] ) ) {
            return DB::table( 'shipping_accounts' )->where( 'user_id', '=', $id['user_id'] )->exists();
        }

        return DB::table( 'shipping_accounts' )->where( 'id', '=', $id['address_id'] )->exists();
    }

    protected function createUserAddress( array $attributes ) {
        return ShippingAccount::create( $attributes );
    }

    protected function updateUserAddress( array $attributes ) {
        $address = ShippingAccount::where( 'user_id', $attributes['user_id'] )->firstOrFail();
        $address->update( $attributes );

        return $address;
    }

    public function getOrdersJson( array $attributes ) {
        $orders = $this->getAll();

        return datatables( $orders )->toJson();
    }

    public function createFrontendOrder( array $attributes ) {
        // Update address
        $addressData = [
            'type'       => 'SHIPPING',
            'user_id'    => auth()->id(),
            'first_name' => $attributes['first_name'],
            'last_name'  => $attributes['last_name'],
            'email'  => $attributes['email'],
            'mobile'      => $attributes['mobile'],
            'phone'      => $attributes['phone'],
            'country' => isset( $attributes['country'] ) ? $attributes['country'] : 'Nepal',
            'area'   => $attributes['area'],
            'district'       => $attributes['district'],
            'zone'   => $attributes['zone'],
            'location_type'   => $attributes['location_type'],
        ];

        $address = Address::updateOrCreate( [ 'user_id' => auth()->id() ], $addressData );

        $attributes['billing_address_id']  = $address->id;
        $attributes['shipping_address_id'] = $address->id;

        $orderStatus = OrderStatus::whereIsDefault( 1 )->get()->first();

        // Create new order
        $order = $this->model->create( [
            'billing_address_id'  => $attributes['billing_address_id'],
            'shipping_address_id' => $attributes['shipping_address_id'],
            'user_id'             => auth()->id(),
            'enable_tax'          => getConfiguration('enable_tax'),
            'tax_percentage'      => (int) getConfiguration('tax_percentage'),
            'order_status_id'     => $orderStatus->id,
            'order_note'          => $attributes['order_note'],
            'order_date'          => Carbon::now()->toDateTimeString(),
        ] );

        // Attach products
        $cartContents = Cart::content();
        if ( $cartContents ) {


            foreach ($cartContents as $cartContent) {

                $order->products()->attach($cartContent->id,
                    [
                        'qty' => $cartContent->qty,
                        'price' => $cartContent->price,
                        'discount' => 0.00,

                        'tax_amount' => 0.00

                    ]
                );

            }
        }
        // Destory cart
        // Cart::destroy();

        return $order;
    }

    public function updateFrontendOrder( $id, array $attributes ) {

    }

}
