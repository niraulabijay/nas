@extends('admin.layouts.app')

@section('title',"Area")

@section('content')
	<div class="row">
		<h3>All Areas</h3>
		<div class="col-md-12 content__box content__box--shadow">
			<table class="table table-horizontal table-striped table-hover table-condensed" id="areaTable">
				<thead>
					<tr>
						<th>SN</th>
						<th>Area</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($areas as $area)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $area->area }}</td>
						<td>
							<a href="{{ route('admin.area.edit',$area->id) }}" class="btn btn-xs btn-default"><span class="lnr lnr-pencil"></span></a>
							<form id="delete-form-{{ $area->id }}" action="{{ route('admin.area.destroy',$area->id) }}" method="post" style="display: none;">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}
							</form>
							<a href="" onclick="
							if (confirm('Are you sure! You want to delete this area.')) 
							{
								event.preventDefault();document.getElementById('delete-form-{{ $area->id }}').submit();
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
						<th>Area</th>
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
		$('#areaTable').DataTable();
	});
</script>
@endpush