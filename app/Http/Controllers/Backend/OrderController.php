<?php

namespace App\Http\Controllers\Backend;

use App\DeliveryCharge;
use App\Exports\OrdersExport;
use App\Exports\SelectedOrderExport;
use App\Http\Controllers\Controller;
use App\Model\DeliveryBoy;
use App\Model\DeliveryDestination;
use App\Model\Order;
use App\Model\OrderProduct;
use App\Model\OrderReturnRequest;
use App\Model\OrderReturnStatus;
use App\Model\OrderStatus;
use App\Model\Product;
use App\Model\PaymentMethod;
use App\Model\Role;
use App\Model\ShippingAmount;
use App\Model\ShippingAccount;
use App\Notifications\OrderUpdated as NotifyOrderUpdated;
use App\Repositories\Contracts\OrderRepository;
use App\User;
use Carbon\Carbon;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use CodeItNow\BarcodeBundle\Utils\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{

    private $order;

    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
    }
    
    
    public function orderList(Request $request){

//        dd($request);
        $ordersCount = $this->order->getAll()->count();
        $orderPendingCount = Order::where('order_status_id', 1)->count();
        $orderApprovedCount = Order::where('order_status_id', 2)->count();
        $orderReceivedCount = Order::where('order_status_id', 3)->count();
        $orderDeliveredCount = Order::where('order_status_id', 4)->count();
        $orderCancelledCount = Order::where('order_status_id', 5)->count();
        $orderReviewCount = Order::where('order_status_id', 6)->count();
        $orderDispatchedCount = Order::where('order_status_id', 7)->count();
        $orderCompletedCount = Order::where('order_status_id', 8)->count();
        $orderPackCount = Order::where('order_status_id', 10)->count();
        $orderUnpackCount = Order::where('order_status_id', 11)->count();
        $orderStatuses = OrderStatus::all();
        $zones = DeliveryCharge::where('parent_id', 0)->get();
        $districts = DeliveryCharge::whereIn('parent_id', $zones->pluck('id'))->get();
        $payments = PaymentMethod::all();

        $order_status = orderbyStatus($request->status);




//        if have ajax request
        if($request->ajax()){
//            if order status is all
            if($order_status != null){
                $orders = Order::where('order_status_id', $order_status)->select('id', 'order_date')->select('id', 'order_date', 'address_id', 'payment_method_id', 'code')->get();

//                if order status has parameter
            }else{

                $orders = Order::select('id', 'order_date', 'address_id', 'payment_method_id', 'code')->get();
//                dd($orders);
            }
            foreach ($orders as $order){
                $order->filterdate = $order->order_date->format('Y-m-d');
            }

//            dd($orders);
             if($request['query']){
                $orderCode =$orders->where('code', $request['query']);
                if($orderCode->isEmpty()){
                    $address = ShippingAccount::where( 'mobile', 'like', '%' . $request['query'] . '%' )
                        ->orWhere('first_name', 'like', '%' . $request['query'] . '%' )
                        ->orWhere('last_name', 'like', '%' . $request['query'] . '%' )->get();
                    if($address->isEmpty()){
                        $orders = $orders->sortByDesc('id');
                    }else{
                        $orders = $orders->whereIn('address_id', $address->pluck('id'));

                    }
                }else{
                    $orders = $orders->where('code', $request['query']);
                }


            }
            if ($request['district']){
                $districts = explode(",",$request['district']);
                $address = ShippingAccount::whereIn('district', $districts)->get();
                $orders = $orders->whereIn('address_id', $address->pluck('id'));
            }
            if ($request['payment']){
                $orders = $orders->where('payment_method_id', $request['payment']);
            }

            if ($request['start_date'] && $request['end_date']){
                $from = $request['start_date'];
                $to = $request['end_date'];
                $orders = $orders->where('filterdate', '>=', $from)->where('filterdate', '<=', $to);
            }

//            dd($orders);
            $orders = Order::whereIn('id', $orders->pluck('id'))->orderBy('id', 'desc')->paginate(50);

//            if not have ajax request
        }else{
            if($order_status != null){
                $orders = Order::where('order_status_id', $order_status)->orderBy('id', 'desc')->paginate(50);
            }else{
                $orders = Order::orderBy('id', 'desc')->paginate(50);
            }

        }




//

//        dd($orders);
//        $ordersArray = [];
        foreach ($orders as $orderKey => $orderValue) {
            if(empty($orderValue->prebookings)) {
                $ordersArray[$orderKey]['id'] = $orderValue->id;
                $ordersArray[$orderKey]['order_no'] = $orderValue->code;
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
                    'address_area' => isset($orderValue->shipping_address->area) ? $orderValue->shipping_address->area : null,
                    'address_district' => isset($orderValue->shipping_address->district) ? $orderValue->shipping_address->district : null,
                    'address_zone' => isset($orderValue->shipping_address->zone) ? $orderValue->shipping_address->zone : null,
                    'address_mobile' => isset($orderValue->shipping_address->mobile) ? $orderValue->shipping_address->mobile : null,
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
                        'tax_amount' => $productValue->pivot->tax,
                    ];

                    $actualPrice = $productValue->pivot->qty * $productValue->pivot->price;
                    $actualPrice += $actualPrice * ($productValue->pivot->tax / 100);
                    $dis = $productValue->pivot->discount;
                    $priceTotal += ($actualPrice - $dis);
                }

                if ($orderValue->shipping_amount) {
                    $priceTotal += $orderValue->shipping_amount;
                }

                $ordersArray[$orderKey]['payment'] = isset($orderValue->payment->name) ? $orderValue->payment->name : 'COD';

                $ordersArray[$orderKey]['price_total'] = number_format($priceTotal, 2);
            }
        }

//            dd($ordersArray);


        if($request->ajax()){
            if($orders->isEmpty()){
                return  "No data";
            }
            return view('admin.orders.paginate', compact('ordersArray', 'orders'));
        }
        return view('admin.orders.orderlist', compact('ordersArray', 'orders', 'orderStatuses', 'ordersCount', 'orderPackCount','orderUnpackCount', 'orderPendingCount', 'orderApprovedCount', 'orderReceivedCount', 'orderDeliveredCount', 'orderCancelledCount', 'orderReviewCount', 'prebookings', 'orderDispatchedCount', 'orderCompletedCount', 'districts', 'payments'));
    }
    

    public function index()
    {
        $ordersCount = $this->order->getAll()->count();
        $orderPendingCount = Order::where('order_status_id', 1)->count();
        $orderApprovedCount = Order::where('order_status_id', 2)->count();
        $orderReceivedCount = Order::where('order_status_id', 3)->count();
        $orderDeliveredCount = Order::where('order_status_id', 4)->count();
        $orderCancelledCount = Order::where('order_status_id', 5)->count();
        $orderReviewCount = Order::where('order_status_id', 6)->count();
        $orderDispatchedCount = Order::where('order_status_id', 7)->count();
        $orderCompletedCount = Order::where('order_status_id', 8)->count();
        $orderPackCount = Order::where('order_status_id', 10)->count();
        $orderUnpackCount = Order::where('order_status_id', 11)->count();
        $orderStatuses = OrderStatus::all();

        $prebookings = Order::whereHas('prebookings')->with('prebookings')->orderBy('id', 'desc')->get();

        // if ($ordersCount == 0) {
        //     return view('admin.orders.index2', compact('ordersCount'));
        // } else
            return view('admin.orders.index', compact('orderStatuses','ordersCount','orderPackCount','orderUnpackCount', 'orderPendingCount', 'orderApprovedCount', 'orderReceivedCount', 'orderDeliveredCount', 'orderCancelledCount', 'orderReviewCount', 'prebookings', 'orderDispatchedCount', 'orderCompletedCount'));
    }
    
    

    public function create()
    {
        // $orderStatuses = array( '' => 'Select Order Status' ) + OrderStatus::pluck( 'name', 'id' )->toArray();
        $orderStatuses = OrderStatus::all();
        $shipping_amounts = array('' => 'Select Shipping Amount') + ShippingAmount::pluck('place', 'amount')->toArray();
        $delivery_destinations = DeliveryDestination::pluck('name', 'id')->toArray();
        return view('admin.orders.create', compact('orderStatuses', 'shipping_amounts', 'delivery_destinations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_status' => 'required',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email',
            'products' => 'required|array',
            // 'delivery_destination' => 'required'
        ]);

        try {
            $this->order->create($request->all());
        } catch (Exception $e) {
            throw new Exception('Error in saving order: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Order successfully created!'
        ]);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        
        
        $order = $this->order->getById($id);
        $products = $this->getOrderedProducts($id);
        
        $userDetails = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('shipping_accounts', 'orders.address_id', '=', 'shipping_accounts.id')
            ->where('orders.id', '=', $order->id)
            ->select('users.id as user_id', 'users.user_name as user_first_name', 'shipping_accounts.*')
            ->first();

        // $orderStatuses = array( '' => 'Select Order Status' ) + OrderStatus::pluck( 'name', 'id' )->toArray();
        $orderStatuses = OrderStatus::all();
        $shipping_amounts = array('' => 'Select Shipping Amount') + ShippingAmount::pluck('place', 'amount')->toArray();
        $delivery_destinations = DeliveryDestination::pluck('name', 'id')->toArray();
        
        
        $requestedUser = ShippingAccount::where('mobile', $userDetails->mobile)->get()->pluck('id');
        $checkOrders = Order::whereIn('address_id', $requestedUser)->get()->where( 'id','!=', $order->id )->pluck('id');
        $userPreviousOrders = OrderProduct::whereIn('order_id', $checkOrders)->get();
        
        // dd($orderStatuses);

        return view('admin.orders.edit', compact('order', 'products', 'userDetails', 'orderStatuses', 'shipping_amounts', 'delivery_destinations', 'userPreviousOrders'));
    }

    public function update(Request $request, $id)
    {
        
        
        $request->validate([
            'order_status' => 'required',
            'order_date' => 'required',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required',
            'products' => 'required|array',
            // 'delivery_destination' => 'required'
        ]);
        try {
            $order = $this->order->update($id, $request->all());
        } catch (Exception $e) {
            throw new Exception('Error in updating order: ' . $e->getMessage());
        }
        $data = [
            'id' => Order::where('id', $id)->first()->code,
            'value' => ucfirst(OrderStatus::where('id', $request->order_status)->first()->name)
        ];
        $user = Order::where('id', $id)->first()->user_id;
        $email = User::findorfail($user)->email;

        User::findorfail($user)->notify(new NotifyOrderUpdated($order));
        \Mail::to($email)->send(new \App\Mail\OrderUpdated($data));

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        try {
            $this->order->delete($id);
        } catch (Exception $e) {
            throw new Exception('Error in deleting order: ' . $e->getMessage());
        }
        return redirect()->back()->with('success', 'Order successfully deleted!');
    }

    public function addProduct(Request $request)
    {
        $productsId = explode(',', $request->input('products'));

        $products = Product::whereIn('products.id', $productsId)->get();
        return view('admin.orders.products', compact('products'));
    }

    public function updateProduct(Request $request)
    {
        $product = Product::findOrFail($request->input('product'));

        $quantity = $request->input('quantity');
        $discount = $request->input('discount');
        $tax = $request->input('tax');

        $price = $product->sale_price;
        $actualPrice = (float)$price * $quantity;

        $priceTotal = (($actualPrice * $tax) / 100) + $actualPrice;
        $priceTotal = $priceTotal - $discount;

        $product->price = $price;
        $product->price_total = $priceTotal;
        $product->quantity = $quantity;
        $product->discount = $discount;
        $product->tax = $tax;

        return view('admin.orders.update-product', compact('product', 'priceTotal'));
    }

    public function updateProductSummary(Request $request)
    {

        $priceTotal = (float)0.00;
        $taxAmount = (float)0.00;

        if ($request->has('products')) {
            foreach ($request->input('products') as $product) {
                $actualPrice = $product['price'] * $product['quantity'];
                $taxAmount += $actualPrice * ($product['tax'] / 100);
                $actualPrice += $actualPrice * ($product['tax'] / 100);

                $discountAmount = $product['discount'];
                $priceTotal = $priceTotal + ($actualPrice - $discountAmount);
            }
            $shipping_amount = $product['shipping_amount'];
            $priceTotal = $priceTotal + $shipping_amount;

        }

        if ($request->has('order')) {
            $order = $this->order->getById($request->input('order'));
//            $tax = 0;

//            if ($order->orderProduct->first()->tax) {
//                $tax = ($priceTotal * $order->orderProduct->first()->tax) / 100;
//            }
//            $priceTotal += $tax;

            return view('admin.orders.order-summary', compact('order', 'priceTotal', 'shipping_amount', 'taxAmount'));
        }

        return view('admin.orders.order-summary', compact('priceTotal', 'shipping_amount', 'taxAmount'));
    }

    public function updateUserAddress(Request $request)
    {
        $address = DB::table('addresses')
            ->where('user_id', '=', $request->input('user'))
            ->whereNotNull('user_id')
            ->first();
        $countries = Country::pluck('name', 'id')->toArray();
        $states = array('' => 'Select a state') + State::pluck('name', 'id')->toArray();

        return view('admin.orders.update-address', compact('address', 'countries', 'states'));
    }

    public function getOrderedProducts($id)
    {
        $order = $this->order->getById($id);

        foreach ($products = $order->products as $product) {
            $quantity = $product->pivot->qty;
            $discount = $product->pivot->discount;

            $product->price = $product->pivot->price;
            $product->quantity = $quantity;
            $product->discount = $discount;
            $product->orderproduct_id = $product->pivot->id;
            $product->orderproduct_status = $product->pivot->status;

        }

        return $products;
    }


    public function generateInvoice($id)
    {
        $order = $this->order->getById($id);


        $userDetails = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('shipping_accounts', 'orders.address_id', '=', 'shipping_accounts.id')
            ->where('orders.id', '=', $order->id)
            ->select('users.id as user_id', 'users.first_name as user_first_name', 'users.last_name as user_last_name', 'shipping_accounts.*')
            ->first();

        return view('admin.orders.invoice', compact('order', 'userDetails', 'state'));
    }
    
     public function orderProductReturn($id)

    {


        $orderProduct = OrderProduct::find($id);
        $orderProduct->status = 9;
        $orderProduct->update();

        return redirect()->back()->with('success', 'Order Successfully Return !!!');
    }
    
    
    public function generateVendorInvoice($id)
    
    {


       $orderProduct = OrderProduct::find($id);
       
        $order = $this->order->getById($orderProduct->order_id);

        return view('admin.orders.vendorinvoice', compact('order', 'orderProduct', 'state'));
    }
    
    public function generateVendorReturnInvoice($id){

        $orderProduct = OrderProduct::find($id);

        $order = $this->order->getById($orderProduct->order_id);

        return view('admin.orders.vendorreturninvoice', compact('order', 'orderProduct'));
    }
    

    public function generatePreInvoice($id)
    {
        $order = $this->order->getById($id);
        

        $userDetails = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('shipping_accounts', 'orders.address_id', '=', 'shipping_accounts.id')
            ->where('orders.id', '=', $order->id)
            ->select('users.id as user_id', 'users.first_name as user_first_name', 'users.last_name as user_last_name', 'shipping_accounts.*')
            ->first();

        return view('admin.orders.preinvoice', compact('order', 'userDetails', 'state'));
    }

    public function getOrdersJson(Request $request)
    {
        // $orders = $this->order->getAll();
        switch ($request->status) {
            case 'pending':
                $orders = Order::where('order_status_id', 1)->orderBy('id', 'desc')->get();
                break;
            case 'approved':
                $orders = Order::where('order_status_id', 2)->orderBy('id', 'desc')->get();
                break;
            case 'received':
                $orders = Order::where('order_status_id', 3)->orderBy('id', 'desc')->get();
                break;
            case 'delivered':
                $orders = Order::where('order_status_id', 4)->orderBy('id', 'desc')->get();
                break;
            case 'cancelled':
                $orders = Order::where('order_status_id', 5)->orderBy('id', 'desc')->get();
                break;
            case 'review':
                $orders = Order::where('order_status_id', 6)->orderBy('id', 'desc')->get();
                break;
            case 'dispatched':
                $orders = Order::where('order_status_id', 7)->orderBy('id', 'desc')->get();
                break;
            case 'completed':
                $orders = Order::where('order_status_id', 8)->orderBy('id', 'desc')->get();
                break;
            case 'pack':
                $orders = Order::where('order_status_id', 10)->orderBy('id', 'desc')->get();
                break;
            case 'unpack':
                $orders = Order::where('order_status_id', 11)->orderBy('id', 'desc')->get();
                break;
            case 'all':
                if (Auth::user()->hasRole('delivery')) {
                    $destination = DeliveryBoy::where('user_id', auth()->id())->first();
                    $orders = Order::where('delivery_destination_id', $destination->delivery_destination_id)->orderBy('id', 'desc')->get();
                } else {
                    $orders = Order::orderBy('id', 'desc')->get();
                }
                break;
        }

        if (null === $orders) {
            return datatables($orders)->toJson();
        }


        $ordersArray = [];
        foreach ($orders as $orderKey => $orderValue) {
            if(empty($orderValue->prebookings)) {
            $ordersArray[$orderKey]['id'] = $orderValue->id;
            $ordersArray[$orderKey]['order_no'] = $orderValue->code;
            $ordersArray[$orderKey]['order_status'] = $orderValue->orderStatus->name;
            $ordersArray[$orderKey]['order_date'] = Carbon::parse($orderValue->order_date)->format('d/m/Y');
            $ordersArray[$orderKey]['create_date'] = Carbon::parse($orderValue->created_at)->format('d/m/Y');
            $ordersArray[$orderKey]['userOrder'] = [
                'order_id' => $orderValue->id,
                'user_id' => $orderValue->user_id,
                'user_first_name' => isset($orderValue->user->first_name) ? $orderValue->user->user_name : '',
                'user_email' => isset($orderValue->user->email) ? $orderValue->user->email : '',
            ];


            $ordersArray[$orderKey]['address'] = [
                'address_first_name' => isset($orderValue->shipping_address->first_name) ? $orderValue->shipping_address->first_name : null,
                'address_last_name' => isset($orderValue->shipping_address->last_name) ? $orderValue->shipping_address->last_name : null,
                'address_area' => isset($orderValue->shipping_address->area) ? $orderValue->shipping_address->area : null,
                'address_district' => isset($orderValue->shipping_address->district) ? $orderValue->shipping_address->district : null,
                'address_zone' => isset($orderValue->shipping_address->zone) ? $orderValue->shipping_address->zone : null,
                'address_mobile' => isset($orderValue->shipping_address->mobile) ? $orderValue->shipping_address->mobile : null,
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
                    'tax_amount' => $productValue->pivot->tax,
                ];

                $actualPrice = $productValue->pivot->qty * $productValue->pivot->price;
                $actualPrice += $actualPrice * ($productValue->pivot->tax / 100);
                $dis = $productValue->pivot->discount;
                $priceTotal += ($actualPrice - $dis);
            }

            if ($orderValue->shipping_amount) {
                $priceTotal += $orderValue->shipping_amount;
            }

            $ordersArray[$orderKey]['payment'] = isset($orderValue->payment->name) ? $orderValue->payment->name : 'COD';

            $ordersArray[$orderKey]['price_total'] = number_format($priceTotal, 2);
        }
        }


        return datatables($ordersArray)->toJson();

    }

    public function getOrderReturns()
    {
        $order_returns = OrderReturnRequest::count();
        return view('admin.orders.order_return', compact('order_returns'));
    }

    public function getOrderReturnJson()
    {
    
        $orderProducts = OrderProduct::where('status', 9)->get();
        foreach ($orderProducts as $orderProduct){

            if($orderProduct->products->users->vendorDetails){
                $orderProduct->vendorName = $orderProduct->products->users->vendorDetails->name;
            }else{
                $orderProduct->vendorName = $orderProduct->products->users->user_name;
            }


            $order = $this->order->getById($orderProduct->order_id);
            $orderProduct->address = $order->shipping_address->area.', '.$order->shipping_address->district.' '.$order->shipping_address->zone;
            $orderProduct->productName  = $orderProduct->products->name;
            $orderProduct->userName = $order->shipping_address->first_name.' '.$order->shipping_address->last_name;
            $orderProduct->orderCode = $order->code;
            $orderProduct->date = $orderProduct->created_at->diffForHumans();
            $orderProduct->orderId = $order->id;
        }

        return datatables($orderProducts)->toJson();

    }

    public function editOrderReturn($id)
    {
        $order_return = OrderReturnRequest::findOrFail($id);

        $orderReturnStatuses = array('' => 'Select Order Status') + OrderReturnStatus::pluck('name', 'id')->toArray();

        return view('admin.orders.edit_order_return', compact('order_return', 'orderReturnStatuses'));
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

    public function destroyOrderReturn($id)
    {
         $order_return = OrderProduct::findOrFail($id);
        if ($order_return->order->orderProduct()->count() == 1){
//            order delete by orderproduct
            $order_return->delete();
            $order_return->order()->delete();
        }else{
            $order_return->delete();
        }
        return response()->json('Order Return Successfully Deleted.');
    }

    public function generateBarcode($id)
    {
    
        $order = $this->order->getById($id);

        $userDetails = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('shipping_accounts', 'orders.address_id', '=', 'shipping_accounts.id')
            ->where('orders.id', '=', $order->id)
            ->select('users.id as user_id', 'users.first_name as user_first_name', 'users.last_name as user_last_name', 'shipping_accounts.*')
            ->first();

        $qrCode = new QrCode();
        $qrCode
            ->setText(url('/'))
            ->setSize(100)
            ->setPadding(0)
            ->setErrorCorrection('high')
            ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
            ->setLabelFontSize(16)
            ->setImageType(QrCode::IMAGE_TYPE_PNG)
        ;
        $qrLogo = 'data:'.$qrCode->getContentType().';base64,'.$qrCode->generate();

        $barcode = new BarcodeGenerator();
        $barcode->setText(strval($order->barcode));
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setScale(3);
        $barcode->setThickness(30);
        $barcode->setFontSize(10);
        $code = $barcode->generate();

        $ordercode = new BarcodeGenerator();
        $ordercode->setText($order->code);
        $ordercode->setType(BarcodeGenerator::Code128);
        $ordercode->setScale(3);
        $ordercode->setThickness(15);
        $ordercode->setFontSize(8);
        $order_code = $ordercode->generate();

        return view('admin.orders.barcode', compact('order', 'userDetails', 'state', 'code', 'qrLogo', 'order_code'));
    }

    public function exportToExcel($status)
    {
        return Excel::download(new OrdersExport($status), 'orders.xlsx');
    }

    public function exportSelectedToExcel(Request $request)
    {
        $orders = $request->ids;
        if (!isset($orders) && $orders == null) {
            return redirect()->back()->with('error', 'You have not seleted any item!');
        }
        return Excel::download(new SelectedOrderExport($orders), 'orders.xlsx');
    }
    
    
    public function csReport(){

        $customerCares = Role::where('id', 5)->first()->users;
        $orders = Order::take(30)->get();
        // dd($orders);
       return view('admin.csreport.index', compact('customerCares', 'orders'));


    }

    public function csReportOrder(Request $request){
        $cs = $request->cs;
        $from = $request->start_date;
        $to = $request->end_date;
        $ordersFiletr = Order::where('user_id', $cs)->get();
        foreach ($ordersFiletr as $item){
            $item->csdate = $item->created_at->format('Y-m-d');
        }
        $orders = $ordersFiletr->where('csdate', '>=', $from)->where('csdate', '<=', $to);

        $customerCares = Role::where('id', 5)->first()->users;
        
        $csname = User::find($cs);
        return view('admin.csreport.index', compact('customerCares', 'orders', 'csname'));

    }
    
    
     public function bulkStatus(Request $request, $status){

        $ids = $request->ids;
        $orders = Order::whereIn('id', $ids)->get();
        foreach ($orders as $order){
            $order->order_status_id = $status;
            $order->update();
        }

        return redirect()->back()->with('success', 'Order Return Successfully Updated.');
    }
    
    public function generateBulkInvoice(Request $request){

        $ids = $request->ids;
        $orders = Order::whereIn('id', $ids)->get();

            foreach ($orders as $item){

                $order = $this->order->getById($item->id);

                $item->userDetails = DB::table('orders')
                    ->leftJoin('users', 'orders.user_id', '=', 'users.id')
                    ->leftJoin('shipping_accounts', 'orders.address_id', '=', 'shipping_accounts.id')
                    ->where('orders.id', '=', $order->id)
                    ->select('users.id as user_id', 'users.first_name as user_first_name', 'users.last_name as user_last_name', 'shipping_accounts.*')
                    ->first();

            }


        return view('admin.orders.bulkinvoice', compact('orders'));
    }
    
    
     public function generateBulkBarcode(Request $request)
    {
        $ids = $request->ids;
        $orders = Order::whereIn('id', $ids)->get();
        foreach ($orders as $item){
            $order = $this->order->getById($item->id);

            $item->userDetails = DB::table('orders')
                ->leftJoin('users', 'orders.user_id', '=', 'users.id')
                ->leftJoin('shipping_accounts', 'orders.address_id', '=', 'shipping_accounts.id')
                ->where('orders.id', '=', $order->id)
                ->select('users.id as user_id', 'users.first_name as user_first_name', 'users.last_name as user_last_name', 'shipping_accounts.*')
                ->first();

            $qrCode = new QrCode();
            $qrCode
                ->setText(url('/'))
                ->setSize(100)
                ->setPadding(0)
                ->setErrorCorrection('high')
                ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
                ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
                ->setLabelFontSize(16)
                ->setImageType(QrCode::IMAGE_TYPE_PNG)
            ;
            $item->qrLogo = 'data:'.$qrCode->getContentType().';base64,'.$qrCode->generate();

            $barcode = new BarcodeGenerator();
            $barcode->setText(strval($order->barcode));
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setScale(3);
            $barcode->setThickness(30);
            $barcode->setFontSize(10);
            $item->barcode = $barcode->generate();

            $ordercode = new BarcodeGenerator();
            $ordercode->setText($order->code);
            $ordercode->setType(BarcodeGenerator::Code128);
            $ordercode->setScale(3);
            $ordercode->setThickness(15);
            $ordercode->setFontSize(8);
            $item->ordercode =  $ordercode->generate();
        }
//dd($orders);
        return view('admin.orders.bulkbarcode', compact('orders', 'userDetails', 'state', 'code', 'qrLogo', 'order_code'));
    }
    
}
