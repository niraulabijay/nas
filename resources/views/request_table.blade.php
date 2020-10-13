@extends('admin.layouts.app')
@section('content')
	<div class="row">
		<div class="col-md-12">
			<h3>All Request</h3>
			<div class="table-responsive">
				<table class="table table-striped table-hovered" id="request_product">
					<thead>
						<tr>
							<th>S.N.</th>
							<th>Name</th>
							<th>Email</th>
							<th>Requested Product</th>
							<th>Product Reference</th>
							<th>Product Category</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($requests as $request)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $request->name }}</td>
							<td>{{ $request->email }}</td>
							<td>{{ $request->product_title }}</td>
							<td>{{ $request->product_reference }}</td>
							<td>{{ $request->product_category }}</td>
							<td>
								<form action="{{ route('admin.request.product.delete',$request->id) }}" method="post" id="request-product-{{ $request->id }}" style="display: none;">
									{{ csrf_field() }}
									{{ method_field('DELETE') }}
								</form>
								<a href="#" onclick="
									if(confirm('Are you sure you want to delete this requested product'))
									{
										event.preventDefault();document.getElementById('request-product-{{ $request->id }}').submit();
									}
									else
									{
										event.preventDefault();
									}
								" class="btn btn-xs btn-block btn-danger">Delete</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
@push('scripts')
<script>
$(document).ready( function () {
    $('#request_product').DataTable();
} );
</script>
@endpush