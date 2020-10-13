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
            <div class="col-xs-4">
                <div class="logo">
                    <img src="{{ url('storage').'/'. getConfiguration('site_logo') }}"
                         alt="{{ getConfiguration('site_title') }}" style="width: 10%;height: auto;">
                </div>

                <span>Pan No: 606621074</span><br>
                <span>Reg No: 196584/075/076</span>
            </div>
            <div class="col-xs-4">
                <h4 style="text-align: center">Order Return</h4>
            </div>
            <div class="col-xs-4">
                <div class="sub-container">
                    <span>Invoice No: {{ $order->code }}</span>
                    <span>Order Return No: {{ $order->code }}</span>
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
                                <strong>Vendor Name:</strong>
                                <span>@if($orderProduct->products->users->vendorDetails) {{$orderProduct->products->users->vendorDetails->name}} @else {{ $orderProduct->products->users->user_name }} @endif</span>
                            </li>
                            <li>
                                <strong>Address:</strong>
                                <span>@if($orderProduct->products->users->vendorDetails) {{$orderProduct->products->users->vendorDetails->address}} @else NA @endif</span>
                            </li>
                            <li>
                                <strong>Mobile no:</strong>
                                <span>@if($orderProduct->products->users->vendorDetails) {{$orderProduct->products->users->vendorDetails->primary_phone}} @else {{$orderProduct->products->users->phone}} @endif</span>
                            </li>
                            <li>
                                <strong>Email:</strong>
                                <span>@if($orderProduct->products->users->vendorDetails) {{$orderProduct->products->users->vendorDetails->primary_email}} @else {{ $orderProduct->products->users->email }} @endif</span>
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
            </tr>
            </thead>
            <tbody>
            
                <tr class="text-center">
                    <td>
                        <img src="{{ $orderProduct->products->getImageAttribute()->smallUrl }}" alt="{{ strip_tags($orderProduct->products->name  ) }}" width="100px">
                        {{ strip_tags($orderProduct->products->name  ) }} {{ $orderProduct->products->sku ? '(' . $orderProduct->products->sku . ')' : '' }}
                        @if($orderProduct->size != null)
                            Size: {{ $orderProduct->size }}
                        @endif
                        @if($orderProduct->color != null)
                            Color: {{ $orderProduct->color }}
                        @endif
                    </td>
                    <td style="padding-top:30px;">{{ $orderProduct->qty }}</td>
                </tr>


            
            </tbody>
        </table>

        <span class="text-center invoice--bottom">
            For return/refund or any queries call us at 
            <span class="invoice--phoneno">{{ getConfiguration('site_primary_phone') }}</span>, or email us at <span class="invoice--email">{{ getConfiguration('site_primary_email') }}</span>
        </span>
    </div>
@endsection