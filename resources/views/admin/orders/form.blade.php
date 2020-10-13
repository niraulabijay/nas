<div class="col-md-12">
    <div class="box content__box content__box--shadow">
        <div class="box-header with-border">
            <h3 class="box-title">Order Details</h3>
            @if(isset($products))
                <a href="{{ route('admin.order.invoice', $order->id) }}" class="btn btn-default pull-right" title="Generate a pdf invoice" target="_blank">
                    <i class="fa fa-print"></i> Print Invoice
                </a>
            @endif
        </div>
        <div class="clearfix"></div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            <div class="col-md-5">
                <h4>General Details</h4>

                <div class="form-group{{ $errors->has('order_date') ? ' has-error' : '' }}">
                    {!! Form::label('order_date','Order Date', ['class' => 'control-label']) !!}
                    {!! Form::text('order_date',isset($order->order_date) ? $order->order_date : null, ['class'=> 'form-control', 'placeholder' => 'Order Date']) !!}

                    @if ($errors->has('order_date'))
                        <span class="help-block">
                            {{ $errors->first('order_date') }}
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('order_status') ? ' has-error' : '' }}">
                    {!! Form::label('order_status','Order Status', ['class' => 'control-label']) !!}
                    <!--{{ Form::select('order_status', $orderStatuses, isset($order->order_status_id) ? $order->order_status_id : null, ['class' => 'form-control select2', ]) }}-->
                    <select name="order_status" class="form-control select2">
                        <option value="">Select Order Status</option>
                        @foreach($orderStatuses as $orderStatus)
                            <option value="{{ $orderStatus->id }}" @if(!empty($order)) @if($orderStatus->id == $order->order_status_id) selected @endif @endif >{{ $orderStatus->name }}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('order_status'))
                        <span class="help-block">
                            {{ $errors->first('order_status') }}
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('customer') ? ' has-error' : '' }}">
                    {!! Form::label('customer','Customer', ['class' => 'control-label']) !!}
                    {{ Form::select('customer', isset($userDetails->user_id) ? [$userDetails->user_id => $userDetails->user_first_name . ' ' ] : [], isset($order->user_id) ? $order->user_id : null, ['class' => 'form-control', isset($order->user_id)?'disabled':'']) }}

                    @if ($errors->has('customer'))
                        <span class="help-block">
                            {{ $errors->first('customer') }}
                        </span>
                    @endif
                </div>

                <!--<div class="form-group{{ $errors->has('shipping_amount') ? ' has-error' : '' }}">-->
                <!--    {!! Form::label('shipping_amount','Shipping Amount', ['class' => 'control-label']) !!}-->
                <!--    {{ Form::select('shipping_amount', $shipping_amounts, isset($order->shipping_amount) ? $order->shipping_amount : null, ['class' => 'form-control select2']) }}-->

                <!--    @if ($errors->has('shipping_amount'))-->
                <!--        <span class="help-block">-->
                <!--            {{ $errors->first('shipping_amount') }}-->
                <!--        </span>-->
                <!--    @endif-->
                <!--</div>-->
                 <div class="form-group{{ $errors->has('tracking') ? ' has-error' : '' }}">
                    {!! Form::label('tracking','Live Tracking', ['class' => 'control-label']) !!}
                    {{ Form::textarea('tracking', isset($order->tracking) ? $order->tracking : null, ['class' => 'form-control ']) }}

                    @if ($errors->has('tracking'))
                        <span class="help-block">
                            {{ $errors->first('tracking') }}
                        </span>
                    @endif
                </div>
                @if(!empty($order->payment->name))
                <div class="form-group">
                    <label>Payment Method</label>
                    <input type="text" class="form-control"  value="{{ !empty($order->payment->name) ? $order->payment->name : '' }}" disabled/>
                </div>
                @endif

            </div>
            <div class="col-md-7">
                <h4>Address Details</h4>
                <div class="address-details">
                    <div class="row">
                        <input type="hidden" name="address_id" value="{{ isset($userDetails) ? $userDetails->id : '' }}">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                {!! Form::label('first_name','First Name', ['class' => 'control-label']) !!}
                                {!! Form::text('first_name',isset($userDetails->first_name) ? $userDetails->first_name : null, ['class'=> 'form-control']) !!}

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                    {{ $errors->first('first_name') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                {!! Form::label('last_name','Last Name', ['class' => 'control-label']) !!}
                                {!! Form::text('last_name',isset($userDetails->last_name) ? $userDetails->last_name : null, ['class'=> 'form-control']) !!}

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                    {{ $errors->first('last_name') }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                {!! Form::label('email','Email', ['class' => 'control-label']) !!}
                                {!! Form::text('email',isset($userDetails->email) ? $userDetails->email : null, ['class'=> 'form-control']) !!}

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    {{ $errors->first('email') }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                {!! Form::label('mobile','Mobile', ['class' => 'control-label']) !!}
                                {!! Form::text('mobile',isset($userDetails->mobile) ? $userDetails->mobile : null, ['class'=> 'form-control']) !!}

                                @if ($errors->has('mobile'))
                                    <span class="help-block">
                                    {{ $errors->first('mobile') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                {!! Form::label('phone','Mobile 2', ['class' => 'control-label']) !!}
                                {!! Form::text('phone',isset($userDetails->phone) ? $userDetails->phone : null, ['class'=> 'form-control']) !!}

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                    {{ $errors->first('phone') }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('zone') ? ' has-error' : '' }}">
                                {!! Form::label('zone','Zone', ['class' => 'control-label']) !!}
                                {!! Form::text('zone',isset($userDetails->zone) ? $userDetails->zone : null, ['class'=> 'form-control']) !!}

                                @if ($errors->has('zone'))
                                    <span class="help-block">
                                    {{ $errors->first('zone') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('district') ? ' has-error' : '' }}">
                                {!! Form::label('district','District', ['class' => 'control-label']) !!}
                                {!! Form::text('district',isset($userDetails->district) ? $userDetails->district : null, ['class'=> 'form-control']) !!}

                                @if ($errors->has('district'))
                                    <span class="help-block">
                                    {{ $errors->first('district') }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('area') ? ' has-error' : '' }}">
                                {!! Form::label('area','Area', ['class' => 'control-label']) !!}
                                {!! Form::text('area',isset($userDetails->area) ?$userDetails->area : null, ['class'=> 'form-control']) !!}

                                @if ($errors->has('area'))
                                    <span class="help-block">
                                    {{ $errors->first('area') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <!--<div class="col-md-6">-->
                        <!--    <div class="form-group{{ $errors->has('delivery_destination') ? ' has-error' : '' }}">-->
                        <!--        {!! Form::label('delivery_destination','Delivery Destination', ['class' => 'control-label']) !!}-->
                        <!--        {!! Form::select('delivery_destination', $delivery_destinations, isset($order->delivery_destination_id) ? $order->delivery_destination_id : null, ['class' => 'form-control select2', 'placeholder' => 'Select Delivery Destination']) !!}-->
            
                        <!--        @if ($errors->has('delivery_destination'))-->
                        <!--            <span class="help-block">-->
                        <!--                {{ $errors->first('delivery_destination') }}-->
                        <!--            </span>-->
                        <!--        @endif-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('order_note') ? ' has-error' : '' }}">
                                {!! Form::label('order_note','Order Note', ['class' => 'control-label']) !!}
                                {!! Form::textarea('order_note',isset($order->order_note) ? $order->order_note : null, ['class'=> 'form-control', 'rows' => '5']) !!}

                                @if ($errors->has('order_note'))
                                    <span class="help-block">
                                    {{ $errors->first('order_note') }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <!-- /.box -->
    <div class="box content__box content__box--shadow">
        <div class="box-header with-border">
            <h3 class="box-title">Product Details</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            <table class="table table-hover table-order">
                <thead>
                <tr>
                    <th colspan="2">Item</th>
                    <th>Shop Name</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Cost</th>
                    <th>Quantity</th>
                    <th>Discount (Rs)</th>
                    <th>Tax (%)</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($products))
                    @include('admin.orders.products', ['products' => $products])
                @endif
                </tbody>
            </table>

            <div class="hs-order-data-row">
                <table class="table-order-summary table">
                    <tbody></tbody>
                </table>
                <div class="clear"></div>
            </div>
        </div>
        <!-- /.box-body -->
        @if (Route::currentRouteName() == 'admin.order.create')
        <div class="box-footer">
            <div class="col-sm-6">
                <select name="products" id="products" class="form-control" multiple></select><br><br>
                <button type="button" id="btn-product-add" class="btn btn-danger">Add</button>
            </div>
            <div class="col-sm-6 text-right">
                {{--<button type="button" class="btn btn-default">Add shipping cost</button>--}}
            </div>
        </div>
        @endif
        <div class="clearfix"></div>
    </div>
    <!-- /.box -->

    <div class="box">
        <div class="box-header">
            {{ Form::submit($submitButtonText, array('id' => 'btn-order-save','class' => 'btn btn-danger pull-right', 'data-loading-text' => 'Loading...')) }}
        </div>
    </div>
</div>