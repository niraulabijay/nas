<div class="row">
    <input type="hidden" name="address_id" value="{{ $address->id }}">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
            {!! Form::label('first_name','First Name', ['class' => 'control-label']) !!}
            {!! Form::text('first_name',isset($address->first_name) ? $address->first_name : null, ['class'=> 'form-control']) !!}

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
            {!! Form::text('last_name',isset($address->last_name) ? $address->last_name : null, ['class'=> 'form-control']) !!}

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
            {!! Form::text('email',isset($address->email) ? $address->email : null, ['class'=> 'form-control']) !!}

            @if ($errors->has('email'))
                <span class="help-block">
                    {{ $errors->first('email') }}
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
            {!! Form::label('phone','Phone', ['class' => 'control-label']) !!}
            {!! Form::text('phone',isset($address->phone) ? $address->phone : null, ['class'=> 'form-control']) !!}

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
        <div class="form-group{{ $errors->has('address1') ? ' has-error' : '' }}">
            {!! Form::label('address1','Address Line 1', ['class' => 'control-label']) !!}
            {!! Form::text('address1',isset($address->address1) ? $address->address1 : null, ['class'=> 'form-control']) !!}

            @if ($errors->has('address1'))
                <span class="help-block">
                    {{ $errors->first('address1') }}
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('address2') ? ' has-error' : '' }}">
            {!! Form::label('address2','Address Line 2', ['class' => 'control-label']) !!}
            {!! Form::text('address2',isset($address->address2) ? $address->address2 : null, ['class'=> 'form-control']) !!}

            @if ($errors->has('address2'))
                <span class="help-block">
                    {{ $errors->first('address2') }}
                </span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
            {!! Form::label('country','Country', ['class' => 'control-label']) !!}
            {{ Form::select('country', $countries, 1, ['class' => 'form-control select2', 'disabled' => 'disabled']) }}

            @if ($errors->has('country'))
                <span class="help-block">
                    {{ $errors->first('country') }}
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
            {!! Form::label('state','State', ['class' => 'control-label']) !!}
            {{ Form::select('state', $states, isset($address->state_id) ? $address->state_id: null, ['class' => 'form-control select2']) }}

            @if ($errors->has('state'))
                <span class="help-block">
                    {{ $errors->first('state') }}
                </span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
            {!! Form::label('city','City', ['class' => 'control-label']) !!}
            {!! Form::text('city',isset($address->city) ? $address->city : null, ['class'=> 'form-control']) !!}

            @if ($errors->has('city'))
                <span class="help-block">
                    {{ $errors->first('city') }}
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('postcode') ? ' has-error' : '' }}">
            {!! Form::label('postcode','Postcode / ZIP', ['class' => 'control-label']) !!}
            {!! Form::text('postcode',isset($address->postcode) ? $address->postcode : null, ['class'=> 'form-control']) !!}

            @if ($errors->has('postcode'))
                <span class="help-block">
                    {{ $errors->first('postcode') }}
                </span>
            @endif
        </div>
    </div>
</div>