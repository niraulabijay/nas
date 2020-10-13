@extends('admin.layouts.app')
@section('title', 'Product Detail')

@section('content')
<section>
	<div class="row">
		<h3>{{ $products->product_name }}</h3>
		<h5>Rs.{{ $products->product_price }}</h5>
		<h5>Inserted By <b>{{ $user->name }}</b></h5>
		<div class="col-sm-3">
			<img src="{{$products->getImageAttribute()->mediumUrl}}" alt="{{ $products->product_name }}" />
		</div>
		<div class="clearfix"></div>
		<br>
		@if ($products->approved == 1)
			<span class="label label-success">Approved</span>
		@else
			<span class="label label-danger">Pending</span>
		@endif	
	</div>
</section>
@endsection