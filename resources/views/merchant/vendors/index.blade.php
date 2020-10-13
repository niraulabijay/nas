@extends('merchant.layouts.app')

@section('title', 'Vendor Panel')

@section('content')
	<div class="modal fade" id="vendorDetailsEditModal" tabindex="-1"></div>

	<section>
		<div class="row">
			@include('merchant.vendors.vendor_details')
			<table class="table table-hover table-striped" id="vendorDetailsTable">
				<thead>
					<tr>
						<th>SN</th>
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Address</th>
						<th>Type</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
				<tfoot>
					<tr>
						<th>SN</th>
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Address</th>
						<th>Type</th>
						<th>Action</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</section>
@endsection

@push('scripts')
<script>
	jQuery(document).ready(function($) {
		$('#vendorDetailsTable').DataTable({
			aaSorting: [0,'desc'],
			processing: true,
            serverSide: true,
			columns: [
				{data: 'id', name: 'id'},
	    		{data: 'name', name: 'name'},
	    		{data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'address', name: 'address'},
                {data: 'type', name: 'type'},
				{
                    data: 'id',
                    orderable: false,
                    render: function (data, type, row) {
                    	var tempViewUrl = "{{ route('vendor.vendors_details.view', ':id') }}"
                        tempViewUrl = tempViewUrl.replace(':id', data);
                        var actions = '';
                  		actions += "<button type='submit' class='btn btn-xs btn-danger btn-vendor-details-edit' data-id=" + row.id + ">Edit</button>";
                  		actions += "<a href=" + tempViewUrl + " class='btn btn-xs btn-warning'>View</a>";
                        actions += "<button type='submit' class='btn btn-xs btn-danger btn-vendor-details-delete' data-id=" + row.id + ">Delete</button>";

                        return actions;
                    }
                }
    		],
			ajax: '{{route('vendor.vendors.json')}}'
		});
	});
</script>
<script>
	$(document).on("click", ".btn-vendor-details-add", function(e) {
		e.preventDefault();
            var params   = $('#vendorDetails').serialize();
            // var formData = new FormData($('#vendorDetails')[0]);
            //     formData.append('image', $('input[type=file]')[0].files[0]);

            // $.each(params, function(i, val) {
            //     formData.append(val.name, val.value);
            // });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('vendor.vendors_details.store')  }}",
                // contentType: false,
                // processData: false,
                // cache: false,
                data: params,
                beforeSend: function (data) {
                },
                success: function (data) {
                        sweetAlert('success', 'Success');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    
                },
                complete: function () {
                	 $("#vendorDetails")[0].reset(),
                	$('#vendorDetailsTable').DataTable().ajax.reload();
                }
            });
        });
</script>
<script>
	$(document).on("click", ".btn-vendor-details-delete", function (e) {
        e.preventDefault();
       if (!confirm('Are you sure you want to delete?')) {
                return false;
            }
        var $this = $(this);
        var id = $this.attr('data-id');
     	var tempDeleteUrl = "{{ route('vendor.vendors_details.delete', ':id') }}";
     	tempDeleteUrl = tempDeleteUrl.replace(':id', id);        
     	$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "GET",
                url: tempDeleteUrl,
                data: id,
                beforeSend: function (data) {
                },
                success: function (data) {
                    sweetAlert('success', 'Success');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    
                },
                complete: function () {
                	$('#vendorDetailsTable').DataTable().ajax.reload();
                }
            });
    });
</script>
<script>
	var $modal = $('#vendorDetailsEditModal');
	$(document).on("click", ".btn-vendor-details-edit", function (e) {
        e.preventDefault();
          var $this = $(this);
        var id = $this.attr('data-id');
     	var tempDeleteUrl = "{{ route('vendor.vendors_details.edit', ':id') }}";
     	tempDeleteUrl = tempDeleteUrl.replace(':id', id);

     	$modal.load(tempDeleteUrl, function (response) {
            $modal.modal('show');
         });
    });
</script>
<script>
	$(document).on("click", ".btn-vendor-details-update", function (e) {
        e.preventDefault();
        var params   = $('#updateVendorDetails').serialize();
            // var formData = new FormData($('#updateVendorDetails')[0]);
            // if($('#image').val()) {
            //     formData.append('image', $('input[type=file]')[0].files[0]);
            // }

            // $.each(params, function(i, val) {
            //     formData.append(val.name, val.value);
            // });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('vendor.vendors_details.update') }}",
                // contentType: false,
                // processData: false,
                // cache: false,
                data: params,
                beforeSend: function (data) {
                },
                success: function (data) {
                	$('#vendorDetailsEditModal').modal('hide');
                	sweetAlert('success', 'Success');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    
                },
                complete: function () {

                	$('#vendorDetailsTable').DataTable().ajax.reload();
                }
            });
    });
</script>
@endpush