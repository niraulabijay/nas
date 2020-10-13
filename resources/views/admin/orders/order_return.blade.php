@extends('admin.layouts.app')
@section('title', 'Order Returns')

@section('content')
    <section>
        <div class="row">
            <h3>Order Returns</h3>
            <div class="col-sm-12 content__box content__box--shadow">
                <table class="table table-striped table-hover" id="orderReturnTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Status</th>
                        <th>Order Code</th>
                        <th>User</th>
                        <th>Product Name</th>
                        <th>Address</th>
                        <th>Vendor</th>
                        <th>Date</th>
                        <th class="sorting-false">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Status</th>
                        <th>Order Code</th>
                        <th>User</th>
                        <th>Product Name</th>
                        <th>Address</th>
                        <th>Vendor</th>
                        <th>Date</th>
                        <th class="sorting-false">Action</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#orderReturnTable').DataTable({
            aaSorting: [[5, 'desc']],
            columnDefs: [],
            processing: true,
            serverSide: true,
            columns: [
                {
                    "data": "id",

                },
                {
                    data: 'status',
                    render: function (data, type, row) {
                        return '<span class="label label-warning">' + 'Return' + '</span>';
                    }

                },
                {
                    data: 'orderCode',
                    render: function (data, type, row) {
                        var orderEditUrl = "{{ route('admin.order.edit', ':orderId') }}";

                        orderEditUrl = orderEditUrl.replace(':orderId', row.orderId);
                        return '<a href="' + orderEditUrl + '">' + data + '</a>';
                    }

                },
                {
                    data: 'userName',

                },
                {
                    data: 'productName',

                },
                {
                    data: 'address',

                },
                {
                    data: 'vendorName',

                },
                {data: 'date'},

                {
                    data: 'id',
                    orderable: false,
                    render: function (data, type, row) {
                        var tempEditUrl = "{{ route('admin.order_return.vendor.invoice', ':id') }}";

                            tempEditUrl = tempEditUrl.replace(':id', data);

                        var actions = '';
                        actions += "<a href='" + tempEditUrl + "' class='btn btn-xs btn-default' style='margin-bottom: 5px;' target='_blank'>V.R Invoice</a>";
                        actions += "<button type='submit' class='btn btn-xs btn-danger btn-delete' data-id=" + row.id + "><span class='lnr lnr-trash'></span></button>";

                        return actions;
                    }
                }
            ],
            ajax: '{{ route('admin.order_return.json') }}'
        });
    });

    $(document).on("click", ".btn-delete", function (e) {
        e.preventDefault();
        if (!confirm('Are you sure you want to delete?')) {
            return false;
        }
        var $this = $(this);

        var id = $this.attr('data-id');
        var tempDeleteUrl = "{{ route('admin.order_return.delete', ':id') }}";                               tempDeleteUrl = tempDeleteUrl.replace(':id', id);


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
                $('#orderReturnTable').DataTable().ajax.reload();
            }
        });


    });
</script>
@endpush