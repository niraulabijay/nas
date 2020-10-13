@extends('admin.layouts.app')

@section('title',"Type")

@section('content')
	<div class="row">
		<h3>All Types</h3>
		<div class="col-md-12 content__box content__box--shadow">
			<table class="table table-horizontal table-striped table-hover table-condensed" id="typeTable">
				<thead>
					<tr>
						<th>SN</th>
						<th>Type</th>
						<th>Size</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($types as $type)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $type->type }}</td>
						<td>{{ $type->size }}</td>
						<td>
							<a href="{{ route('admin.type.edit',$type->id) }}" class="btn btn-xs btn-default"><span class="lnr lnr-pencil"></span></a>
							<form id="delete-form-{{ $type->id }}" action="{{ route('admin.type.destroy',$type->id) }}" method="post" style="display: none;">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}
							</form>
							<a href="" onclick="
							if (confirm('Are you sure! You want to delete this type.')) 
							{
								event.preventDefault();document.getElementById('delete-form-{{ $type->id }}').submit();
							}
							else
							{
								event.preventDefault();
							}
							" class="btn btn-xs btn-default"><span class="lnr lnr-trash"></span></a>
						</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<th>SN</th>
						<th>Type</th>
						<th>Size</th>
						<th>Action</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
@endsection

@push('scripts')
<script>
	$(document).ready(function() {
		$("#typeTable").DataTable();
	});
</script>
@endpush