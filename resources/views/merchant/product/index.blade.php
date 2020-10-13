@extends('merchant.layouts.app')
@section('title', 'All Products')
<style>
       .tooltip-vendor {
        position: relative;
        display: inline-block;


    }
    .pending-vendor{
        color: #d9534f;
    }

    .tooltip-vendor .tooltiptext-vendor {
        visibility: hidden;
        width: 250px;
        background-color: #fff;
        color: #000;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        /*border: 1px solid #000000;*/
        border-radius: 3px;
        box-shadow: 0 2px 4px 0 rgba(0,0,0,.23);

        /* Position the tooltip */
        position: absolute;
        z-index: 1;
        top: 100%;
        left: 50%;
        margin-left: -60px;
    }
.tooltiptext-vendor ul{
    display: inline;
    list-style-type: none;
    text-align: left;
}
.tooltiptext-vendor li{
    padding: 0 10px;
    font-size: 16px;
    line-height: 28px;
}
.tooltiptext-vendor li:before{
    /*font-family: "Font Awesome";*/
    content: "✔";
    display: inline-block;
    padding-right: 3px;
    vertical-align: middle;
    font-weight: 900;
    color: #2db34c;
}
.pending-vendor li:before{
    
    content: "✖";
    color: #d9534f;
}
    .tooltip-vendor:hover .tooltiptext-vendor {
        visibility: visible;
    }
    .tooltiptext-vendor img{
        max-width: 75%;
    }
    
    .tooltip-productimg {
        position: relative;
        display: inline-block;

    }

    .tooltip-productimg .tooltiptext-productimg {
        visibility: hidden;
        width: 300px;
        background-color: #fff;
        color: #000;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        /*border: 1px solid #000000;*/
        border-radius: 3px;
        box-shadow: 0 2px 4px 0 rgba(0,0,0,.23);

        /* Position the tooltip */
        position: absolute;
        z-index: 1;
        transition-delay: 90ms;
        bottom: 100%;
        left: 50%;
        margin-left: -60px;
    }

    .tooltip-productimg:hover .tooltiptext-productimg {
        visibility: visible;
    }
    
    
    .status-switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 25px;
}

.statusswitch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.status-slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.status-slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .status-slider {
  background-color: #2196F3;
}

input:focus + .status-slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .status-slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

</style>
@section('content')
        
    @include('partials.message-success')
    @include('partials.message-error')
    
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
                                <a href="{{ route('vendor.products.create') }}" class="btn btn-default" title="add new">New</a>
                                <a href="{{ route('vendor.products.stock') }}" class="btn btn-default" title="stock manager"><span class="lnr lnr-database"></span></a>
                            </div>
                        </div>
                         <div class="col-md-12 col-sm-12">
                            <section class="mini__box">
                                <ul class="liststyle--none">
                                    <li><a href="{{ route('vendor.products.table', 'status='.'all') }}" class="allProducts btn btn-info">All (<span>{{ $all }}</span>)</a></li>
                                    <li><a href="{{ route('vendor.products.table', 'status='.'pending') }}" class="pendingProducts btn btn-warning">Pending (<span>{{ $pending }}</span>)</a></li>
                                    <li><a href="{{ route('vendor.products.table', 'status='.'approved') }}" class="approvedProducts btn btn-success">Approved (<span>{{ $approved }}</span>)</a></li>

                                </ul>
                            </section>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content__box content__box--shadow">
                @include('merchant.product.table')
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
                            var productViewUrl = "{{ route('vendor.products.edit', ':id') }}";

                            productViewUrl = productViewUrl.replace(':id', row.id);

                            return '<a class="tooltip-productimg" href="' + productViewUrl + '">' + data + ' <span class="tooltiptext-productimg"> <img src="' +row.product_image+ '" alt="' + data + '"> </span> </a>';
                        }
                },
                // {data: 'slug', name: 'slug'},
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
                
                // {data: 'status', name: 'status',
                //     render: function(data, type, row) {
                //         console.log(data);
                //         if(data==='published'){
                //             return '<span class="label label-success">Published</span>';
                //         }
                //         else if(data ==='unpublished'){
                //             return '<span class="label label-warning">Unpublished</span>';
                //         }
                //         else if( data=== 'deleted'){
                //             return '<span class="label label-danger">Deleted</span>';
                //         }
                //     }
                // },
                
                 {data: 'approved', name: 'approved',
                    render: function(data, type, row) {
                        if(data == 1){
                            return '<div class="tooltip-vendor"> ✔ '+
                			'<span class="tooltiptext-vendor">'+
                			'<ul>'+
                					'<li>Vendor is verified</li>'+
                					'<li>Vendor status is Active</li>'+
                					'<li>Brand status is active</li>'+
                					'<li>Brand is approved</li>'+
                					'<li>Product has active categories</li>'+
                					'<li>Product status is Active</li>'+
                					'<li>Images uploaded</li>'+
                					'<li>QC Passed</li>'+
                				'</ul>'+
                			'</span>'+
                		'</div>';
                        }else{
                         return '<div class="tooltip-vendor pending-vendor"><p>✖</p>'+
                			'<span class="tooltiptext-vendor pending-vendor-span">'+
                			'<ul>'+
                				
                					'<li>Brand status is not active</li>'+
                					'<li>Brand is not approved</li>'+
                					'<li>Product has not active categories</li>'+
                					'<li>Product status is not Active</li>'+
                					'<li>Images uploaded</li>'+
                					'<li>QC in progress</li>'+
                				'</ul>'+
                			'</span>'+
                		'</div>';
                        }
                    }
                },
                {data: 'status', name: 'status',
                    render: function(data, type, row) {
                        
                        if(data === 'published'){
                        return '<label class="status-switch">'+
                          '<input type="checkbox" data-status = "'+ row.status + '" value="'+ row.id +'" class="btn-status-change" checked>'+
                          '<span class="status-slider"></span>'+
                        '</label>';
                        }else{
                          return '<label class="status-switch">'+
                          '<input type="checkbox" data-status = "'+ row.status + '" value="'+ row.id +'"  class="btn-status-change" >'+
                          '<span class="status-slider"></span>'+
                        '</label>';  
                        }
                        // return data === '1' ? '<span class="label label-success">Live</span>' : '<span class="label label-danger">Inactive</span>';
                    }
                },
                
                {
                    data: 'id',
                    orderable: false,
                    render: function (data, type, row) {
                        var tempEditUrl = "{{ route('vendor.products.edit', ':id') }}"
                        tempEditUrl = tempEditUrl.replace(':id', data);
                        var actions = '';
                        actions += "<a href=" + tempEditUrl + " class='btn btn-xs btn-default btn-products-edit' data-id=" + row.id + " style='margin-right:5px'><span class='lnr lnr-pencil'></span></a>";
                        actions += "<button type='submit' class='btn btn-xs btn-default btn-products-delete' data-id=" + row.id + "><span class='lnr lnr-trash'></span></button>";

                        return actions;
                    }
                },
                {data: 'created_at', name: 'created_at',}
            ],
           ajax: "{{  route('vendor.products.json', request('status'))   }}"
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
                url: "{{ route('vendor.products.store.new')  }}",
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
        var tempDeleteUrl = "{{ route('vendor.products.delete', ':id') }}";
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
                url: "{{ route('vendor.products.update') }}",
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

<script>
    $(document).on("change", ".btn-status-change", function (e) {
        e.preventDefault();
        var $this = $(this);
        var productId = $this.val();
        var productStatus = $this.attr('data-status');
        var tempChangeUrl = "{{ route('vendor.product.status.update', ':id') }}";
        tempChangeUrl = tempChangeUrl.replace(':id', productId);        
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "GET",
                url: tempChangeUrl,
                data:{
                    id:productId,
                    status:productStatus,
                    
                }
                
            });
    });
</script>

@endpush

