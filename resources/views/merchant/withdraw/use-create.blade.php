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
			<div class="huge text-center">Withdraw Form</div>
			<a href="{{ route('vendor.withdraw.account') }}" class="btn btn-danger btn-sm">Back</a>
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-8 col-xs-offset-2">
				<form action="{{ route('vendor.withdraw.store') }}" method="post">
					{{ csrf_field() }}
					<input type="hidden" name="approve" value="{{$details->approve}}">
					<div class="form-group">
						<label for="">Withdraw Amount*</label>
						<div class="input-group">
							<div class="input-group-addon">Rs.</div>
							<input type="text" class="form-control" name="amount" placeholder="Withdraw amount">
							<div class="input-group-addon">.00</div>
						</div>
					</div>
					<div class="form-group">
						<label for="">Withdraw Method*</label>
						<input type="text" name="method" class="form-control use-withdraw" placeholder="Enter Your Bank Name" value="{{$details->method}}" readonly>
					</div>
					<div class="form-group">
						<label for="">email*</label>
						<input type="email" class="form-control use-withdraw" name="email" placeholder="Account email address" value="{{$details->email}}"  readonly>
					</div>
					<div class="form-group">
						<label for="">Account no.*</label>
						<input type="text" class="form-control use-withdraw" name="account_no" placeholder="Account number" value="{{$details->account_no}}"  readonly>
					</div>
					<div class="form-group">
						<label for="">Account Name*</label>
						<input type="text" class="form-control use-withdraw" name="account_name" placeholder="Account name" value="{{$details->account_name}}"  readonly>
					</div>
					<div class="form-group">
						<label for="">Account Address*</label>
						<input type="text" class="form-control use-withdraw" name="account_address" placeholder="Account address" value="{{$details->account_address}}"  readonly>
					</div>
					<div class="form-group">
						<label for="">Additional Reference</label>
						<textarea name="reference" cols="30" class="form-control use-withdraw" placeholder="Additional Reference (Optional)"  readonly>{{$details->additional_references}}</textarea>
					</div>

					<input type="submit" name="submit" value="Withdraw Now" class="btn btn-primary btn-block">
				</form>
			</div>
		</div>
	</div>
	<style>
		input.use-withdraw, textarea.use-withdraw{
			border: none;
			background-color: #ecf0f5 !important;
			color: #333;
			box-shadow: none;
		}
		input.use-withdraw:active, input.use-withdraw:focus, input.use-withdraw:hover, input.use-withdraw:visited,
		textarea.use-withdraw:active, textarea.use-withdraw:focus, textarea.use-withdraw:hover, textarea.use-withdraw:visited{
			border: none;
			outline: none !important;
			background-color: #ecf0f5 !important;
			color: #333;
			box-shadow: none;
		}
	</style>
@endsection