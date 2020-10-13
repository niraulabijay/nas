@extends('admin.layouts.app')
@section('title',"Withdraw")
@section('content')
<div class="modal fade" id="quickViewModal" tabindex="-1"></div>
<div style="padding-top: 20px;">
	<h1 style="display: inline-block;">Withdraw Pending</h1>
	@php
		$pending = \App\Model\WithdrawStatus::where('is_default',1)->first()->id;
		$pending_count = \App\Model\WithDraw::where('status',$pending)->count();
		
			
		
	if(!$pending_count == 0){
	echo "<span class='badge badge-default'>". $pending_count ."</span>";
	}
	@endphp
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover" id="withdrawTable">
					<thead>
						<tr>
							<th>S.N.</th>
							<th>Company Name</th>
							<th>Withdraw Amount</th>
							<th>Phone</th>
							<th>Method</th>
							<th>Account Status</th>
							<th>Withdraw Status</th>
							<th>Withdraw Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($withdraws as $withdraw)
						<div style="display: none;">{{ $status = \App\Model\WithdrawStatus::where('id',$withdraw->status)->first()->status }}</div>
						<tr>
							<td>{{ $loop->iteration }}</td>
							
							<td>abc</td>
							<td>{{ $withdraw->amount }}</td>
							<td>{{ \App\User::where('id',$withdraw->vendor_id)->first()->phone }}</td>
							<td>Bank Transfer</td>

							<td>
								@if( $withdraw->approve == 1 )
									<button class="btn btn-primary btn-xs withdraw-verify" data-id="{{$withdraw->id}}">Verify</button>
								@else
									<button class="btn btn-danger btn-xs withdraw-verify" data-id="{{$withdraw->id}}">Non-Verify</button>
								@endif
							</td>
							<td><span style="color:#000;" class="label label-{{ $status }}">{{ $status }}</span></td>
							<td>{{ $withdraw->created_at->diffForHumans() }}</td>
							<td>
								<div style="display: flex;justify-content: space-between;align-items: center;">
									<a href="javascript:void(0);" data-id="{{ $withdraw->id }}" class="btn btn-xs btn-info btn-edit"><i class="fas fa-check"></i> View Details</a>
									<form action="{{ route('admin.withdraw.cancel',$withdraw->id) }}" id="cancel-withdraw-{{ $withdraw->id }}" method="get">
										{{ csrf_field() }}
									</form>
									<a href=""
									   onclick="
											   if(confirm('Are you sure! You want to cancel withdraw.'))
											   {
											   event.preventDefault();document.getElementById('cancel-withdraw-{{ $withdraw->id }}').submit();
											   }
											   else
											   {
											   event.preventDefault();
											   }"
									   class="btn btn-xs btn-danger">Delete</a>

								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function (){
       $('#withdrawTable').DataTable({
           "columnDefs": [
            { "orderable": false, "targets": 5 },
            { "orderable": false, "targets": 7 }
          ]
       }); 
    });

	var $modal = $('#quickViewModal');
	$(document).on("click", ".btn-edit", function (e) {
		e.preventDefault();
		var $this = $(this);
		var id = $this.attr('data-id');
		var viewDetails = "{{ route('admin.withdraw.edit', ':id') }}";                               
		viewDetails = viewDetails.replace(':id', id);
		$modal.load(viewDetails, function (response) {
			$modal.modal({show: true});
		});
	});



//    $('document').ready(function () {
//        $('#withdrawTable').DataTable();
//    });

    $(document).on("click", ".withdraw-verify", function (e) {
        e.preventDefault();
        var $this = $(this);

        var id = $this.attr('data-id');
        var tempUpdateUrl = "{{ route('admin.withdraw.verify', ':id') }}";
        tempUpdateUrl = tempUpdateUrl.replace(':id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: tempUpdateUrl,
//            contentType: false,
//            processData: false,
//            cache: false,
            data: id,
            beforeSend: function (data) {
            },
            success: function (data) {
//                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {

            },
            complete: function () {
                window.location.reload();
            }
        });
    });
</script>
@endpush