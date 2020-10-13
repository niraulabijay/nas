<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Model\Category;
use App\Model\Deal;
use App\Model\Order;
use App\Model\OrderReturnRequest;
use App\Model\Product;
use App\Model\ReviewProduct;
use App\Model\Vendor;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getProducts($name, Request $request)
    {
    	switch ($name) {
			case 'all':
                $vendor = User::findorfail(auth()->id());
                $name = $request['name'];
                $productsCount = Product::where('user_id', $vendor->id)->whereNotIn('status',['deleted'])->count();
                break;
			case 'approved':
    			$vendor = User::findorfail(auth()->id());
    			$name = $request['name'];
		    	$productsCount = Product::where('user_id', $vendor->id)->where('approved',1)->whereNotIn('status',['deleted'])->count();
    			break;
			case 'pending':
    			$vendor = User::findorfail(auth()->id());
    			$name = $request['name'];
		    	$productsCount = Product::where('user_id', $vendor->id)->where('approved',0)->whereNotIn('status',['deleted'])->count();
    			break;
			case 'reviews':
    			$vendor = User::findorfail(auth()->id());
    			$name = $request['name'];
		    	$productsCount = ReviewProduct::whereHas('products', function ($query) use ($vendor) {
                    $query->where('user_id', $vendor->id);
                    $query->whereNotIn('status',['deleted']);
                })->count();
    			break;
    		default:

    			break;
    	}
    	return view('merchant.single', compact('productsCount','name'));
    }
    public function getProductsJson(Request $request)
    {
		$name  = $request->input( 'name' );
    	switch ($name) {
			case 'all':
    			$vendor = User::findorfail(auth()->id());
		    	$products = Product::where('user_id', $vendor->id)->whereNotIn('status',['deleted'])->get();
    			break;
			case 'approved':
    			$vendor = User::findorfail(auth()->id());
		    	$products = Product::where('user_id', $vendor->id)->where('approved',1)->whereNotIn('status',['deleted'])->get();
    			break;
			case 'pending':
    			$vendor = User::findorfail(auth()->id());
		    	$products = Product::where('user_id', $vendor->id)->where('approved',0)->whereNotIn('status',['deleted'])->get();
    			break;
			case 'reviews':
    			$vendor = User::findorfail(auth()->id());
		    	$products = ReviewProduct::whereHas('products', function ($query) use ($vendor) {
                    $query->where('user_id', $vendor->id);
                    $query->whereNotIn('status',['deleted']);
                })->get();
    			break;
    		default:

    			break;
    	}
    	return datatables($products)->toJson();
    }
    public function getOrderStat($name, Request $request)
    {
        switch ($name) {
            case 'all':
                $vendor = User::findorfail(auth()->id());
                $name = $request['name'];
                $ordersCount = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id);
                })->count();
                break;
            case 'approved':
                $vendor = User::findorfail(auth()->id());
                $name = $request['name'];
                $ordersCount = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 2);
                })->count();
                break;
            case 'pending':
                $vendor = User::findorfail(auth()->id());
                $name = $request['name'];
                $ordersCount = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 1);
                })->count();
                break;
            case 'received':
                $vendor = User::findorfail(auth()->id());
                $name = $request['name'];
                $ordersCount = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 3);
                })->count();
                break;
            case 'delivered':
                $vendor = User::findorfail(auth()->id());
                $name = $request['name'];
                $ordersCount = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 4);
                })->count();
                break;
            case 'cancelled':
                $vendor = User::findorfail(auth()->id());
                $name = $request['name'];
                $ordersCount = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 5);
                })->count();
                break;
            case 'review':
                $vendor = User::findorfail(auth()->id());
                $name = $request['name'];
                $ordersCount = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 6);
                })->count();
                break;
            default:

                break;
        }

        return view('merchant.order_stat', compact('ordersCount','name'));
    }
    public function getOrderStatJson(Request $request)
    {
        $name  = $request->input( 'name' );
        switch ($name) {
            case 'all':
                $vendor = User::findorfail(auth()->id());
                $orders = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id);
                })->get();
                break;
            case 'approved':
                $vendor = User::findorfail(auth()->id());
                $orders = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 2);
                })->get();
                break;
            case 'pending':
                $vendor = User::findorfail(auth()->id());
                $orders = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 1);
                })->get();
                break;
            case 'received':
                $vendor = User::findorfail(auth()->id());
                $orders = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 3);
                })->get();
                break;
            case 'delivered':
                $vendor = User::findorfail(auth()->id());
                $orders = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 4);
                })->get();
                break;
            case 'cancelled':
                $vendor = User::findorfail(auth()->id());
                $orders = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 5);
                })->get();
                break;
            case 'review':
                $vendor = User::findorfail(auth()->id());
                $orders = Order::whereHas('orderProduct',function ($query) use ($vendor) {
                    $query->where('owner_id', $vendor->id)
                        ->where('status', 6);
                })->get();
                break;
            default:

                break;
        }

        if (null === $orders) {
            return datatables($orders)->toJson();
        }

        $ordersArray = [];
        foreach ($orders as $orderKey => $orderValue) {
            $ordersArray[$orderKey]['id'] = $orderValue->id;
            $ordersArray[$orderKey]['order_status'] = $orderValue->orderStatus->name;
            $ordersArray[$orderKey]['order_date'] = Carbon::parse($orderValue->order_date)->format('d/m/Y');
            $ordersArray[$orderKey]['userOrder'] = [
                'order_id' => $orderValue->id,
                'user_id' => $orderValue->user_id,
                'user_first_name' => isset($orderValue->user->first_name) ? $orderValue->user->user_name : '',
                'user_email' => isset($orderValue->user->email) ? $orderValue->user->email : '',
            ];

            $ordersArray[$orderKey]['address'] = [
                'address_first_name' => isset($orderValue->shipping_address->first_name) ? $orderValue->shipping_address->first_name : null,
                'address_last_name' => isset($orderValue->shipping_address->last_name) ? $orderValue->shipping_address->last_name : null,
                'address_landmark' => isset($orderValue->shipping_address->landmark) ? $orderValue->shipping_address->landmark : null,
                'address_street_name' => isset($orderValue->shipping_address->street_name) ? $orderValue->shipping_address->street_name : null,
                'address_city' => isset($orderValue->shipping_address->city) ? $orderValue->shipping_address->city : null,
                'address_landline' => isset($orderValue->shipping_address->landline) ? $orderValue->shipping_address->landline : null,
                'address_phone' => isset($orderValue->shipping_address->mobile) ? $orderValue->shipping_address->mobile : null,
            ];


            $priceTotal = 0;

            foreach ($orderValue->products as $productKey => $productValue) {
                $ordersArray[$orderKey]['products'][$productKey] = [
                    'name' => $productValue->name,
                    'product_id' => $productValue->pivot->product_id,
                    'order_id' => $productValue->pivot->order_id,
                    'qty' => $productValue->pivot->qty,
                    'price' => $productValue->pivot->price,
                    'discount' => $productValue->pivot->discount,
                    'tax_amount' => $productValue->pivot->tax_amount,
                ];

                $actualPrice = $productValue->pivot->qty * $productValue->pivot->price;
                $actualPrice += $actualPrice * ($productValue->pivot->tax / 100);
                $dis = $productValue->pivot->discount;
                $priceTotal += ($actualPrice - $dis);
            }

            if ($orderValue->shipping_amount) {
                $priceTotal += $orderValue->shipping_amount;
            }

            $ordersArray[ $orderKey ]['price_total'] = number_format($priceTotal, 2);


        }

        return datatables($ordersArray)->toJson();
    }
    public function getOrderReturnStat($name, Request $request)
    {
        switch ($name) {
            case 'all':
                $vendor = User::findorfail(auth()->id());
                $name = $request['name'];
                $orderReturnsCount = OrderReturnRequest::whereHas('orderReturnProducts',function ($query) use ($vendor) {
                    $query->whereHas('order_product',function ($query) use ($vendor) {
                        $query->where('owner_id', $vendor->id);
                    });
                })->count();
                break;
            case 'approved':
                $vendor = User::findorfail(auth()->id());
                $name = $request['name'];
                $orderReturnsCount = OrderReturnRequest::where('status_id', 2)->whereHas('orderReturnProducts',function ($query) use ($vendor) {
                    $query->whereHas('order_product',function ($query) use ($vendor) {
                        $query->where('owner_id', $vendor->id);
                    });
                })->count();
                break;
            case 'pending':
                $vendor = User::findorfail(auth()->id());
                $name = $request['name'];
                $orderReturnsCount = OrderReturnRequest::where('status_id', 1)->whereHas('orderReturnProducts',function ($query) use ($vendor) {
                    $query->whereHas('order_product',function ($query) use ($vendor) {
                        $query->where('owner_id', $vendor->id);
                    });
                })->count();
                break;
            default:

                break;
        }

        return view('merchant.order_return_stat', compact('orderReturnsCount','name'));
    }
    public function getOrderReturnStatJson(Request $request)
    {
        $name  = $request->input( 'name' );
        switch ($name) {
            case 'all':
                $vendor = User::findorfail(auth()->id());
                $order_returns = OrderReturnRequest::whereHas('orderReturnProducts',function ($query) use ($vendor) {
                    $query->whereHas('order_product',function ($query) use ($vendor) {
                        $query->where('owner_id', $vendor->id);
                    });
                })->get();
                break;
            case 'approved':
                $vendor = User::findorfail(auth()->id());
                $order_returns = OrderReturnRequest::where('status_id', 2)->whereHas('orderReturnProducts',function ($query) use ($vendor) {
                    $query->whereHas('order_product',function ($query) use ($vendor) {
                        $query->where('owner_id', $vendor->id);
                    });
                })->get();
                break;
            case 'pending':
                $vendor = User::findorfail(auth()->id());
                $order_returns = OrderReturnRequest::where('status_id', 1)->whereHas('orderReturnProducts',function ($query) use ($vendor) {
                    $query->whereHas('order_product',function ($query) use ($vendor) {
                        $query->where('owner_id', $vendor->id);
                    });
                })->get();
                break;
            default:

                break;
        }

        $orderReturnArray = [];

        foreach ( $order_returns as $orderReturnKey => $orderReturnValue ) {
            $orderReturnArray[$orderReturnKey]['id'] = $orderReturnValue->id;

            $orderReturnArray[$orderReturnKey]['userOrder'] = [
                'order_id' => $orderReturnValue->orderReturnProducts->first()->order_product->order_id,
                'user_id' => $orderReturnValue->user_id,
                'username' => isset($orderReturnValue->users->user_name) ? $orderReturnValue->users->user_name : '',
                'email' => isset($orderReturnValue->users->email) ? $orderReturnValue->users->email : ''
            ];

            $orderReturnArray[$orderReturnKey]['order_return_status'] = [
                'status' => $orderReturnValue->orderReturnStatus->name,
                'class' => getOrderReturnStatusClass($orderReturnValue->orderReturnStatus->name)
            ];
            $orderReturnArray[$orderReturnKey]['order_date'] = Carbon::parse($orderReturnValue->created_at)->format('d/m/Y');

            $orderReturnArray[$orderReturnKey]['address'] = [
                'address_first_name' => isset($orderReturnValue->users->addresses->first()->first_name) ? $orderReturnValue->users->addresses->first()->first_name : null,
                'address_last_name' => isset($orderReturnValue->users->addresses->first()->last_name) ? $orderReturnValue->users->addresses->first()->last_name : null,
                'address_street_name' => isset($orderReturnValue->users->addresses->first()->street_name) ? $orderReturnValue->users->addresses->first()->street_name : null,
                'address_landmark' => isset($orderReturnValue->users->addresses->first()->landmark) ? $orderReturnValue->users->addresses->first()->landmark : null,
                'address_location_type' => isset($orderReturnValue->users->addresses->first()->location_type) ? $orderReturnValue->users->addresses->first()->location_type : null,
                'address_city' => isset($orderReturnValue->users->addresses->first()->city) ? $orderReturnValue->users->addresses->first()->city : null,
                'address_country_id' => isset($orderReturnValue->users->addresses->first()->country) ? $orderReturnValue->users->addresses->first()->country : null,
                'address_mobile' => isset($orderReturnValue->users->addresses->first()->mobile) ? $orderReturnValue->users->addresses->first()->mobile : null,
                'address_landline' => isset($orderReturnValue->users->addresses->first()->landline) ? $orderReturnValue->users->addresses->first()->landline : null,
            ];


            $orderReturnArray[ $orderReturnKey ]['products'] = [
                'name' => $orderReturnValue->orderReturnProducts->first()->order_product->products->name,
                'product_id'   => $orderReturnValue->orderReturnProducts->first()->order_product->product_id,
                'order_id'     => $orderReturnValue->orderReturnProducts->first()->order_product->order_id,
                'qty'          => $orderReturnValue->orderReturnProducts->first()->qty,
                'price'        => $orderReturnValue->orderReturnProducts->first()->order_product->price,
            ];

        }

        return datatables( $orderReturnArray )->toJson();
    }
    public function getBankInfo(){
        return view('admin.bank_info.index');
    }
}
