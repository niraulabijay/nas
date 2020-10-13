<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title text-center" id="exampleModalLabel">Edit Category</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form id="catgoryUpdate">
				{{ csrf_field() }}
				<input type="hidden" name="id" value="{{ $categorye->id }}">
				
				<div class="form-group">
					<label for="name">Category Name:</label><br><br>
					<input type="text" name="name" class="form-control" value="{{ $categorye->name }}">
				</div>
			
				<div class="form-group">
					<label for="parent_id">Select Parent Catgory:</label>
					<select name="parent_id" class="form-control">
						<option value="0">Select Main Category</option>
						@foreach($categories as $category)
							<option @if($categorye->parent_id ==  $category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
							@include('admin.category.dropdown')
						@endforeach
					</select>
				</div>
				
				<div class="form-group">
				<label for="image">Image</label>
				<input type="file" name="image" class="form-control">
				
				@if($categorye->image)
				<img src="{{ asset($categorye->image) }}" style="width:150px;">
				@endif
			</div>
				
					<div class="form-group">
					<label for="description">Meta Title:</label>
					<input type="text" name="title" class="form-control" value="{{ $categorye->title }}">
				</div>
					<div class="form-group">
					<label for="description">Meta Description:</label>
					<textarea name="description" rows="7" placeholder="About this category" class="form-control">{{$categorye->description}}</textarea>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary category-update">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>
