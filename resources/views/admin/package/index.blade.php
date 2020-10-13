@extends('admin.layouts.app')

@section('title',"Package")

@section('content')
	<div class="row">
		<h3>All Package</h3>
		<div class="col-md-12 content__box content__box--shadow">
			<table class="table table-horizontal table-striped table-hover table-condensed" id="packageTable">
				<thead>
					<tr>
						<th>SN</th>
						<th>Period</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($packages as $package)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $package->period }}</td>
						<td>
							<a href="{{ route('admin.package.edit',$package->id) }}" class="btn btn-xs btn-default"><span class="lnr lnr-pencil"></span></a>
							<form id="delete-form-{{ $package->id }}" action="{{ route('admin.package.destroy',$package->id) }}" method="post" style="display: none;">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}
							</form>
							<a href="" onclick="
							if (confirm('Are you sure! You want to delete this package.')) 
							{
								event.preventDefault();document.getElementById('delete-form-{{ $package->id }}').submit();
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
						<th>Period</th>
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
		$('#packageTable').DataTable();
	});
</script>
@endpush