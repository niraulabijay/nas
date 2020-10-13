@extends('admin.layouts.app')
@section('title', 'Deals')

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

    @include('partials.message-success')
    @include('partials.message-error')

	<section>
		<div class="row">
			<h3>All Home Products</h3>
			<div class="content__box content__box--shadow">
				<table class="table table-hover table-striped" id="dealTable">
					<thead>
						<tr>
							<th>SN</th>
							<th>Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody></tbody>
					<tfoot>
						<tr>
							<th>SN</th>
							<th>Name</th>
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
		$('#dealTable').DataTable({
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
                        url = "{{ route('admin.deals.edit',':id' ) }}";
                        url = url.replace(':id', row.id);
                        return '<a href="'+ url +'">' + data + '</a>';
                    }
                },
				{
					data: 'id',
                        orderable: false,
                        render: function (data, type, row) {
                            var tempEditUrl = "{{ route('admin.deals.edit', ':id') }}";

                            tempEditUrl = tempEditUrl.replace(':id', data);
                            var tempAddUrl = "{{ route('admin.deals.deal-product', ':id') }}";
                            tempAddUrl = tempAddUrl.replace(':id', data);

                            var actions = '';
                            actions += "<a href='" + tempEditUrl + "' class='btn btn-xs btn-default mr-5' style='margin-right:5px'><span class='lnr lnr-pencil'></span></a>";
                            actions += "<button type='submit' class='btn btn-xs btn-default btn-deal-delete' data-id="+ row.id +" style='margin-right:5px'><span class='lnr lnr-trash'></span></button>";
                            actions += "<a href='" + tempAddUrl + "' class='btn btn-default btn-xs'>Add Product</a>"

                            return actions;
                        }
				}
			],
			ajax: '{{ route('admin.deals.json') }}'
		});
	});
</script>
<script>
	$(document).on("click", ".btn-deal-delete", function (e) {
        e.preventDefault();
       if (!confirm('Are you sure you want to delete?')) {
                return false;
            }
         var $this = $(this);
       
        var id = $this.attr('data-id');
     	var tempDeleteUrl = "{{ route('admin.deals.delete', ':id') }}";
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
                	$('#dealTable').DataTable().ajax.reload();
                }
            });
    });
</script>
@endpush