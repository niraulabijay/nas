
	<div class="col-md-4">
		<form action="{{ route('admin.delivery.store') }}" enctype="multipart/form-data" method="post">
			{{csrf_field()}}
			<div class="form-group">
				<label for="name">Name*</label>
				<input type="text" name="name" class="form-control" placeholder="Enter Name" required>
			</div>

			<div class="form-group">
				<label for="remark">Remark (Optional)</label>
				<textarea name="remark" class="form-control"></textarea>
			</div>

			<button type="submit" name="submit">Add Destination</button>
		</form>
	</div>