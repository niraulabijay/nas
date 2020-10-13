@extends('admin.layouts.app')

@section('content')
	@include('partials.message-success')
	@include('partials.message-error')

	<section>
		<div class="row">
			<h3 class="text-center">Add New Slideshow</h3>
			{!! Form::open(['route' => 'admin.slideshow.store', 'method' => 'POST', 'files' => true, 'class' => '']) !!}
            	@include('admin.slideshow.form', ['submitButtonText' => 'Submit'])
            {!! Form::close() !!}
		</div>
	</section>
@endsection