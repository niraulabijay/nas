@extends('admin.layouts.app')
@section('title', 'Edit Order Return')

@section('content')

    @include('partials.message-success')
    @include('partials.message-error')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <h3>Edit Order Returns</h3>
            {!! Form::model($order_return, ['route' => 'admin.order_return.update', 'method' => 'PATCH', 'class' => 'form-order']) !!}
            <input type="hidden" name="id" value="{{ $order_return->id }}">
            <div class="col-md-12">
                <div class="callout callout-danger mb-15"></div>
                <div class="callout callout-success mb-15"></div>
                <div class="content__box content__box--shadow">
                    <div class="box-header with-border">
                        <h3 class="box-title">Order Return Details</h3>
                        @if(isset($products))
                            <a href="{{ route('admin.order.invoice', $order->id) }}" class="btn btn-default pull-right" title="Generate a pdf invoice" target="_blank">
                                <i class="fa fa-print"></i> Print Invoice
                            </a>
                        @endif
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <div class="col-md-5">
                            <h4>General Details</h4>

                            <div class="form-group{{ $errors->has('order_date') ? ' has-error' : '' }}">
                                {!! Form::label('order_date','Order Date', ['class' => 'control-label']) !!}
                                {!! Form::text('order_date',isset($order_return->created_at) ? \Carbon\Carbon::parse($order_return->created_at)->format('d/m/Y') : null, ['class'=> 'form-control', 'placeholder' => 'Order Date']) !!}

                                @if ($errors->has('order_date'))
                                    <span class="help-block">
                                        {{ $errors->first('order_date') }}
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('order_return_status') ? ' has-error' : '' }}">
                                {!! Form::label('order_return_status','Order Return Status', ['class' => 'control-label']) !!}
                                {{ Form::select('order_return_status', $orderReturnStatuses, isset($order_return->status_id) ? $order_return->status_id : null, ['class' => 'form-control select2']) }}

                                @if ($errors->has('order_return_status'))
                                    <span class="help-block">
                                        {{ $errors->first('order_return_status') }}
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('customer') ? ' has-error' : '' }}">
                                {!! Form::label('customer','Customer', ['class' => 'control-label']) !!}
                                {{ Form::select('customer', isset($order_return->users->user_name) ? [$order_return->users->user_name ] : [], isset($order_return->user_id) ? $order_return->user_id : null, ['class' => 'form-control', 'disabled']) }}

                                @if ($errors->has('customer'))
                                    <span class="help-block">
                                        {{ $errors->first('customer') }}
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('return_option') ? ' has-error' : '' }}">
                                {!! Form::label('return_option','Return Option', ['class' => 'control-label']) !!}
                                {{ Form::select('return_option', ['RETURN' => 'RETURN', 'REFUND' => 'REFUND'], isset($order_return->user_option) ? $order_return->user_option : null, ['class' => 'form-control']) }}

                                @if ($errors->has('return_option'))
                                    <span class="help-block">
                                        {{ $errors->first('return_option') }}
                                    </span>
                                @endif
                            </div>

                        </div>
                        <div class="col-md-7">
                            <h4>Address Details</h4>
                            <div class="address-details">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                            {!! Form::label('first_name','First Name', ['class' => 'control-label']) !!}
                                            {!! Form::text('first_name',isset($order_return->users->addresses->first()->first_name) ? $order_return->users->addresses->first()->first_name : null, ['class'=> 'form-control']) !!}

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
                                            {!! Form::text('last_name',isset($order_return->users->addresses->first()->last_name) ? $order_return->users->addresses->first()->last_name : null, ['class'=> 'form-control']) !!}

                                            @if ($errors->has('last_name'))
                                                <span class="help-block">
                                                    {{ $errors->first('last_name') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            {!! Form::label('email','Email', ['class' => 'control-label']) !!}
                                            {!! Form::text('email',isset($order_return->users->email) ? $order_return->users->email : null, ['class'=> 'form-control']) !!}

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    {{ $errors->first('email') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('zone') ? ' has-error' : '' }}">
                                            {!! Form::label('zone','Zone', ['class' => 'control-label']) !!}
                                            {!! Form::text('zone',isset($order_return->users->addresses->first()->zone) ? $order_return->users->addresses->first()->zone : null, ['class'=> 'form-control']) !!}

                                            @if ($errors->has('zone'))
                                                <span class="help-block">
                                                    {{ $errors->first('zone') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('district') ? ' has-error' : '' }}">
                                            {!! Form::label('district','District', ['class' => 'control-label']) !!}
                                            {!! Form::text('district',isset($order_return->users->addresses->first()->district) ? $order_return->users->addresses->first()->district : null, ['class'=> 'form-control']) !!}

                                            @if ($errors->has('district'))
                                                <span class="help-block">
                                                    {{ $errors->first('district') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('area') ? ' has-error' : '' }}">
                                            {!! Form::label('area','Area', ['class' => 'control-label']) !!}
                                            {!! Form::text('area',isset($order_return->users->addresses->first()->area) ? $order_return->users->addresses->first()->area : null, ['class'=> 'form-control']) !!}

                                            @if ($errors->has('area'))
                                                <span class="help-block">
                                                    {{ $errors->first('area') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                            {!! Form::label('mobile','Mobile', ['class' => 'control-label']) !!}
                                            {!! Form::text('mobile',isset($order_return->users->addresses->first()->mobile) ? $order_return->users->addresses->first()->mobile : null, ['class'=> 'form-control']) !!}

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
                                            {!! Form::text('phone',isset($order_return->users->addresses->first()->phone) ? $order_return->users->addresses->first()->phone : null, ['class'=> 'form-control']) !!}

                                            @if ($errors->has('phone'))
                                                <span class="help-block">
                                                    {{ $errors->first('phone') }}
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
                <!-- /.box -->
                <div class="content__box content__box--shadow">
                    <div class="box-header with-border">
                        <h3 class="box-title">Product Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <table class="table table-hover table-order">
                            <thead>
                            <tr>
                                <th>Item</th>
                                <th>Cost</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <a href="#">
                                        {{ $order_return->orderReturnProducts->first()->order_product->products->name }}
                                    </a>
                                </td>
                                <td>{{ $order_return->orderReturnProducts->first()->order_product->price }}</td>
                                <td>
                                    <input type="number" min="0" max="{{ $order_return->orderReturnProducts->first()->order_product->qty }}" value="{{ $order_return->orderReturnProducts->first()->qty }}" name="qty" class="form-control">
                                </td>
                                <td>{{ $order_return->orderReturnProducts->first()->order_product->price * $order_return->orderReturnProducts->first()->qty }}</td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="hs-order-data-row">
                            <table class="table-order-summary">
                                <tbody></tbody>
                            </table>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="clearfix"></div>
                </div>
                <!-- /.box -->

                <div class="box">
                    <div class="box-header">
                        {{ Form::submit('Update', array('id' => 'btn-order-save','class' => 'btn btn-danger pull-right', 'data-loading-text' => 'Loading...')) }}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
<script>

    $('.select2').select2();

    //Date picker
    $('#order_date').datepicker({
        autoclose: true,
        format: "dd/mm/yyyy",
        useCurrent: true
    });

    $('#customer').select2({
        placeholder: 'Guest',
        allowClear: true,
        minimumInputLength: 2,
        ajax: {
            url: "",
            dataType: 'json',
            type: 'GET',
            data: function (params) {
                return {
                    q: $.trim(params.term)
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                return {
                    results: data
                };
            },
            cache: true
        }

    }).on('change', function () {
        var user = this.value;

        $.ajax({
            type: "GET",
            url: "",
            data: {user: user},
            beforeSend: function (xhr, settings) {
                //
            },
            success: function (data) {
                $('div.address-details').html(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
            },
            complete: function () {
                //
            }
        });

    });

    $('#products').select2({
        placeholder: 'Select Product',
        minimumInputLength: 2,
        ajax: {
            url: "",
            dataType: 'json',
            type: 'GET',
            data: function (params) {
                return {
                    q: $.trim(params.term)
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                return {
                    results: data
                };
            },
            cache: true
        }

    });

</script>
@endpush