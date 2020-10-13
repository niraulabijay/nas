@extends('admin.layouts.invoice')
@section('title', 'Order Invoice')

@section('content')
    <style>
        .invoice--container {
            margin-top: 20px;
            border: 2px solid ghostwhite;
            padding: 20px 10px;
        }

        .invoice--container .sub-container {
            text-align: right;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        .invoice--container .sub-container span {
            font-size: 11px;
        }

        .invoice--container .soldby--box .panel-heading, .invoice--container .soldto--box .panel-heading {
            text-align: center;
            font-size: 12px;
            padding: 3px;
        }

        .invoice--container .soldby--box li, .invoice--container .soldto--box li {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            font-size: 11px;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            text-transform: capitalize;
        }

        .invoice--container th {
            text-align: center;
            text-transform: capitalize;
        }

        .invoice--container .invoice--bottom {
            width: 100%;
            border: 1px solid black;
            display: block;
            padding: 5px;
            font-size: 11px;
        }

        .invoice--container .table thead > tr > th {
            font-size: 11px;
            padding: 3px;
        }

        .invoice--container .table tbody > tr > td {
            font-size: 11px;
            padding: 5px;
        }

        @media print {
            .print-window {
                display: none;
            }
        }
    </style>

    <button type="button" class="btn btn-default pull-right print-window">Print</button>
    <div class="clearfix"></div>
    <div class="invoice--container container" id="print-invoice">
        <div class="row">
            <div class="col-xs-6">
                <div class="logo">
                    <img src="{{ url('storage').'/'. getConfiguration('site_logo') }}"
                         alt="{{ getConfiguration('site_title') }}" style="width: 10%;height: auto;">
                </div>
                <span>Pan No: 4223525</span><br>
                <span>Reg No: 4223525</span>
            </div>
            <div class="col-xs-6">
                <div class="sub-container">
                    <span>Invoice No: {{ $order->invoice_date ? \Carbon\Carbon::parse($order->invoice_date)->format('M d, Y') : \Carbon\Carbon::now()->format('M d, Y') }}</span>
                    <span>Order No: {{ $order->code }}</span>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-6">
                <div class="soldto--box panel panel-default">
                    <div class="panel-body" style="padding: 10px;">
                        <ul class="liststyle--none" style="margin: 0;">
                            <li>
                                <strong>Customer name:</strong>
                                <span>{{ $userDetails->first_name . ' ' . $userDetails->last_name }}</span>
                            </li>
                            <li>
                                <strong>Address:</strong>
                                <span>{{ $userDetails->area }}, {{ $userDetails->district }}, {{ $userDetails->zone }}</span>
                            </li>
                            <li>
                                <strong>Mobile no:</strong>
                                <span>{{ $userDetails->mobile }}</span>
                            </li>
                            <li>
                                <strong>Email:</strong>
                                <span>{{ $userDetails->email }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
            <tr class="active">
                <th>product description</th>
                <th>qty</th>
                <th>unit price</th>
            </tr>
            </thead>
            <tbody>
            @php
                $discountAmount_ = 0;
                $productSubTotal_ = 0;
                $taxAmount_ = 0;
            @endphp

            @foreach($products = $order->orderProduct as $product)
                @php
                    $discount = $product->discount;
                    $tax = $product->tax;
                    $actualPrice = $product->price * $product->qty;
                    $taxAmount = (($actualPrice * $tax) / 100);
                    $taxAmount_ += $taxAmount;
                    $actualPrice_ = $actualPrice + $taxAmount;
                    $discountAmount = $discount;
                    $discountAmount_ += $discountAmount;
                    $productSubTotal = $actualPrice_ - ( $discountAmount );
                   $productSubTotal_ += $actualPrice;
                @endphp

                <tr class="text-center">
                    <td>
                        <img src="{{ $product->products->getImageAttribute()->smallUrl }}" alt="{{ strip_tags($product->products->name  ) }}" width="30px">
                        {{ strip_tags($product->products->name  ) }} {{ $product->products->sku ? '(' . $product->products->sku . ')' : '' }}
                    </td>
                    <td>{{ $product->qty }}</td>
                    <td>RS {{ $product->price }}</td>
                </tr>

            @endforeach

            @php

                $grandTotal = $order->prebookings->price;
            @endphp
            <tr>
                <td colspan="2" class="text-right">Subtotal (10% / Preorder)</td>
                <td class="text-center">Rs. {{ $order->prebookings->price }}</td>
            </tr>
            {{-- <tr>
                <td colspan="2" class="text-right">Shipping Charge</td>
                <td class="text-center">Rs. {{ $order->shipping_amount }}</td>
            </tr> --}}
            <tr>
                <td colspan="2" class="text-right">Total</td>
                <td class="text-center">Rs. {{ $grandTotal }}</td>
            </tr>
            </tbody>
        </table>

        <span class="text-center invoice--bottom">
            For return/refund or any queries call us at 
            <span class="invoice--phoneno">{{ getConfiguration('site_primary_phone') }}</span>, or email us at <span class="invoice--email">{{ getConfiguration('site_primary_email') }}</span>
        </span>
    </div>
@endsection