@extends('merchant.layouts.app')

@section('title',"Dashboard")
@section('content')
    <div class="row">
        @if(Session::has('success'))
        <div class="alert alert-success">
            <strong>Success: </strong>{{ Session::get('success') }}
        </div>
        @endif
        <div class="col-md-6">
            <form action="{{ route('vendor.bank.info.store') }}" class="form-group" method="post">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('bank_name') ? 'has-error' : '' }}">
                    <label>Bank Name</label>
                    <input type="text" name="bank_name" class="form-control" placeholder="Enter Bank Name" value="{{ isset($bankInfo)? $bankInfo->bank_name:'' }}">
                    @if($errors->has('bank_name'))
                        <span class="block-quote" style="color: #a94442;">
                            <strong>{{ $errors->first('bank_name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('account_holder') ? 'has-error' : '' }}">
                    <label>Account Holder Name</label>
                    <input type="text" name="account_holder" class="form-control" placeholder="Enter Account Holder Name" value="{{ isset($bankInfo)? $bankInfo->account_holder:'' }}">
                    @if($errors->has('account_holder'))
                        <span class="block-quote" style="color: #a94442;">
                            <strong>{{ $errors->first('account_holder') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('account_number') ? 'has-error' : '' }}">
                    <label>Account Number</label>
                    <input type="text" name="account_number" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder="Enter Account Number" value="{{ isset($bankInfo)? $bankInfo->account_number:'' }}">
                    @if($errors->has('account_number'))
                        <span class="block-quote" style="color: #a94442;">
                            <strong>{{ $errors->first('account_number') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    @if(!isset($bankInfo))
                    <input type="submit" class="btn btn-primary btn-default" value="Confirm">
                    @else
                    <input type="submit" class="btn btn-primary btn-default" value="Update">
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection