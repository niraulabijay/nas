@extends('admin.layouts.invoice')
@section('title', 'Barcode Invoice')

@section('content')
    <style>
        .invoice--container {
            margin-top: 20px;
            border: 1px solid black;
            width: 500px;
        }
        .invoice--container .first-row {
            border-bottom: 1px solid black;
        }
        .invoice--container .first-row .order-number {
            border-left: 1px solid black;
            border-right: 1px solid black;
        }
        .invoice--container .second-row {
            padding: 3px 0 10px 0;
            border-bottom: 1px solid black;
        }
        .invoice--container .third-row {
            border-bottom: 1px solid black;
        }
        .invoice--container .third-row .logo {
            padding: 3px 0 10px 0;
            border-right: 1px solid black;
        }
        .invoice--container .fourth-row {
            padding: 3px 0 10px 0;
            border-bottom: 1px solid black;
        }
        .invoice--container .fifth-row .qr-logo {
            border-right: 1px solid black;
            padding: 10px;
        }
        .border-bottom {
            border-bottom: 1px solid black;
        }
        .border-right {
            border-right: 1px solid black;
        }
        .text-left .border-bottom {
            padding: 7px 0 12px 15px;
        }

        @media print {
            .print-window {
                display: none;
            }
        }
    </style>

    <button type="button" class="btn btn-default pull-right print-window">Print</button>
    <div class="clearfix"></div>
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

    @endforeach

    @php
        $grandTotal = $productSubTotal_ + $taxAmount_ - $discountAmount_ + $order->shipping_amount;
    @endphp
    <div class="invoice--container container" id="print-invoice">
        <div class="row text-center first-row">
            <div class="col-xs-4">
                <div class="" style="padding: 3px 0px;">
                    <img src="{{ url('storage') . '/' . getConfiguration('site_logo') }}" class="img-responsive" style="width: 50%;margin: 0 auto;display: inline-block;" />
                    <h5 style="display:inline-block;">Delivery</h5>
                </div>
            </div>
            <div class="col-xs-4 order-number">
                <div class="number">
                    <span><small>Order Number</small></span><br>
                    <span><h5>{{ $order->code }}</h5></span>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="">
                    <span>{{ Carbon\Carbon::now()->format('d M, Y') }}</span>
                </div>
            </div>
        </div>
        <div class="row text-center second-row">
            <div class="col-xs-12">
                <div class="text-center">
                    <img src="{{ 'data:image/png;base64,' . $code }}" />
                </div>
            </div>
        </div>
        <div class="row text-center third-row">
            <div class="col-xs-8 logo">
                <div class="text-center" style=" min-height: 125px;">
                    @foreach($order->orderProduct as $product)
                    <div @if(!$loop->last) style="border-bottom: 1px solid; padding: 4px;" @endif>{{ $product->products->name }}</div>
                    @endforeach
                </div>
            </div>
            <div class="col-xs-4">
                <div class="row">
                    <div class="col-xs-12 border-bottom">
                        {{ $userDetails->zone }}
                    </div>
                    <div class="col-xs-12 border-bottom">-</div>   
                    <div class="col-xs-12 border-bottom">-</div>   
                    <div class="col-xs-12 border-bottom">-</div>   
                    <div class="col-xs-12 border-bottom">
                        @isset($order->payment) {{ $order->payment->name }} @endisset
                    </div>   
                    <div class="col-xs-12">
                        {{ $grandTotal }}
                    </div>   
                </div>
            </div>
        </div>
        <div class="row text-center fourth-row">
            <div class="col-xs-12">
                <div class="">
                    <img src="{{ 'data:image/png;base64,' . $order_code }}" />
                </div>
            </div>
        </div>
        <div class="row text-center fifth-row">
            <div class="col-xs-4 qr-logo">
                <div class="">
                    <img src="{{ $qrLogo }}" />
                </div>
            </div>
            <div class="col-xs-8">
                <div>
                    <div class="row text-left">
                        <div class="col-xs-12 border-bottom">
                            <span>
                                Recipient: {{ $userDetails->first_name . ' ' . $userDetails->last_name }}
                                (Tel: {{ $userDetails->mobile }})
                                near {{ $userDetails->area }}
                                {{ $userDetails->district }}
                                {{ $userDetails->zone }},
                                Nepal
                            </span>
                        </div>
                        <div class="col-xs-12 border-bottom">
                            <span>
                                Seller: Nepal All Shop, Kathmandu, Nepal
                            </span>
                        </div>
                        <div class="col-xs-8 border-right">
                            <span>
                                Package Weight: 2kg
                            </span>
                        </div>
                        <div class="col-xs-4">
                            <span>
                                Qty: {{ $order->orderProduct->sum('qty') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

