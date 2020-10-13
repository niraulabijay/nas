
	<div class="col-xs-12">
		<form method="post" enctype="multipart/form-data" id="vendorDetails">
			{{csrf_field()}}
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" id="name" class="form-control">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" name="email" id="email" class="form-control">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="phone">Phone</label>
						<input type="text" name="phone" id="phone" class="form-control">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="address">Address</label>
						<input type="text" name="address" id="address" class="form-control">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="type">Type</label>
						<input type="text" name="type" id="type" class="form-control">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="pan_number">Pan No</label>
						<input type="text" name="pan_number" id="pan_number" class="form-control">
					</div>
				</div>
				{{-- <div class="col-md-6">
					<div class="form-group">
						<label for="logo">Logo</label>
						<input type="file" name="logo" id="logo" class="form-control">
					</div>
				</div> --}}
				<div class="col-md-6">
					<div class="form-group">
						<label for="seo_keywords">Seo Keywords</label>
						<input type="text" name="seo_keywords" id="seo_keywords" class="form-control">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="seo_description">Seo Description</label>
						<input type="text" name="seo_description" id="seo_description" class="form-control">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="description">Description</label>
						<textarea name="description" id="description" class="form-control" rows="5"></textarea>
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary btn-xs text-center btn-vendor-details-add">Submit</button>
		</form>
	</div>
