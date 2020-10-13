<?php

namespace App\Http\Controllers\Vendor;

use App\Model\Order;
use App\Model\OrderProduct;
use App\Model\OrderReturnRequest;
use App\Model\OrderReturnStatus;
use App\Repositories\Contracts\OrderRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private $order;

    public function __construct( OrderRepository $order ) {
        $this->order = $order;
    }

    public function index() {
        $orders = Order::whereHas('orderProduct',function ($query) {
            $query->where('owner_id', auth()->id());
        })->get();
        $totalOrders = $orders->count();
        $orderPending = $orders->where('order_status_id', 1)->count();
        $orderCancled = $orders->where('order_status_id', 5)->count();
        $orderReturn = $orders->where('order_status_id', 9)->count();
        $orderExchange = $orders->where('order_status_id', 12)->count();
        $orderDispatched = $orders->where('order_status_id', 7)->count();


//        $ordersCount = Order::whereHas('orderProduct',function ($query) {
//            $query->where('owner_id', auth()->id());
//        })->count();

        return view( 'merchant.order.index', compact( 'totalOrders', 'orderPending', 'orderCancled', 'orderReturn', 'orderExchange', 'orderDispatched' ) );
    }

    public function getOrdersJson( $status )
    {
//        dd($status);

        $vendor_orders = Order::whereHas('orderProduct',function ($query) {
                $query->where('owner_id', auth()->id());
            });

        switch ($status) {
            case 'pending':
                $orders = $vendor_orders->where('order_status_id', 1)->orderBy('id', 'desc')->get();
                break;
            case 'canceled':
                $orders = $vendor_orders->where('order_status_id', 5)->orderBy('id', 'desc')->get();
                break;
            case 'return':
                $orders = $vendor_orders->where('order_status_id', 9)->orderBy('id', 'desc')->get();
//                dd('test');
                break;
            case 'exchange':
                $orders = $vendor_orders->where('order_status_id', 12)->orderBy('id', 'desc')->get();
                break;
            case 'dispatched':
                $orders = $vendor_orders->where('order_status_id', 7)->orderBy('id', 'desc')->get();
                break;
            case 'all':
                if (Auth::user()->hasRole('delivery')) {
                    $destination = DeliveryBoy::where('user_id', auth()->id())->first();
                    $orders = $vendor_orders->where('delivery_destination_id', $destination->delivery_destination_id)->orderBy('id', 'desc')->get();
                } else {
                    $orders = $vendor_orders->orderBy('id', 'desc')->get();
                }
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
                'address_zone' => isset($orderValue->shipping_address->zone) ? $orderValue->shipping_address->zone : null,
                'address_district' => isset($orderValue->shipping_address->district) ? $orderValue->shipping_address->district : null,
                'address_area' => isset($orderValue->shipping_address->area) ? $orderValue->shipping_address->area : null,
                'address_phone' => isset($orderValue->shipping_address->phone) ? $orderValue->shipping_address->phone : null,
                'address_mobile' => isset($orderValue->shipping_address->mobile) ? $orderValue->shipping_address->mobile : null,
            ];


            $priceTotal = 0;

            foreach ($orderValue->products->where('user_id', auth()->id()) as $productKey => $productValue) {
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

            
            $ordersArray[ $orderKey ]['price_total'] = number_format($priceTotal, 2);

        }

        return datatables($ordersArray)->toJson();

    }

    public function getOrderReturns()
    {
        $order_returns = OrderReturnRequest::all();
        return view('merchant.order.order_return', compact('order_returns'));
    }

    public function getOrderReturnJson( Request $request )
    {
        $order_returns = OrderReturnRequest::whereHas('orderReturnProducts',function ($query) {
            $query->whereHas('order_product',function ($query) {
            $query->where('owner_id', auth()->id());
            });
        })->get();

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
                'address_zone' => isset($orderReturnValue->users->addresses->first()->zone) ? $orderReturnValue->users->addresses->first()->zone : null,
                'address_district' => isset($orderReturnValue->users->addresses->first()->district) ? $orderReturnValue->users->addresses->first()->district : null,
                'address_location_type' => isset($orderReturnValue->users->addresses->first()->location_type) ? $orderReturnValue->users->addresses->first()->location_type : null,
                'address_area' => isset($orderReturnValue->users->addresses->first()->area) ? $orderReturnValue->users->addresses->first()->area : null,
                'address_country_id' => isset($orderReturnValue->users->addresses->first()->country) ? $orderReturnValue->users->addresses->first()->country : null,
                'address_mobile' => isset($orderReturnValue->users->addresses->first()->mobile) ? $orderReturnValue->users->addresses->first()->mobile : null,
                'address_phone' => isset($orderReturnValue->users->addresses->first()->phone) ? $orderReturnValue->users->addresses->first()->phone : null,
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

    public function editOrderReturn($id)
    {
        $order_return = OrderReturnRequest::findOrFail($id);

        $orderReturnStatuses = array( '' => 'Select Order Status' ) + OrderReturnStatus::pluck( 'name', 'id' )->toArray();

        return view('merchant.order.edit_order_return', compact('order_return', 'orderReturnStatuses'));
    }

    public function updateOrderReturn(Request $request)
    {
        $this->validate($request, [
            'order_return_status' => 'required',
            'return_option' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'zone' => 'required',
            'district' => 'required',
            'area' => 'required',
            'mobile' => 'required',
            'qty' => 'required|numeric',
        ]);

        $order_return = OrderReturnRequest::findOrFail($request->id);
        $order_return->user_option = $request->return_option;
        $order_return->status_id = $request->order_return_status;
        $order_return->users->addresses()->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile' => $request->mobile,
            'zone' => $request->zone,
            'district' => $request->district,
            'area' => $request->area,
            'phone' => $request->phone
        ]);

        $order_return->users()->update([
            'email' => $request->email,
//            'user_name' => $request->customer
        ]);

        $order_return->orderReturnProducts()->update([
            'qty' => $request->qty
        ]);

        $order_return->update();

        return redirect()->back()->with('success', 'Order Return Successfully Updated.');
    }
}
