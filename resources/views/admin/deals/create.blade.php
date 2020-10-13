@extends('admin.layouts.app')
@section('title', 'Deal')

@section('content')
	@if(count($errors)>0)
		<div class="alert alert-danger">
			<ul>
				@foreach($errors->all() as $e)
					<li> {{ $e }}</li>
				@endforeach
			</ul>

		</div>
	@endif

	@include('partials.message-success')
	@include('partials.message-error')

	<section>
		<div class="row">
			<h3>Add Home Product Title</h3>
			<div class="col-xs-12">
				{!! Form::open(['method' => 'POST', 'route' => 'admin.deals.store']) !!}
				@include('admin.deals.form', ['submitButtonText' => 'Submit'])
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@endsection