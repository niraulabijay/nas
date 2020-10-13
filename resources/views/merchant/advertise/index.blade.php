@extends('merchant.layouts.app')

@section('title',"Advertise")

@push('stylesheets')
<style>
	table>tbody>tr>td>img{
		max-width: 80px;
		max-height: 80px;
	}
</style>
@endpush

@section('content')
	<div class="row">
		<h3>All Advertises</h3>
		<div class="col-md-12 content__box content__box--shadow">
			<table class="table table-horizontal table-striped table-hover table-condensed" id="advertiseTable">
				<thead>
					<tr>
						<th>SN</th>
						<th>Image</th>
						<th>Title</th>
						<th>package</th>
						<th>Area</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($advertises as $ads)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>
							@if($ads->image)
							<a href="{{ asset('storage').'/'.$ads->image }}" class="product-img-zoom">	
							<img src="{{ asset('storage').'/'.$ads->image }}" alt="{{ $ads->title }}" style="width: 50px;height: auto"/>
							</a>
						
							@endif
						</td>
						<td>{{ $ads->title }}</td>
						<td>
							@if($ads->package)
							{{ App\Model\Package::where('id', $ads->package)->first()->period}}
							@endif
						</td>
						<td>
							@if($ads->advertise_area)
							{{ App\Model\Area::where('id', $ads->advertise_area)->first()->area }}
							@endif
						</td>
						<td><span class="label label-{{\App\Model\WithdrawStatus::where('id',$ads->status)->first()->status}}">{{\App\Model\WithdrawStatus::where('id',$ads->status)->first()->status}}</span></td>
						<td>
							<a href="{{ route('vendor.advertise.edit',$ads->id) }}" class="btn btn-xs btn-default"><span class="lnr lnr-pencil"></span></a>
							<form id="delete-form-{{ $ads->id }}" action="{{ route('vendor.advertise.destroy',$ads->id) }}" method="post" style="display: none;">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}
							</form>
							<a href="" onclick="
							if (confirm('Are you sure! You want to delete this area.')) 
							{
								event.preventDefault();document.getElementById('delete-form-{{ $ads->id }}').submit();
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
						<th>Image</th>
						<th>Title</th>
						<th>package</th>
						<th>Area</th>
						<th>Status</th>
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
		$('#advertiseTable').DataTable({
			"columnDefs": [ {
				"targets": 1,
				"orderable": false,
				"visible": true
			} ]
		});
	});
	
</script>
  <script>
        $('.product-img-zoom').magnificPopup({
            type: 'image'
            // other options
        });
    </script>

@endpush