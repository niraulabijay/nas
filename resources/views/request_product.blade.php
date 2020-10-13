@extends('layouts.app')
@section('content')
	<div class="row  ">
		<!--@if(Session::has('success'))-->
		<!--	<div class="alert alert-success">-->
		<!--		<strong>Success: </strong>{{ Session::get('success') }}-->
		<!--	</div>-->
		<!--@endif-->
		<div class="col-md-6 offset-md-3 col-sm-6 offset-sm-3 col-xs-offset-8 col-xs-offset-2 box-shadow mt-2 mb pb-3" style="background:#fff;margin-bottom: 20px !important;">
		    <div class="py-3">
			<h3 style="text-align: center;">Request Product Form</h3>
			</div>
			<form action="{{ route('request.product') }}" method="post">
				{{ csrf_field() }}
				<div class="form-group {{ $errors->has('name') ? 'has-error':'' }}">
					<!--<label for="name">Name*</label>-->
					<input type="text" name="name" id="name" placeholder="Enter your name" class="uk-input">
					@if($errors->has('name'))
                        <div class="help-blok" style="color: #a94442;">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
				</div>
				<div class="form-group {{ $errors->has('email') ? 'has-error':'' }}">
					<!--<label for="email">Email*</label>-->
					<input type="email" name="email" id="email" placeholder="Example@gmail.com" class="uk-input">
					@if($errors->has('email'))
                        <div class="help-blok" style="color: #a94442;">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif
				</div>
				<div class="form-group {{ $errors->has('phone') ? 'has-error':'' }}">
					<!--<label for="phone">Phone*</label>-->
					<div class="uk-inline" style="width:100%;">
                        <span class="uk-form-icon" >+977</span>
						<input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="uk-input" name="phone" placeholder="Enter valid phone number (only Nepal)">
					</div>
					@if($errors->has('phone'))
                        <div class="help-blok" style="color: #a94442;">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </div>
                    @endif
				</div>
				<div class="form-group {{ $errors->has('title') ? 'has-error':'' }}">
					<!--<label for="title">Product Title*</label>-->
					<input type="text" name="title" id="title" placeholder="Enter product title" class="uk-input">
					@if($errors->has('title'))
                        <div class="help-blok" style="color: #a94442;">
                            <strong>{{ $errors->first('title') }}</strong>
                        </div>
                    @endif
				</div>
				<div class="form-group {{ $errors->has('product_specification') ? 'has-error':'' }}">
					<!--<label for="pro_specification">Product Specification*</label>-->
					<textarea name="product_specification" id="pro_specification" cols="100" rows="3" class="uk-textarea" placeholder="Let us know the product specification"></textarea>
					@if($errors->has('product_specification'))
                        <div class="help-blok" style="color: #a94442;">
                            <strong>{{ $errors->first('product_specification') }}</strong>
                        </div>
                    @endif
				</div>
				<div class="form-group {{ $errors->has('reference') ? 'has-error':'' }}">
					<!--<label for="reference">Product Reference Link</label>-->
					<input type="text" name="reference" id="reference" placeholder="Did you see this product in any social site or e-commerce site? (Optional)" class="uk-input">
					@if($errors->has('reference'))
                        <div class="help-blok" style="color: #a94442;">
                            <strong>{{ $errors->first('reference') }}</strong>
                        </div>
                    @endif
				</div>
				<div class="form-group {{ $errors->has('category') ? 'has-error':'' }}">
					<!--<label for="category">Category*</label>-->
					<input type="text" name="category" id="category" placeholder="Enter product category" class="uk-input">
					@if($errors->has('category'))
                        <div class="help-blok" style="color: #a94442;">
                            <strong>{{ $errors->first('category') }}</strong>
                        </div>
                    @endif
				</div>
				<input type="submit" name="submit" value="Submit Request" class="uk-button btn-success btn-block" style="border-radius:2px;box-shadow:0 2px 4px 0 rgba(0,0,0,.23);">
			</form>
		</div>
	</div>
@endsection