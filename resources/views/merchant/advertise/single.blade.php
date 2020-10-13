@extends('merchant.layouts.app')

@section('title',"Single page")



@section('content')
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<legend>Advertise Detail</legend>
			name:{{ $advertise->title }}
		</div>
	</div>
@endsection

@push('scripts')
@endpush