@extends('admin.layouts.app')
@section('title', 'Request Product')

@section('content')

	@if(Session::has('success'))
		<div class="alert alert-success">
			<strong>Success: </strong>{{ Session::get('success') }}
		</div>
	@endif
	
	<div class="row">
		<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-offset-8 col-xs-offset-2">
			<h3 style="text-align: center;">Edit Request Product</h3>
			<form action="{{ route('admin.request_product.update', $request->id) }}" method="post">
				{{ csrf_field() }}
				<div class="form-group {{ $errors->has('name') ? 'has-error':'' }}">
					<label for="name">Name*</label>
					<input type="text" name="name" id="name" placeholder="Enter your name" class="form-control" value="{{ $request->name }}">
					@if($errors->has('name'))
                        <div class="help-blok" style="color: #a94442;">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
				</div>
				<div class="form-group {{ $errors->has('email') ? 'has-error':'' }}">
					<label for="email">Email*</label>
					<input type="email" name="email" id="email" placeholder="Example@gmail.com" class="form-control" value="{{ $request->email }}">
					@if($errors->has('email'))
                        <div class="help-blok" style="color: #a94442;">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif
				</div>
				<div class="form-group {{ $errors->has('phone') ? 'has-error':'' }}">
					<label for="phone">Phone*</label>
					<div class="input-group">
						<div class="input-group-addon">+977</div>
						<input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" name="phone" placeholder="Enter valid phone number (only Nepal)" value="{{ $request->phone }}">
					</div>
					@if($errors->has('phone'))
                        <div class="help-blok" style="color: #a94442;">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </div>
                    @endif
				</div>
				<div class="form-group {{ $errors->has('title') ? 'has-error':'' }}">
					<label for="title">Product Title*</label>
					<input type="text" name="title" id="title" placeholder="Enter product title" class="form-control"  value="{{ $request->product_title }}">
					@if($errors->has('title'))
                        <div class="help-blok" style="color: #a94442;">
                            <strong>{{ $errors->first('title') }}</strong>
                        </div>
                    @endif
				</div>
				<div class="form-group {{ $errors->has('product_specification') ? 'has-error':'' }}">
					<label for="pro_specification">Product Specification*</label>
					<textarea name="product_specification" id="pro_specification" cols="100" rows="5" class="form-control" placeholder="Let us know the product specification">{{ $request->product_specification }}</textarea>
					@if($errors->has('product_specification'))
                        <div class="help-blok" style="color: #a94442;">
                            <strong>{{ $errors->first('product_specification') }}</strong>
                        </div>
                    @endif
				</div>
				<div class="form-group {{ $errors->has('reference') ? 'has-error':'' }}">
					<label for="reference">Product Reference Link</label>
					<input type="text" name="reference" id="reference" placeholder="Did you see this product in any social site or e-commerce site? (Optional)" class="form-control" value="{{ $request->product_reference }}">
					@if($errors->has('reference'))
                        <div class="help-blok" style="color: #a94442;">
                            <strong>{{ $errors->first('reference') }}</strong>
                        </div>
                    @endif
				</div>
				<div class="form-group {{ $errors->has('category') ? 'has-error':'' }}">
					<label for="category">Category*</label>
					<input type="text" name="category" id="category" placeholder="Enter product category" class="form-control" value="{{ $request->product_category }}">
					@if($errors->has('category'))
                        <div class="help-blok" style="color: #a94442;">
                            <strong>{{ $errors->first('category') }}</strong>
                        </div>
                    @endif
				</div>
				<input type="submit" name="submit" value="Update Request" class="btn btn-primary btn-xs">
			</form>
		</div>
	</div>
@endsection