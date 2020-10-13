@extends('admin.layouts.app')
@section('title', 'Testimonial')

@section('content')
	<section>
		<div class="row">
			<div class="col-xs-12">
				<h3 class="text-center">All Testimonials</h3>
				<a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-xs pull-right">Add New</a>
				<table class="table table-striped table-hover" id="testimonialsTable" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>SN</th>
							<th>Image</th>
							<th>Name</th>
							<th>Profession</th>
							<th>Status</th>
							<th>Description</th>
							<th>Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody></tbody>
					<tfoot>
						<tr>
							<th>SN</th>
							<th>Image</th>
							<th>Name</th>
							<th>Profession</th>
							<th>Status</th>
							<th>Description</th>
							<th>Date</th>
							<th>Action</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</section>
@endsection

@push('scripts')
<script>
	$(document).ready(function() {
		$("#testimonialsTable").DataTable({
			// columnDefs: [
   //                  {"width": "2%", "targets": 0},
   //                  {"width": "5%", "targets": 1},
   //                  {"width": "28%", "targets": 2}
   //              ],
   				aaSorting: [0,'desc'],
                processing: true,
                serverSide: true,
                columns: [
                    { 
                    	"data": "id",
	                   render: function (data, type, row, meta) {
	                       return meta.row + meta.settings._iDisplayStart + 1;
	                   }
	               	},
                    {data: 'image', 
		                orderable: false, 
		                render: function (data, type, row) {
		                    return '<img src="' + data + '" style="width:50%;height:auto;">';
		                }
		            },
                    {data: 'name', name: 'name'},
                    {data: 'profession', name: 'profession'},
                    {
                        data: 'status',
                        render: function (data, type, row) {
                            var intData = parseInt(data);
                            return intData !== 1 ? '<span class="label label-danger">Disabled</span>' : '<span class="label label-success">Enabled</span>';
                        }
                    },
                    {data: 'description', name: 'description'},
                    {data: 'created_at', name: 'created_at'},
                    {
                        data: 'id',
                        orderable: false,
                        render: function (data, type, row) {
                            var tempEditUrl = "{{ route('admin.testimonials.edit', ':id') }}";

                            tempEditUrl = tempEditUrl.replace(':id', data);

                            var actions = '';
                            actions += "<a href='" + tempEditUrl + "' class='btn btn-xs btn-default mr-5' style='margin-right:5px'><span class='lnr lnr-pencil'></span></a>";
                            actions += "<button type='submit' class='btn btn-xs btn-default btn-testimonial-delete' data-id="+ row.id +"><span class='lnr lnr-trash'></span></button>";

                            return actions;
                        }
                    }
                ],
                ajax: '{{ route('admin.testimonials.json') }}'
		});
	});
</script>
<script>
	$(document).on("click", ".btn-testimonial-delete", function (e) {
        e.preventDefault();
       if (!confirm('Are you sure you want to delete?')) {
                return false;
            }
         var $this = $(this);
       
        var id = $this.attr('data-id');
     	var tempDeleteUrl = "{{ route('admin.testimonials.delete', ':id') }}";
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
                    $(".alert-success").fadeTo(5000, 5000).html(data).slideUp(500, function() {
                        $("#alert").slideUp(5000);
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorsHolder = '';
                    errorsHolder += '<ul>';

                    var err = eval("(" + xhr.responseText + ")");
                    $.each(err.errors, function (key, value) {
                        errorsHolder += '<li>' + value + '</li>';
                    });


                    errorsHolder += '</ul>';

                    $(".alert-danger").fadeTo(5000, 5000).html(errorsHolder).slideUp(500, function() {
                        $("#alert").slideUp(5000);
                    });
                },
                complete: function () {
                	$('#testimonialsTable').DataTable().ajax.reload();
                }
            });
    });
</script>
@endpush