@extends('merchant.layouts.app')

@section('title',"Withdraw")

@section('content')
	@if(Session::has('success'))
		<div class="alert alert-success">
			<strong>Success: </strong>{{ Session::get('success') }}
		</div>
	@endif
	@if(count($errors) > 0)
		@foreach($errors->all() as $error)
			{{ $error }}
		@endforeach
	@endif

	<div style="margin-top: 20px;">
		<div style="display: flex;justify-content: space-between;align-items: center;">
			<h1>Withdraw Form</h1>
			<a href="{{ route('vendor.withdraw') }}" class="btn btn-danger btn-sm">Back</a>
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-8 col-xs-offset-2">
				<form action="{{ route('vendor.withdraw.store') }}" method="post">
					{{ csrf_field() }}
					<input type="hidden" name="approve" value="0">
					<div class="form-group">
						<label for="">Withdraw Amount*</label>
						<div class="input-group">
					      <div class="input-group-addon">Rs.</div>
					      <input type="text" class="form-control" name="amount" placeholder="Withdraw amount" value="{!! old('amount') !!}">
					      <div class="input-group-addon">.00</div>
					    </div>
					</div>
					<div class="form-group">
						<label for="">Bank Name*</label>
						<input type="tetx" class="form-control" name="bank_name" placeholder="Bank Name" value="{{ (isset($vendor) && $vendor->bank_name != null) ? $vendor->bank_name : old('bank_name') }}">
					</div>
					<div class="form-group">
						<label for="">Account no.*</label>
						<input type="text" class="form-control" name="account_no" placeholder="Account number" value="{{ (isset($vendor) && $vendor->bank_account_number != null) ? $vendor->bank_account_number : old('account_no') }}">
					</div>
					<div class="form-group">
						<label for="">Account Name*</label>
						<input type="text" class="form-control" name="account_name" placeholder="Account name" value="{{ (isset($vendor) && $vendor->bank_account_name != null) ? $vendor->bank_account_name : old('account_name') }}">
					</div>
					<div class="form-group">
						<label for="">Bank Branch*</label>
						<input type="text" class="form-control" name="bank_branch" placeholder="Account address" value="{{ (isset($vendor) && $vendor->bank_branch != null) ? $vendor->bank_branch : old('bank_branch') }}">
					</div>
					<div class="form-group">
						<label for="">Additional Reference</label>
						<textarea name="reference" cols="30" rows="10" class="form-control" placeholder="Additional Reference (Optional)" value="{!! old('reference') !!}"></textarea>
					</div>

					<input type="submit" name="submit" value="Withdraw Now" class="btn btn-primary btn-block">
				</form>
			</div>
		</div>
	</div>
@endsection