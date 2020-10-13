@extends('layouts.app')

@section('title', 'Vendor Details')

@section('content')
	<div class="container">
		<h1 class="text-center">Vendor Details</h1>
		<div class="row">
			<div class="col-md-6">
				<div class="vendor-info-wrapper">
					<h3>Vendor Info</h3>
					<h6>Name: John Doe</h6>
					<h6>Username: John Doe</h6>
					<h6>Email: vendor@gmail.com</h6>
					<h6>Phone: 980......786</h6>
				</div>
			</div>
			<div class="col-md-6">
				<div class="vendor-details-wrapper">
					<h3>Vendor Company Info</h3>
					<h6>Company Name: {{ $vendor_details->name }}</h6>
					<h6>Address: {{ $vendor_details->address }}</h6>
					<h6>Email: {{ $vendor_details->email }}</h6>
					<h6>Phone: {{ $vendor_details->phone }}</h6>
					<h6>Type: {{ $vendor_details->type }}</h6>
					<h6>Pan No: {{ $vendor_details->pan_number }}</h6>
					<h6>Description: {{ $vendor_details->description }}</h6>
				</div>
			</div>
			<div class="col-md-12">
				<div class="vendor-documents-wrapper">
					<h3 class="text-center">Vendor Documents</h3>
					<div class="row">
						<div class="col-md-4">
							<h6>Citizenship</h6>
							<img src="http://3.bp.blogspot.com/-ihnOhmTksHg/Vo2nUqeRYgI/AAAAAAAAADA/tPrdrTXGQjY/s1600/images%2B%25286%2529.jpg" class="img-responsive img-circle" style="max-width: 100%">
						</div>
						<div class="col-md-4">
							<h6>Registration Certificate</h6>
							<img src="http://registrationsindia.com/media/2016/06/Certificate-of-Incorporation-sample-Image.png" alt="" class="img-responsive" style="max-width: 100%">
						</div>
						<div class="col-md-4">
							<h6>Citizenship</h6>
							<img src="http://3.bp.blogspot.com/-ihnOhmTksHg/Vo2nUqeRYgI/AAAAAAAAADA/tPrdrTXGQjY/s1600/images%2B%25286%2529.jpg" class="img-responsive img-circle" style="max-width: 100%">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection