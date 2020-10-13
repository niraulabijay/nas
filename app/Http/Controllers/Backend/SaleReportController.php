<?php

namespace App\Http\Controllers\Backend;

use App\Model\Order;
use App\Model\OrderProduct;
use App\Model\Product;
use DB;
use App\Model\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Excel;

class SaleReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->has('salesdate')) {

            return $request->salesdate;
        }

//        $totalOrder =DB::select("select * from order_product left JOIN orders ON order_product.order_id=orders.id WHERE orders.order_status_id = 4");
//        $subTotalOrder = DB::select("select SUM(price) from order_product left JOIN orders ON order_product.order_id=orders.id WHERE orders.order_status_id = 4");
//        $totalDiscount = DB::select("select SUM(discount) from order_product left JOIN orders ON order_product.order_id=orders.id WHERE orders.order_status_id = 4");
//        $totalTax = DB::select("select SUM(tax) from order_product left JOIN orders ON order_product.order_id=orders.id WHERE orders.order_status_id = 4");
//        $totalShipping = Order::where('order_status_id', 4)->sum('shipping_amount');



//        dd($subTotalOrder);
//        $grandTotal = $subTotalOrder + $totalTax + $totalShipping - $totalDiscount;


        $orders = Order::where('order_status_id', 4)->get()->pluck('id');

//            $productorder = OrderProduct::whereIn('order_id', $orders)->get();


        $totalOrder = Order::where('order_status_id', 4)->count();
        
        
        
        $totalOrderProducts = OrderProduct::whereIn('order_id', $orders)->where('status','!=', 9)->get();
        // $subTotalOrder =OrderProduct::whereIn('order_id', $orders)->sum('price');
        $subTotalOrder = 0;
        foreach($totalOrderProducts as $totalOrderProduct){
            $totalOrderProduct->orderProductPrice = $totalOrderProduct->price * $totalOrderProduct->qty;
            $subTotalOrder += $totalOrderProduct->orderProductPrice;
        }
        
        $totalDiscount = OrderProduct::whereIn('order_id', $orders)->where('status','!=', 9)->sum('discount');
        $totalTax = OrderProduct::whereIn('order_id', $orders)->where('status','!=', 9)->sum('tax');
        $totalShipping = Order::where('order_status_id', 4)->sum('shipping_amount');
        $grandTotal = $subTotalOrder + $totalTax + $totalShipping - $totalDiscount;
        $orderStatuses = OrderStatus::all();

        return view('admin.sales_report.index', compact('abc', 'totalOrder', 'subTotalOrder', 'totalDiscount', 'grandTotal', 'totalTax', 'totalShipping', 'orderStatuses'));


    }


    public function salesReportJson(Request $request){
          $startdate = $request->input('startdate');
        $enddate = $request->input('enddate');
        $orderstatus = $request->input('orderstatus');
        
        if(!$startdate == null) {
            $orders = Order::where('order_status_id', $orderstatus)->get()->pluck('id');
            $totalOrders = OrderProduct::whereIn('order_id', $orders)->whereBetween('created_at', [$startdate, $enddate])->where('status','!=', 9)->get();
        }else{

            $orders = Order::where('order_status_id', 4)->get()->pluck('id');
            $totalOrders = OrderProduct::whereIn('order_id', $orders)->where('status','!=', 9)->get();
        }



        foreach ($totalOrders as $totalOrder) {
            $totalOrder->product_name = $totalOrder->products?$totalOrder->products->name:'N/A';
        }
        foreach ($totalOrders as $totalOrder) {
            $totalOrder->shipping = $totalOrder->Order->shipping_amount;
            $totalOrder->grandTotal = ($totalOrder->price * $totalOrder->qty) + $totalOrder->tax + $totalOrder->shipping - $totalOrder->discount;
        }

        return datatables( $totalOrders )->toJson();
    }






    public function getReport(Request $request){
        
        
        $startdate = $request->input('startdate');
        $enddate = $request->input('enddate');
        $orderstatus = $request->input('orderstatus');



         if($orderstatus == 0){
             $orders = Order::whereBetween('created_at', [$startdate, $enddate])->get()->pluck('id');
             $totalShipping = Order::whereBetween('created_at', [$startdate, $enddate])->sum('shipping_amount');
             $totalOrder = Order::whereBetween('created_at', [$startdate, $enddate])->count();
         }else{
             
             $orders = Order::where('order_status_id', $orderstatus)->whereBetween('created_at', [$startdate, $enddate])->get()->pluck('id');
             $totalShipping = Order::where('order_status_id', $orderstatus)->whereBetween('created_at', [$startdate, $enddate])->sum('shipping_amount');
             $totalOrder = Order::where('order_status_id', $orderstatus)->whereBetween('created_at', [$startdate, $enddate])->count();
         }
         
         
        $totalOrderProducts = OrderProduct::whereIn('order_id', $orders)->whereBetween('created_at', [$startdate, $enddate])->where('status','!=', 9)->get();

        $subTotalOrder = 0;
        foreach($totalOrderProducts as $totalOrderProduct){
            $totalOrderProduct->orderProductPrice = $totalOrderProduct->price * $totalOrderProduct->qty;
            $subTotalOrder += $totalOrderProduct->orderProductPrice;
        }
        

        $totalDiscount = OrderProduct::whereIn('order_id', $orders)->whereBetween('created_at', [$startdate, $enddate])->where('status','!=', 9)->sum('discount');
        $totalTax = OrderProduct::whereIn('order_id', $orders)->whereBetween('created_at', [$startdate, $enddate])->where('status','!=', 9)->sum('tax');
        

        $grandTotal= $subTotalOrder+$totalTax+$totalShipping-$totalDiscount;


        return view('admin.sales_report.report', compact('totalOrder', 'subTotalOrder', 'totalDiscount', 'grandTotal', 'totalTax', 'totalShipping'));


    }


    public function getExcel(){
//        $salesReport = $request->input('product');
//        $salesReport_explode = explode(" to ",$salesReport);

        $orders = Order::where('order_status_id', 4)->get()->pluck('id');
        $totalOrders = OrderProduct::whereIn('order_id', $orders)->get();

        foreach ($totalOrders as $totalOrder) {
            $totalOrder->product_name = $totalOrder->products->name;
        }
        foreach ($totalOrders as $totalOrder) {
            $totalOrder->shipping = $totalOrder->Order->shipping_amount;
            $totalOrder->grandTotal = $totalOrder->price + $totalOrder->tax + $totalOrder->shipping - $totalOrder->discount;
        }

        $reportTitle[] = array('Name', 'Subtotal', 'Tax', 'Shipping', 'Discount', 'Total');
        foreach($totalOrders as $totalOrder)
        {
            $reportTitle[] = array(
                'Name'  => $totalOrder->product_name,
                'Subtotal'   => $totalOrder->price,
                'Tax'    => $totalOrder->tax,
                'Shipping'  => $totalOrder->shipping,
                'Discount'   => $totalOrder->discount,
                'Total'   => $totalOrder->grandTotal,
            );
        }
        Excel::create('reports', function($excel){
            $excel->sheet('reports', function($sheet){
                $sheet->loadView('getExcel');
            });
        })->export('xlsx');

    }



}
