@extends('admin.layouts.app')
@section('title', 'Home Settings')

@section('content')
	<section>
		<div class="row">
			@include('admin.partials.message-success')
            @include('admin.partials.message-error')
			<h3>Home Settings</h3>
			<div class="content__box content__box--shadow col-xs-12">
				{!! Form::open(['route' => 'admin.home.update', 'method' => 'POST']) !!}
					@include('admin.home.home')
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('.select2').select2({placeholder: 'Select Options'});
        });
    </script>
@endpush