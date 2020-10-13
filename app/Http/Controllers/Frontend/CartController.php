<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Coupon;
use App\Model\CouponProduct;
use App\Model\Order;
use App\Model\Product;
use App\Model\ProductAdditional;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request)
    {

        $productId = $request->input('product');
        $quantity = $request->input('quantity');
        $size = $request->input('size');


        if (ProductAdditional::where('product_id', $productId)->pluck('size')->count() > 0) {
            if (!$size) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please Choose Size'
                ], 401);
            }
        }
        
        
        $product = Product::findorfail($productId);
        
        if($size){
            if(ProductAdditional::where('product_id', $productId)->pluck('size')->count() < $quantity){
                
                return response()->json([
                        'status' => 'error',
                        'message' => 'There is only '. ProductAdditional::where('product_id', $productId)->pluck('size')->count() . ' stock available for this product !!! '
                    ], 401);
            }
              
        }else{
            if($product->stock_quantity < $quantity){
                
                return response()->json([
                        'status' => 'error',
                        'message' => 'There is only '. $product->stock_quantity . ' stock available for this product !!! '
                    ], 401);
                
            }  
            
        }
        
        if($product->sale_price > 5){
            $price = $product->sale_price;
        }else{
            $price = $product->product_price;
            
        }
        
        
        $val = $request->text;

        if ($val != null) {
            $coupon = Coupon::where('code', $val)->first();
            if (!$coupon) {
                return response()->json(['status' => 'error', 'message' => 'Coupon Doesnot exist'], 401);
            } else {
                if (OrderProduct::where('coupon_id', $coupon->id)->get()->count() >= $coupon->uses_per_coupon) {
                    return response()->json(['status' => 'error', 'message' => 'Coupon Maximium Limit Exceeded'], 401);

                }
                if (Carbon::now()->toDateString() < $coupon->start_date) {
                    return response()->json(['status' => 'error', 'message' => 'Coupon Not Started'], 401);

                }
                if (Carbon::now()->toDateString() > $coupon->end_date) {
                    return response()->json(['status' => 'error', 'message' => 'Coupon Expired'], 401);

                }
                $coupon_product = CouponProduct::where('coupon_id', $coupon->id)->where('product_id', $productId)->first();
                if ($coupon_product) {
                    
                   
                    
                    Cart::add([
                        'id' => $product->id,
                        'name' => $product->name,
                        'qty' => $quantity,
                        'price' => $price,
                        'tax' => $product->tax,
                        'options' => [
                            'size' => $size,
                            'coupon' => $coupon->id
                        ]
                    ]);

                    if (!$request->ajax()) {
                        return redirect()->back()->with('success', 'Product added to cart!!');
                    }

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Product successfully added to cart.'
                    ], 200);

                } else {
                    return response()->json(['status' => 'error', 'message' => 'This Coupon does not applies to this Product'], 401);
                }
            }
        } else {
            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $quantity,
                'price' => $price,
                'tax' => $product->tax,
                'options' => [
                    'size' => $size
                ]
            ]);

            if (!$request->ajax()) {
                return redirect()->back()->with('success', 'Product added to cart!!');
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Product successfully added to cart.'
            ], 200);
        }
    }

    public function buyNow(Request $request)
    {

        $productId = $request->input('product');
        $quantity = $request->input('quantity');
        $size = $request->input('size');
        if (ProductAdditional::where('product_id', $productId)->pluck('size')->count() > 0) {
            if (!$size) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please Choose Size'
                ], 401);
            }
        }
        
        
        $product = Product::findorfail($productId);
        
        if($size){
            if(ProductAdditional::where('product_id', $productId)->pluck('size')->count() < $quantity){
                
                return response()->json([
                        'status' => 'error',
                        'message' => 'There is only '. ProductAdditional::where('product_id', $productId)->pluck('size')->count() . ' stock available for this product !!! '
                    ], 401);
            }
              
        }else{
            if($product->stock_quantity < $quantity){
                
                return response()->json([
                        'status' => 'error',
                        'message' => 'There is only '. $product->stock_quantity . ' stock available for this product !!! '
                    ], 401);
                
            }  
            
        }
        
        
         if($product->sale_price > 5){
            $price = $product->sale_price;
        }else{
            $price = $product->product_price;
            
        }
        
        
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $quantity,
            'price' => $price,
            'tax' => $product->tax,
            'options' => [
                'size' => $size,
                // 'colour' => $colour,
            ]
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product successfully added to cart.'
        ], 200);
    }

    public function buyPrebookingItem(Request $request)
    {

        $productId = $request->input('product');
        $orderId = $request->input('order');
        $quantity = $request->input('quantity');
        // $size = $request->input('size');
        // if (ProductAdditional::where('product_id', $productId)->pluck('size')->count() > 0) {
        //     if (!$size) {
        //         return response()->json([
        //             'status' => 'error',
        //             'message' => 'Please Choose Size'
        //         ], 401);
        //     }
        // }
        $product = Product::findorfail($productId);
        $order = Order::findOrFail($orderId);
        $price = $product->sale_price - $order->prebookings->price;
        
        Cart::instance('prebooking')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $quantity,
            'price' => $price,
            'tax' => $product->tax,
            'options' => [
                'order' => $order->id,
            ]
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product successfully added to cart.'
        ], 200);
    }

    public function index(Request $request)
    {
        return view('front.cart.index');
    }

    public function destroy($rowId)
    {
        Cart::remove($rowId);
        return response()->json([
            'status' => 'success',
            'message' => 'Product successfully removed from cart.'
        ], 200);
    }


    public function update(Request $request)
    {

        $rowId = $request['rowId'];
        $quantity = $request['quantity'];
        Cart::update($rowId, $quantity);

        return response()->json([
            'status' => 'success',
            'message' => 'Cart successfully updated.'
        ], 200);
    }


    public function getMiniCart()
    {
        $cartContents = Cart::content();
        $cartTotal = Cart::total();
        return view('front.cart.cart-update', compact('cartContents', 'cartTotal'));
    }

    public function getMobileCart(){
       return  response()->json(Cart::count(),200);

    }


}
