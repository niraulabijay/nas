@extends('admin.layouts.app')
@section('title', 'All Products')

@section('content')
    <section class="admin__breadcrumb display--none">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">Library</a></li>
            <li class="active">Data</li>
        </ol>
    </section>

    <section class="content__box content__box--shadow">
        <div class="  details-of-orders">
            <div class="row">

                <div class="col-md-6 col-sm-12">
                    <span class=" btn-unlimited">Product limit:Unlimited</span>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="mini__box text-right">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-default" title="add new">New</a>
                        <a href="{{ route('admin.products.stock') }}" class="btn btn-default" title="stock manager"><span class="lnr lnr-database"></span></a>
                        <button class="btn btn-default" title="products import"><span class="lnr lnr-download"></span></button>
                        <a  href="{{ route('admin.products.stock') }}" class="btn btn-default" title="products export"><span class="lnr lnr-upload"></span></a>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12">
                    <section class="mini__box">
                        <ul class="liststyle--none">
                            <li><a href="{{ route('admin.products.index', 'status='.'all') }}" class="allProducts btn btn-info">All (<span>{{ $all }}</span>)</a></li>
                            <li><a href="{{ route('admin.products.index', 'status='.'pending') }}" class="pendingProducts btn btn-warning">Pending (<span>{{ $pending }}</span>)</a></li>
                            <li><a href="{{ route('admin.products.index', 'status='.'approved') }}" class="approvedProducts btn btn-success">Approved (<span>{{ $approved }}</span>)</a></li>
                            <li><a href="{{ route('admin.products.index', 'status='.'published') }}" class="approvedProducts btn btn-success">Published (<span>{{ $published }}</span>)</a></li>
                            <li><a href="{{ route('admin.products.index', 'status='.'unpublished') }}" class="approvedProducts btn btn-warning">Unpublished (<span>{{ $unpublished }}</span>)</a></li>
                            <li><a href="{{ route('admin.products.index', 'status='.'deleted') }}" class="approvedProducts btn btn-danger">Deleted (<span>{{ $deleted }}</span>)</a></li>
                        </ul>
                    </section>
                </div>
            </div>
        </div>
    </section>
    <section class="content__box content__box--shadow">
        @include('admin.products.table')
    </section>
@endsection

@push('scripts')
<script>
    $(document).ready(function($) {
        $("#productTable").DataTable({
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
                        var productViewUrl = "{{ route('admin.products.edit', ':id') }}";

                        productViewUrl = productViewUrl.replace(':id', row.id);

                        return '<a href="' + productViewUrl + '">' + data + '</a>';
                    }
                },
                {data: 'product_price', name: 'product_price'},
                {data: 'sale_price', name: 'sale_price'},
                {data: 'discount',
                    render: function(data, type, row) {
                        var price = parseInt(row.product_price);
                        var sale_price = parseInt(row.sale_price);
                        var discount = (((price - sale_price)/price ) * 100).toFixed(2);
                        return discount;
                    }
                },
                {data: 'approved', name: 'approved',
                    render: function(data, type, row) {

                        return data == '1' ? '<button class="label label-success btn-update-status"  data-id="' + row.id + '">Approved</button>' : '<button class="btn btn-xs btn-danger btn-update-status"  data-id="' + row.id + '">Pending</button>';

                    }
                },
                {data: 'status', name: 'status',
                    render: function(data, type, row) {
                        console.log(data);
                        if(data==='published'){
                            return '<span class="label label-success">Published</span>';
                        }
                        else if(data ==='unpublished'){
                            return '<span class="label label-warning">Unpublished</span>';
                        }
                        else if( data=== 'deleted'){
                            return '<span class="label label-danger">Deleted</span>';
                        }
                    }
                },
                {data: 'vendor_name',
                    render: function (data, type, row) {
                        var vendorViewUrl = "{{ route('admin.vendor.stat', ':id') }}";

                        vendorViewUrl = vendorViewUrl.replace(':id', row.vendor_id);

                        return '<a target="_blank" href="' + vendorViewUrl + '">' + data + '</a>';
                    }
                },
                {
                    data: 'id',
                    orderable: false,
                    render: function (data, type, row) {
                        var tempEditUrl = "{{ route('admin.products.edit', ':id') }}"
                        tempEditUrl = tempEditUrl.replace(':id', data);
                        var actions = '';
                        actions += "<a href=" + tempEditUrl + " class='btn btn-xs btn-default btn-products-edit' data-id=" + row.id + " style='margin-right:5px'><span class='lnr lnr-pencil'></span></a>";
                        @role(['admin', 'content_writer'])
                        actions += "<button type='submit' class='btn btn-xs btn-default btn-products-delete' data-id=" + row.id + "><span class='lnr lnr-trash'></span></button>";
@endrole
                        return actions;
                    }
                },
                {data: 'created_at', name: 'created_at',}
            ],
            ajax: "{{  route('admin.products.json', request('status'))   }}"
        });
    });




</script>

<script>
    $(document).on("click", ".btn-update-status", function (e) {
        e.preventDefault();
        var $this = $(this);
        var id = $this.attr('data-id');
        var tempEditUrl = "{{ route('admin.products.update-status', ':id') }}";
        tempEditUrl = tempEditUrl.replace(':id', id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: tempEditUrl,
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function (data) {
            },
            success: function (data) {
            },
            complete: function () {
                $('#productTable').DataTable().ajax.reload();
            }
        });
    });
</script>
<script>
    $(document).on("click", ".pending", function(e) {
        e.preventDefault();
        var table = $('#productTable').DataTable( {
            ajax: "products2.json"
        } );

        table.ajax.url( 'products2.json' ).load();
    });
</script>
<script>
    $(document).on("click", ".btn-products-add", function(e) {
        e.preventDefault();
        var params   = $('#products').serialize();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('admin.products.store')  }}",

            data: params,
            beforeSend: function (data) {
            },
            success: function (data) {
                sweetAlert('success', 'Success');
            },
            error: function (xhr, ajaxOptions, thrownError) {

            },
            complete: function () {
                $("#products")[0].reset(),
                    $('#productTable').DataTable().ajax.reload();
            }
        });
    });
</script>
<script>
    $(document).on("click", ".btn-products-delete", function (e) {
        e.preventDefault();
        if (!confirm('Are you sure you want to delete?')) {
            return false;
        }
        var $this = $(this);
        var id = $this.attr('data-id');
        var tempDeleteUrl = "{{ route('admin.products.delete', ':id') }}";
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
                $('#productTable').DataTable().ajax.reload();
            }
        });
    });
</script>
<script>
    $(document).on("click", ".btn-update-product", function (e) {
        e.preventDefault();
        var params = $('#updateProducts').serialize();
        console.log(params);
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
            type: "PUT",
            url: "{{ route('admin.products.update') }}",
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

                $('#productTable').DataTable().ajax.reload();
            }
        });
    });
</script>
@endpush

