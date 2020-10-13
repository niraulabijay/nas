@extends('admin.layouts.app')
@section('title', 'Vendor Ratings') 

@section('content')

    <section>
        <div class="modal fade" id="quickViewModal" tabindex="-1"></div>

        <div class="row">
            <h3>Reviews</h3>
            <div class="col-md-12 content__box content__box--shadow">
                <table id="myTable" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Vendor</th>
                        <th>Comment</th>
                        <th>Star</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="sorting-false">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Vendor</th>
                        <th>Star</th>
                        <th>Comment</th>
                        <th>Status</th>
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
                {data: 'user_name',
                    render: function (data, type, row) {
                        {{--url = "{{ route('vendor.dashboard.index',['brands',':id'] ) }}";--}}
                        //                        url = url.replace(':id', row.id);
                        return '<a href="'+ '#' +'">' + data + '</a>';
                    }
                },
                {data: 'vendor_name',
                    render: function (data, type, row) {
                        {{--url = "{{ route('vendor.dashboard.index',['brands',':id'] ) }}";--}}
//                        url = url.replace(':id', row.id);
                        return '<a href="'+ '#' +'">' + data + '</a>';
                    }
                },
                {data: 'stars', name: 'stars'},
                {data: 'review', name: 'review'},
                {
                    data: 'status',
                    render: function (data, type, row) {
                        var updateLink = "{{ url('/admin/vendor/review/status') }}" + "/" + row.id;
                        var status = '<a href="javascript:void(0);" class="review-status" data-url="' + updateLink + '" data-status="' + data + '">';
                        status += data === '1' ? '<span class="label label-success">Enabled' : '<span class="label label-danger">Disabled';
                        status +=  '</span></a>';
                        return status;
                    }
                },
                {data: 'created_at', name: 'created_at'},
                {
                    data: 'id',
                    orderable: false,
                    render: function (data, type, row) {
                        var actions = '';
                        actions += "<button type='submit' class='btn btn-xs btn-default btn-delete' data-id=" + row.id + "><span class='lnr lnr-trash'></span></button>";

                        return actions;
                    }
                }
            ],
            ajax: '{{route('admin.vendor.review.json')}}'

        });
    });


    $(document).on("click", ".review-status", function (e) {
        e.preventDefault();
        var $this = $(this);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: $this.attr('data-url'),
            data: {status: $this.attr('data-status')},
            success: function (data) {
                if (data.success) {
                    $this.prop('disabled', true);
                    $('.callout.callout-danger').fadeOut();
                    $('.callout.callout-success').fadeIn().html(data.message);
                }
            },
            complete: function () {
                window.setTimeout(function () {
                    location.reload()
                }, 1000);
            }
        });
    });



    $(document).on("click", ".btn-delete", function (e) {
        e.preventDefault();
        if (!confirm('Are you sure you want to delete?')) {
            return false;
        }

        var $this = $(this);

        var id = $this.attr('data-id');
        var tempDeleteUrl = "{{ route('admin.vendor.review.delete', ':id') }}";
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
                $('#myTable').DataTable().ajax.reload();
            }
        });
    });
</script>

@endpush