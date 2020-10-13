
@section('content')
    @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $e)
                    <li> {{ $e }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    <section>
    <div class="modal right fade" id="quickViewModal" tabindex="-1"></div>

		<div class="row">
            <h3>Brands</h3>
            @include('admin.brand.form')
			<div class="col-md-8 content__box content__box--shadow">
				<table id="myTable" class="table table-striped table-hover">
					<thead>
						<tr>
							<th>SN</th>
							<th>Name</th>
                            <th>Company Name</th>
							<th>Image</th>
	@role('admin')
							<th class="sorting-false">Action</th>
							@endrole						</tr>
					</thead>
					<tbody>
					</tbody>
					<tfoot>
						<tr>
							<th>SN</th>
							<th>Name</th>
                            <th>Company Name</th>
							<th>Image</th>
							@role('admin')
							<th class="sorting-false">Action</th>
							@endrole
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
    </section>

@endsection

@push('scripts')

<script>

	function sweetAlert(type, title, message) {
        swal({
            title: title,
            html: message,
            type: type,
            showConfirmButton: false,
            timer: 3000,
        }).catch(swal.noop);
    }

	$(document).ready(function(){
		$('#myTable').DataTable({
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
	    		{data: 'name',
                    render: function (data, type, row) {
                        return '<a href="#"  data-id="' + row.id + '">' + data + '</a>';
                    }
                },
	    		{data: 'company_name', name: 'company_name'},
                {data: 'image', 
                    orderable: false, 
                    render: function (data, type, row) {
                        return '<img src="' + data + '" style="width:50%;height:auto;">';
                    }
                },
                @role('admin')
		        {
                    data: 'id',
                    orderable: false,
                    render: function (data, type, row) {
                        var actions = '';
                  		actions += "<button type='submit' class='btn btn-xs btn-default btn-edit' style='margin-right:5px' data-id=" + row.id + "><span class='lnr lnr-pencil'></span></button>";
                        actions += "<button type='submit' class='btn btn-xs btn-default btn-delete' data-id=" + row.id + "><span class='lnr lnr-trash'></span></button>";

                        return actions;
                    }
                }
                                    @endrole

    		],
			ajax: '{{route('admin.brands.json')}}'

		});
	});
</script>

<script>
	$(document).on("click", ".btn-add", function (e) {
        e.preventDefault();
            var params   = $('#brandSubmit').serializeArray();
            var formData = new FormData($('#brandSubmit')[0]);
                formData.append('image', $('input[type=file]')[0].files[0]);

            $.each(params, function(i, val) {
                formData.append(val.name, val.value);
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('admin.brands.store')  }}",
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
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
                	 $("#brandSubmit")[0].reset(),
                	$('#myTable').DataTable().ajax.reload();
                }
            });
    });
</script>
<script>
	$(document).on("click", ".btn-delete", function (e) {
        e.preventDefault();
       if (!confirm('Are you sure you want to delete?')) {
                return false;
            }
         var $this = $(this);
       
        var id = $this.attr('data-id');
     	var tempDeleteUrl = "{{ route('admin.brands.delete', ':id') }}";                               tempDeleteUrl = tempDeleteUrl.replace(':id', id);
         
    
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
                	$('#myTable').DataTable().ajax.reload();
                }
            });
        

    });
</script>

<script>
    var $modal = $('#quickViewModal');
	$(document).on("click", ".btn-edit", function (e) {
        e.preventDefault();
          var $this = $(this);
        var id = $this.attr('data-id');
     	var tempEditUrl = "{{ route('admin.brands.edit', ':id') }}";
     	tempEditUrl = tempEditUrl.replace(':id', id);

     	$modal.load(tempEditUrl, function (response) {
            $modal.modal({show: true});

         });
    });
</script>

<script>
	$(document).on("click", ".btn-update", function (e) {
        e.preventDefault();
        var params   = $('#update').serializeArray();
            var formData = new FormData($('#update')[0]);
            if($('#image').val()) {
                formData.append('image', $('input[type=file]')[0].files[0]);
            }

            $.each(params, function(i, val) {
                formData.append(val.name, val.value);
            });
                    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('admin.brands.update') }}",
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
                beforeSend: function (data) {
                },
                success: function (data) {
                    $(".alert-success").fadeTo(5000, 5000).html(data).slideUp(500, function() {
                        $("#alert").slideUp(5000);
                    });
                	$('#quickViewModal').modal('hide');
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
                	$('#myTable').DataTable().ajax.reload();
                }
            });
    });
</script>

@endpush