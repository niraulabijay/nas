<div class="content__box content__box--shadow">
    <div class="form-group @if ($errors->has('name')) has-error @endif">
        <div class="row">
        <div class="col-sm-2 text-right">
            {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
            <span class="text-danger"> *</span>
        </div>
        <div class="col-sm-10">
            {!! Form::text('name',null, ['class'=> 'form-control', 'placeholder' => 'Enter Name']) !!}
            @if ($errors->has('name'))
                <span class="help-block">
                    {{ $errors->first('name') }}
                </span>
            @endif
        </div>
        </div>
    </div>

    <div class="form-group @if ($errors->has('description')) has-error @endif">
        <div class="row">
        <div class="col-sm-2 text-right">
            {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}
        </div>
        <div class="col-sm-10">
            {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 5, 'placeholder' => 'Enter Description']) }}
            @if ($errors->has('description'))
                <span class="help-block">
                    {{ $errors->first('description') }}
                </span>
            @endif
        </div>
        </div>
    </div>

    <div class="form-group @if ($errors->has('code')) has-error @endif">
        <div class="row">
        <div class="col-sm-2 text-right">
            {!! Form::label('code', 'Code', ['class' => 'control-label']) !!}
        </div>
        <div class="col-sm-10">
            {!! Form::text('code',null, ['class'=> 'form-control', 'placeholder' => 'Enter coupon code']) !!}
            @if ($errors->has('code'))
                <span class="help-block">
                    {{ $errors->first('code') }}
                </span>
            @endif
        </div>
        </div>
    </div>

    <div class="form-group @if ($errors->has('discount_value')) has-error @endif">
        <div class="row">
        <div class="col-sm-2 text-right">
            {!! Form::label('discount_value', 'Discount Value', ['class' => 'control-label']) !!}
            <span class="text-danger"> *</span>
        </div>
        <div class="col-sm-10">
            {!! Form::text('discount_value',null, ['class'=> 'form-control', 'placeholder' => 'Enter Discount Value']) !!}
            @if ($errors->has('discount_value'))
                <span class="help-block">
                    {{ $errors->first('discount_value') }}
                </span>
            @endif
        </div>
        </div>
    </div>

    {{--<div class="form-group @if ($errors->has('max_discount_value')) has-error @endif">--}}
        {{--<div class="row">--}}
            {{--<div class="col-sm-2 text-right">--}}
                {{--{!! Form::label('max_discount_value', 'Max Discount Value', ['class' => 'control-label']) !!}--}}
                {{--<span class="text-danger"> *</span>--}}
            {{--</div>--}}
            {{--<div class="col-sm-10">--}}
                {{--{!! Form::text('max_discount_value',null, ['class'=> 'form-control', 'placeholder' => 'Enter Discount Value']) !!}--}}
                {{--@if ($errors->has('max_discount_value'))--}}
                    {{--<span class="help-block">--}}
                    {{--{{ $errors->first('max_discount_value') }}--}}
                {{--</span>--}}
                {{--@endif--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="form-group @if ($errors->has('start_date')) has-error @endif">
        <div class="row">
        <div class="col-sm-2 text-right">
            {!! Form::label('start_date', 'Start Date', ['class' => 'control-label']) !!}
            <span class="text-danger"> *</span>
        </div>
        <div class="col-sm-10">
            {!! Form::date('start_date',null, ['class'=> 'form-control', 'placeholder' => 'Enter Start Date']) !!}
            @if ($errors->has('start_date'))
                <span class="help-block">
                    {{ $errors->first('start_date') }}
                </span>
            @endif
        </div>
        </div>
    </div>

    <div class="form-group @if ($errors->has('end_date')) has-error @endif">
        <div class="row">
            <div class="col-sm-2 text-right">
                {!! Form::label('end_date', 'End Date', ['class' => 'control-label']) !!}
                <span class="text-danger"> *</span>
            </div>
            <div class="col-sm-10">
                {!! Form::date('end_date',null, ['class'=> 'form-control', 'placeholder' => 'Enter End Date']) !!}
                @if ($errors->has('end_date'))
                    <span class="help-block">
                    {{ $errors->first('end_date') }}
                </span>
                @endif
            </div>
        </div>
    </div>

    <div class="form-group @if ($errors->has('category')) has-error @endif">
        <div class="row">
        <div class="col-sm-2 text-right">
            {!! Form::label('category', 'Categories', ['class' => 'control-label']) !!}
        </div>
        <div class="col-sm-10">
            {{ Form::select('category', ['' => 'Select Options', 'Category' => $categories], null, ['class' => 'form-control select2']) }}
            <p><i>Choose specific categories the coupon will apply to. </i></p>
            @if ($errors->has('category'))
                <span class="help-block">
                    {{ $errors->first('category') }}
                </span>
            @endif
        </div>
        </div>
    </div>

    <div class="form-group @if ($errors->has('brand')) has-error @endif">
        <div class="row">
        <div class="col-sm-2 text-right">
            {!! Form::label('brand', 'Brands', ['class' => 'control-label']) !!}
        </div>
        <div class="col-sm-10">
            {{ Form::select('brand', ['' => 'Select Options', 'Brand' => $brands], null, ['class' => 'form-control select2']) }}
            <p><i>Choose specific brands the coupon will apply to.</i></p>
            @if ($errors->has('brand'))
                <span class="help-block">
                    {{ $errors->first('brand') }}
                </span>
            @endif
        </div>
        </div>
    </div>

    <div class="form-group @if ($errors->has('product')) has-error @endif">
        <div class="row">
        <div class="col-sm-2 text-right">
            {!! Form::label('product', 'Products', ['class' => 'control-label']) !!}
        </div>
        <div class="col-sm-10">
            {{ Form::select('product[]', $products, null, ['class' => 'form-control select2', 'multiple' => 'multiple']) }}
            <p><i>Choose specific products the coupon will apply to.</i></p>
            @if ($errors->has('product'))
                <span class="help-block">
                    {{ $errors->first('product') }}
                </span>
            @endif
        </div>
        </div>
    </div>
    
    <div class="form-group @if ($errors->has('vendor')) has-error @endif">
        <div class="row">
        <div class="col-sm-2 text-right">
            {!! Form::label('vendor', 'Vendors', ['class' => 'control-label']) !!}
        </div>
        <div class="col-sm-10">
            {{ Form::select('vendor', ['' => 'Select Options', 'Vendor' => $vendors], null, ['class' => 'form-control select2']) }}
            <p><i>Choose specific vendor the coupon will apply to.</i></p>
            @if ($errors->has('vendor'))
                <span class="help-block">
                    {{ $errors->first('vendor') }}
                </span>
            @endif
        </div>
        </div>
    </div>

    <div class="form-group @if ($errors->has('uses_per_coupon')) has-error @endif">
        <div class="row">
        <div class="col-sm-2 text-right">
            {!! Form::label('uses_per_coupon', 'Uses Per Coupon', ['class' => 'control-label']) !!}
            <span class="text-danger"> *</span>
        </div>
        <div class="col-sm-10">
            {!! Form::text('uses_per_coupon',null, ['class'=> 'form-control', 'placeholder' => 'Enter Uses Value']) !!}
            <p><i>Maximum number of times a coupon can be used by any customer.</i></p>
            @if ($errors->has('uses_per_coupon'))
                <span class="help-block">
                    {{ $errors->first('uses_per_coupon') }}
                </span>
            @endif
        </div>
        </div>
    </div>

    {!! Form::submit($submitBtn, ['class'=>'btn btn-primary btn-xs pull-right']) !!}
    <div class="clearfix"></div>
</div>