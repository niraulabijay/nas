@extends('admin.layouts.app')
@section('title', 'Create Seo')

@section('content')
	@include('partials.message-success')
	@include('partials.message-error')

	<section>
		<div class="row">
			<h3 class="text-center">Add New Seo</h3>
			{!! Form::open(['route' => 'admin.seo.store', 'method' => 'POST', 'files' => true, 'class' => '']) !!}
            	@include('admin.seos.form', ['submitButtonText' => 'Submit'])
            {!! Form::close() !!}
		</div>
	</section>
@endsection