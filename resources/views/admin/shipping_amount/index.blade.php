@extends('admin.layouts.app')
@section('title', 'Manage Shipping Amount')

@section('content')
    <section>
        <div class="row">
            <h3>Manage Shipping Amount</h3>
            <a href="{{ route('admin.shipping_amount.create') }}" class="btn btn-info btn-xs pull-right">Add New</a>
            <div class="clearfix"></div>
            <hr>
            <div class="col-sm-12 content__box content__box--shadow">
                <table class="table table-hover table-striped" id="shippingAmountTable">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Place</th>
                        <th>Amount</th>
                        <th>Parent</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
       $('#shippingAmountTable').DataTable({
           aaSorting: [[0, 'desc']],
           columnDefs: [],
           processing: true,
           serverSide: true,
           columns: [
               {
                   data: 'id',
                   render: function (data, type, row, meta) {
                       return meta.row + meta.settings._iDisplayStart + 1;
                   }
               },
               { data: 'name', name: 'name'},
               { data: 'value', name: 'value'},
               { data: 'parent', name: 'parent'},

               {
                   data: 'id',
                   orderable: false,
                   render: function (data, type, row) {
                       var tempEditUrl = "{{ route('admin.shipping_amount.edit', ':id') }}";

                       tempEditUrl = tempEditUrl.replace(':id', data);

                       var actions = '';
                       actions += "<a href='" + tempEditUrl + "' class='btn btn-xs btn-default'><span class='lnr lnr-pencil'></span></a>";
                       actions += "<button data-id="+ data +" class='btn btn-xs btn-default btn-delete'><span class='lnr lnr-trash'></span></button>";

                       return actions;
                   }
               }
           ],
           ajax: "{{ route('admin.shipping_amount.json') }}"
       });
    });

    $(document).on("click", ".btn-delete", function (e) {
        e.preventDefault();
        if (!confirm('Are you sure you want to delete?')) {
            return false;
        }

        var $this = $(this);

        var id = $this.attr('data-id');
        var tempDeleteUrl = "{{ route('admin.shipping_amount.destroy', ':id') }}";
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
                $('#shippingAmountTable').DataTable().ajax.reload();
            }
        });
    });
</script>
@endpush