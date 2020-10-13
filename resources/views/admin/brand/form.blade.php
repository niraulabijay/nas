
	<div class="col-md-4">
		<form action="" enctype="multipart/form-data" id="brandSubmit">
			{{csrf_field()}}
			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" name="name" class="form-control" placeholder="Enter Name" required>
			</div>

			<div class="form-group">
				<label for="image">Image</label>
				<input type="file" name="image" class="form-control">
			</div>

			<div class="form-group">
				<label for="company_name">Company Name</label>
				<input type="text" name="company_name" class="form-control" placeholder="Enter Company Name" value="">
			</div>
			
			<div class="form-group">
				<label for="document">Document Image</label>
				<input type="file" name="document" class="form-control">
			</div>
			
			<div class="form-group">
				<label for="description">Brand Description</label>
				<textarea name="description" class="form-control" placeholder="Enter Description" value="" rows="5"></textarea>
			</div>
			
			<div class="form-group">
				<label for="status">Status</label>
				<select name="status" class="form-control">
				    <option value="1">Approved</option> 
				    <option value="0">Unapproved</option>
				</select>
			</div>

			<button type="submit" name="submit" class="btn-add" d>Add Brand</button>
		</form>
	</div>