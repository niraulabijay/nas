<!DOCTYPE html>
<html lang="en">
<head>
	<title>Vendor | @yield('title')</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	@include('admin.partials.stylesheets')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.40/css/uikit.min.css" />

	@stack('styles')
	<style>
		.alert-message{
			display: none;
		}
	</style>
</head>
<body>
<div class="container-fluid">

@include('merchant.partials.header')
@include('merchant.partials.sidebar')
	<div class="containers">
		<div id="page-wrapper">

		@if( ! Auth::user()->vendorDetails->pan_number )
			<div class="alert alert-danger ">
					Your Account is Not Verified  .. <a href="/complete_vendor_registration">Click Here</a>  to complete Document.
				</div>
			
				@endif
						   @if(Auth::user()->vendorDetails->verified == 0)
				<div class="alert alert-danger ">
					Please wait For Approval					</div>
				@endif
		    <div class="alert alert-danger alert-message">
			</div>
			<div class="alert alert-success alert-message">
			</div>
			@yield('content')
		</div>
	</div>
	@include('merchant.partials.footer')
</div>



</body>
<!-- UIkit JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.40/js/uikit.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.40/js/uikit-icons.min.js"></script>


@include('admin.partials.scripts')
@stack('scripts')

</html>