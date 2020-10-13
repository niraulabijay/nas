<?php

namespace App\Http\Controllers\Backend;

use App\Model\Order;
use App\Model\Product;
use App\Model\ReferalTransaction;
use App\User;
use App\Model\Dispute;
use App\Model\WithdrawStatus;

use App\Model\Contact;
use App\Model\Brand;
use App\Model\WithDraw;
use App\Model\Negotaible;
use App\Model\ReviewProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Model\Advertise;


class DashboardController extends Controller
{
    public function index()
    {
        $disputes = Dispute::all()->count();
        $messages = Contact::where('status',0)->get()->count();
        $vendorsCount = User::whereHas( 'roles', function ( $q ) {
                    $q->where( 'name', 'vendor' );
                } )->count();
        $vendors = User::whereHas( 'roles', function ( $q ) {
            $q->where( 'name', 'vendor' );
        } )->get();
        $brands = Brand::all()->count();
        $products = Product::orderBy('id', 'DESC')->take(10)->get();
        $count_products = Product::all()->count();
        $users = User::whereDoesntHave( 'roles', function ( $q ) {
            $q->where( 'name', 'admin' );
            $q->orWhere( 'name', 'manager' );
        } )->get();
        $count_users = $users->count();
        $count_orders = Order::all()->count();
        $clients = User::whereDoesntHave('roles', function ($q) {
            $q->where('name', 'admin');
            $q->orWhere('name', 'manager');
            $q->orWhere('name', 'vendor');
        })->count();
        
        $pendingCount =Order::where('order_status_id', 1)->count();
        $approvedCount =Order::where('order_status_id', 2)->count();
        $receivedCount =Order::where('order_status_id', 3)->count();

        $deliveredCount =Order::where('order_status_id', 4)->count();
        $cancelledCount =Order::where('order_status_id', 5)->count();
        
        $customer_today = User::whereDate('created_at', date('Y-m-d'))->whereDoesntHave( 'roles', function ( $q ) {
            $q->where( 'name', 'admin' );
            $q->orWhere( 'name', 'manager' );
            $q->orWhere('name', 'vendor');
        } )->count();
        $customer_week = User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])->whereDoesntHave( 'roles', function ( $q ) {
            $q->where( 'name', 'admin' );
            $q->orWhere( 'name', 'manager' );
            $q->orWhere('name', 'vendor');
        } )->count();
        $customer_month = User::whereMonth('created_at', date('m'))->whereDoesntHave( 'roles', function ( $q ) {
            $q->where( 'name', 'admin' );
            $q->orWhere( 'name', 'manager' );
            $q->orWhere('name', 'vendor');
        } )->count();
        $customer_three_month = User::whereBetween('created_at', [Carbon::now()->subMonths(3), Carbon::now()])->whereDoesntHave( 'roles', function ( $q ) {
            $q->where( 'name', 'admin' );
            $q->orWhere( 'name', 'manager' );
            $q->orWhere('name', 'vendor');
            } )->count();
        $customers = User::whereDoesntHave( 'roles', function ( $q ) {
            $q->where( 'name', 'admin' );
            $q->orWhere( 'name', 'manager' );
            $q->orWhere('name', 'vendor');
            } )->count();
        
        $product_today = Product::whereDate('created_at', date('Y-m-d'))->count();
        $product_week = Product::whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])->count();
        // dd($product_week);
        $product_month = Product::whereMonth('created_at', date('m'))->count();
        $product_three_month = Product::whereBetween('created_at', [Carbon::now()->subMonths(3), Carbon::now()])->count();
        $products_count = Product::count();
        
        $vendor_today = User::whereDate('created_at', date('Y-m-d'))->whereHas( 'roles', function ( $q ) {
            $q->where( 'name', 'vendor' );
            } )->count();
        $vendor_week = User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])->whereHas( 'roles', function ( $q ) {
            $q->where( 'name', 'vendor' );
            } )->count();
        $vendor_month = User::whereMonth('created_at', date('m'))->whereHas( 'roles', function ( $q ) {
            $q->where( 'name', 'vendor' );
            } )->count();
        $vendor_three_month = User::whereBetween('created_at', [Carbon::now()->subMonths(3), Carbon::now()])->whereHas( 'roles', function ( $q ) {
            $q->where( 'name', 'vendor' );
            } )->count();
        $vendor_count = User::whereHas( 'roles', function ( $q ) {
            $q->where( 'name', 'vendor' );
            } )->count();
            
        $order_today = Order::whereDate('created_at', date('Y-m-d'))->count();
        $order_week = Order::whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])->count();
        $order_month = Order::whereMonth('created_at', date('m'))->count();
        $order_three_month = Order::whereBetween('created_at', [Carbon::now()->subMonths(3), Carbon::now()])->count();
        $order_count = Order::count();
        
        $ordervalue_todays = Order::whereDate('created_at', date('Y-m-d'))->get();
        $totalordervalue_today = 0;
        foreach($ordervalue_todays as $ordervalue_today)
        {
            if($ordervalue_today->orderProduct->count())
            {
                $price = $ordervalue_today->orderProduct->first()->price;
                $qty = $ordervalue_today->orderProduct->first()->qty;
                $total = $price * $qty;
                $totalordervalue_today += $total;
            }
        }
        $ordervalue_weeks = Order::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])->get();
        $totalordervalue_week = 0;
        foreach($ordervalue_weeks as $ordervalue_week)
        {
            if($ordervalue_week->orderProduct->count())
            {
                $price = $ordervalue_week->orderProduct->first()->price;
                $qty = $ordervalue_week->orderProduct->first()->qty;
                $total = $price * $qty;
                $totalordervalue_week += $total;
            }
        }
        $ordervalue_months = Order::whereMonth('created_at', date('m'))->get();

        $totalordervalue_month= 0;
        foreach($ordervalue_months as $ordervalue_month)
        {
            if($ordervalue_month->orderProduct->count())
            {
                $price = $ordervalue_month->orderProduct->first()->price;
                $qty = $ordervalue_month->orderProduct->first()->qty;
                $total = $price * $qty;
                $totalordervalue_month += $total;
            }
        }
        $ordervalue_three_months = Order::whereBetween('created_at', [Carbon::now()->subMonths(3), Carbon::now()])->get();
        $totalordervalue_three_month = 0;
        foreach($ordervalue_three_months as $ordervalue_three_month)
        {
            if($ordervalue_three_month->orderProduct->count())
            {
                $price = $ordervalue_three_month->orderProduct->first()->price;
                $qty = $ordervalue_three_month->orderProduct->first()->qty;
                $total = $price * $qty;
                $totalordervalue_three_month += $total;
            }

        }
        $ordervalues = Order::all();
        $totalordervalue = 0;
        foreach($ordervalues as $ordervalue)
        {
            if($ordervalue->orderProduct->count())
            {
                $price = $ordervalue->orderProduct->first()->price;
                $qty = $ordervalue->orderProduct->first()->qty;
                $total = $price * $qty;
                $totalordervalue += $total;
            }
        }
        
        $sale_today = Order::whereDate('created_at', date('Y-m-d'))->where('order_status_id', 4)->count();
        $sale_week = Order::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])->where('order_status_id', 4)->count();
        $sale_month = Order::whereMonth('created_at', date('m'))->where('order_status_id', 4)->count();
        $sale_three_month = Order::whereBetween('created_at', [Carbon::now()->subMonths(3), Carbon::now()])->where('order_status_id', 4)->count();
        $sale_count = Order::where('order_status_id', 4)->count();
        
        $salevalue_todays = Order::whereDate('created_at', date('Y-m-d'))->where('order_status_id', 4)->get();
        $totalsalevalue_today = 0;
        foreach($salevalue_todays as $salevalue_today)
        {
            if($salevalue_today->orderProduct->count())
            {
                $price = $salevalue_today->orderProduct->first()->price;
                $qty = $salevalue_today->orderProduct->first()->qty;
                $total = $price * $qty;
                $totalsalevalue_today += $total;
            }
        }
        $salevalue_weeks = Order::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])->where('order_status_id', 4)->get();
        $totalsalevalue_week = 0;
        foreach($salevalue_weeks as $salevalue_week)
        {
            if($salevalue_week->orderProduct->count())
            {
                $price = $salevalue_week->orderProduct->first()->price;
                $qty = $salevalue_week->orderProduct->first()->qty;
                $total = $price * $qty;
                $totalsalevalue_week += $total;
            }
        }
        $salevalue_months = Order::whereMonth('created_at', date('m'))->where('order_status_id', 4)->get();
        $totalsalevalue_month= 0;
        foreach($salevalue_months as $salevalue_month)
        {
            if($salevalue_month->orderProduct->count())
            {
                $price = $salevalue_month->orderProduct->first()->price;
                $qty = $salevalue_month->orderProduct->first()->qty;
                $total = $price * $qty;
                $totalsalevalue_month += $total;
            }
        }
        $salevalue_three_months = Order::whereBetween('created_at', [Carbon::now()->subMonths(3), Carbon::now()])->where('order_status_id', 4)->get();
        $totalsalevalue_three_month = 0;
        foreach($salevalue_three_months as $salevalue_three_month)
        {
            if($salevalue_three_month->orderProduct->count())
            {
                $price = $salevalue_three_month->orderProduct->first()->price;
                $qty = $salevalue_three_month->orderProduct->first()->qty;
                $total = $price * $qty;
                $totalsalevalue_three_month += $total;
            }
        }
        $salevalues = Order::where('order_status_id', 4)->get();
        $totalsalevalue = 0;
        foreach($salevalues as $salevalue)
        {
            if($salevalue->orderProduct->count())
            {
                $price = $salevalue->orderProduct->first()->price;
                $qty = $salevalue->orderProduct->first()->qty;
                $total = $price * $qty;
                $totalsalevalue += $total;
            }
        }
        
        $withdraw_request_today = WithDraw::whereDate('created_at', date('Y-m-d'))->where('status', 1)->count();
        $withdraw_request_week = WithDraw::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])->where('status', 1)->count();
        $withdraw_request_month = WithDraw::whereMonth('created_at', date('m'))->where('status', 1)->count();
        $withdraw_request_three_month = WithDraw::whereBetween('created_at', [Carbon::now()->subMonths(3), Carbon::now()])->where('status', 1)->count();
        $withdraw_request = WithDraw::where('status', 1)->count();
        
        $product_review_today = ReviewProduct::whereDate('created_at', date('Y-m-d'))->count();
        $product_review_week = ReviewProduct::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])->count();
        $product_review_month = ReviewProduct::whereMonth('created_at', date('m'))->count();
        $product_review_three_month = ReviewProduct::whereBetween('created_at', [Carbon::now()->subMonths(3), Carbon::now()])->count();
        $product_review = ReviewProduct::count();
        
        $latest_orders = Order::whereHas('orderProduct')->orderBy('id', 'DESC')->take(10)->get();
        
        $latest_messages = Contact::orderBy('id', 'DESC')->take(10)->get();
        
        $latest_negotiables = Negotaible::orderBy('id', 'DESC')->take(10)->get();

        return view('admin.index', compact('products', 'users','count_users','messages', 'vendorsCount', 'vendors','brands','count_orders','count_products','disputes', 'clients', 'pendingCount', 'approvedCount', 'receivedCount','deliveredCount','cancelledCount', 'customer_today', 'customer_week', 'customer_month', 'customer_three_month', 'customers', 'product_today', 'product_week', 'product_month', 'product_three_month', 'products_count', 'vendor_today', 'vendor_week', 'vendor_month', 'vendor_three_month', 'vendor_count', 'order_today', 'order_week', 'order_month', 'order_three_month', 'order_count', 'totalordervalue_today', 'totalordervalue_week', 'totalordervalue_month', 'totalordervalue_three_month', 'totalordervalue', 'sale_today', 'sale_week', 'sale_month', 'sale_three_month', 'sale_count', 'totalsalevalue_today', 'totalsalevalue_week', 'totalsalevalue_month', 'totalsalevalue_three_month', 'totalsalevalue', 'withdraw_request_today', 'withdraw_request_today', 'withdraw_request_week', 'withdraw_request_month', 'withdraw_request_three_month', 'withdraw_request', 'product_review_today', 'product_review_week', 'product_review_month', 'product_review_three_month', 'product_review', 'latest_orders', 'latest_messages', 'latest_negotiables'));
    }
     public function getAds()
    {
        $advertises = Advertise::all();
        return view('admin.ads',compact('advertises'));
    }
     public function getEdit($id)
    {
        $withDrawStatus = WithdrawStatus::all();
        $details = Advertise::findOrFail($id);
        return view('admin.ads_edit',compact('details','withDrawStatus'));
    }
     public function editAds(Request $request,$id)
    {
        $this->validate($request,[
            'status' => 'required|digits:1|between:1,5'
        ]);

        $withdraw = Advertise::findOrFail($id);

        $withdraw->status = $request->status;
        $withdraw->update();

        return redirect()->back()->with('success',"Status is updated!!!");
    }
     
}
