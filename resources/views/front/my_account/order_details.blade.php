@extends('layouts.app')
@section('title', 'Order Details')

@section('content')
    <div class="container">
        @if($order)
            @if($order->user_id ==auth()->id())
                <div class="row">
                    <div class="content-box content-box--shadow">
                        <div class="panel panel-default no-border-shadow">
                            <div id="ar-right-1">
                                <div class="panel-body">
                                    Order Tracking Id: <span class="text-danger">{{ $order->code }}</span>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr class="warning">
                                                <td class="text-left">Product Name</td>
                                                <td class="text-left">Image</td>
                                                <td class="text-right">Quantity</td>
                                                <td class="text-right">Unit Price</td>
                                                <td class="text-right">Total</td>
                                                <td>Action</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $subTotal = 0.00;

                                                $discountAmount_ = 0;
                                                $productSubTotal_ = 0;
                                                $taxAmount_ = 0;
                                            @endphp

                                            @foreach($products = $order->orderProduct as $product)
                                                @php
                                                    $discount = $product->discount;
                                                    $tax = $product->tax;
                                                    $actualPrice = $product->price * $product->qty;
                                                    if($product->prebooking == 1) {
                                                        $subTotal += ($actualPrice * 10) / 100;
                                                        $taxAmount_ += 0;
                                                    }
                                                    else {
                                                        $subTotal += $actualPrice;
                                                        $taxAmount_ += ($actualPrice * $tax) / 100;
                                                    }
                                                    $discountAmount_ += $discount;
                                                   $productSubTotal_ += $subTotal;
                                                @endphp

                                                <tr>
                                                    <td class="text-left"><a href="">{{ strip_tags($product->products->name) }}</a>
                                                    </td>
                                                    <td class="text-left">
                                                        <img src="{{ asset(getProductImage($product->products->id, 'small')) }}" alt="{{ $product->products->name }}" >
                                                    </td>
                                                    <td class="text-right">{{ $product->qty }}</td>
                                                    <td class="text-right">Rs.{{ $product->price }}</td>
                                                    <td class="text-right">Rs.{{ ($product->qty * $product->price) - $product->discount }}<br>

                                                    </td>
                                                    <td>
                                                        <a href="{{route('user.disputes', \App\Model\OrderProduct::where('order_id',$order->id)->where('product_id',$product->products->id)->first()->id)}}" class="btn btn-warning btn-xs">
                                                            Report</a>
                                                        <a href="{{route('order.return', \App\Model\OrderProduct::where('order_id',$order->id)->where('product_id',$product->products->id)->first()->id)}}" class="btn btn-default btn-xs">Return Product</a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            @php

                                                $grandTotal = $productSubTotal_ + $taxAmount_ - $discountAmount_ + $order->shipping_amount;
                                            @endphp
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td><strong>Order ID:</strong></td>
                                                <td>{{$order->id}}</td>
                                                <td colspan="2" class="text-right"><strong>Sub-Total:</strong></td>
                                                <td class="text-right">Rs.{{ number_format($productSubTotal_, 2) }}</td>
                                                <td colspan="3" class="text-center bold">Live Tracking</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Order Date:</strong></td>
                                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('F j, Y')}}</td>
                                                <td colspan="2" class="text-right"><strong>Shipping Rate:</strong></td>
                                                <td class="text-right">Rs. {{ $order->shipping_amount }}  </td>
                                                <td colspan="3" rowspan="4">{{ isset($order->tracking) ? $order->tracking : '' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Order Status</td>
                                                <td><span class="label label-{{ getOrderStatusClass($order->orderStatus->name) }}">{{ $order->orderStatus->name }}</span></td>
                                                <td colspan="2" class="text-right"><strong>VAT:</strong></td>
                                                <td class="text-right">Rs.{{ number_format($taxAmount_, 2)}} </td>
                                            </tr>
                                            <tr>
                                                <td>Payment Method</td>
                                                <td class="text-left">@isset($order->payment) {{ $order->payment->name }} @endisset</td>
                                                <td colspan="2" class="text-right"><strong>Discount:</strong></td>
                                                <td class="text-right">Rs.{{ number_format($discountAmount_ , 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>Total:</strong></td>
                                                <td class="text-right">Rs.{{ number_format($grandTotal , 2) }}</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
    </div>
    @else
        <div class="alert alert-danger">Sorry, You've entered the wrong tracking number. </div>
    @endif
    @else
        <div class="alert alert-danger"> Sorry, You've entered the wrong tracking number.</div>
    @endif
@endsection