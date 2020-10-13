@extends('admin.layouts.app')
@section('title', 'Request Products')

@section('content')

    <section>
        <div class="modal fade" id="quickViewModal" tabindex="-1"></div>

        <div class="row">
            <h3>Request Products</h3>
            <div class="col-md-12 content__box content__box--shadow">
                <table id="requestProductTable" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Specification</th>
                        <th>Reference</th>
                        <th class="sorting-false">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Specification</th>
                        <th>Reference</th>

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
    $(document).ready(function(){
        $('#requestProductTable').DataTable({
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
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'product_title', name: 'product_title'},
                {data: 'product_category', name: 'product_category'},
                {data: 'product_specification', name: 'product_specification'},
                {data: 'product_reference', name: 'product_reference'},
                {
                    data: 'id',
                    orderable: false,
                    render: function (data, type, row) {
                        var actions = '';
                        var tempEditUrl = "{{ route('admin.request_product.edit', ':id') }}";
                            tempEditUrl = tempEditUrl.replace(':id', row.id);
                        actions += "<a href='" + tempEditUrl + "' class='btn btn-default btn-xs'><span class='lnr lnr-pencil'></span></a>";
                        actions += "<button type='submit' class='btn btn-xs btn-default btn-delete' data-id=" + row.id + "><span class='lnr lnr-trash'></span></button>";

                        return actions;
                    }
                }
            ],
            ajax: '{{route('admin.request_product.json')}}'

        });
    });

    $(document).on("click", ".btn-delete", function (e) {
        e.preventDefault();
        if (!confirm('Are you sure you want to delete?')) {
            return false;
        }

        var $this = $(this);

        var id = $this.attr('data-id');
        var tempDeleteUrl = "{{ route('admin.request_product.delete', ':id') }}";
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

            },
            error: function (xhr, ajaxOptions, thrownError) {

            },
            complete: function () {
                $('#requestProductTable').DataTable().ajax.reload();
            }
        });
    });
</script>

@endpush