@extends('admin.layouts.app')
@section('title', 'All Orders')

@push('styles')
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css"> --}}
@endpush

@section('content')
    @include('partials.message-success')
    @include('partials.message-error')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Orders</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    <!--<h3 class="box-title">All Orders <small>({{ $ordersCount }})</small></h3>-->
                        <ul class="liststyle--none" style="display: flex;">
                            <li><a href="{{ route('admin.order.index', 'status='.'all') }}" style="padding-right: 10px;">All <small>({{ $ordersCount }})</small></a></li>
                            @if(!Auth::user()->hasRole('delivery'))
                                <li><a href="{{ route('admin.order.index', 'status='.'pending') }}" style="padding-right: 10px;">Pending <small>({{ $orderPendingCount }})</small></a></li>
                                <li><a href="{{ route('admin.order.index', 'status='.'approved') }}" style="padding-right: 10px;">Approved <small>({{ $orderApprovedCount }})</small></a></li>
                                <li><a href="{{ route('admin.order.index', 'status='.'pack') }}" style="padding-right: 10px;">Pack <small>({{ $orderPackCount }})</small></a></li>
                                <li><a href="{{ route('admin.order.index', 'status='.'unpack') }}" style="padding-right: 10px;">Unpack <small>({{ $orderUnpackCount }})</small></a></li>
                                <li><a href="{{ route('admin.order.index', 'status='.'received') }}" style="padding-right: 10px;">Received <small>({{ $orderReceivedCount }})</small></a></li>
                                <li><a href="{{ route('admin.order.index', 'status='.'delivered') }}" style="padding-right: 10px;">Delivered <small>({{ $orderDeliveredCount }})</small></a></li>
                                <li><a href="{{ route('admin.order.index', 'status='.'cancelled') }}" style="padding-right: 10px;">Cancelled <small>({{ $orderCancelledCount }})</small></a></li>
                                <li><a href="{{ route('admin.order.index', 'status='.'review') }}" style="padding-right: 10px;">Review <small>({{ $orderReviewCount }})</small></a></li>
                                <li><a href="{{ route('admin.order.index', 'status='.'dispatched') }}" style="padding-right: 10px;">Dispatched <small>({{ $orderDispatchedCount }})</small></a></li>
                                <li><a href="{{ route('admin.order.index', 'status='.'completed') }}" style="padding-right: 10px;">Completed <small>({{ $orderCompletedCount }})</small></a></li>
                            @endif
                        </ul>
                        <a href="{{ route('admin.order.create') }}" class="btn btn-sm btn-danger pull-right" style="margin: 10px 3px;">Add New</a>
                        <a href="{{ route('admin.export.excel', request()->status) }}" class="btn btn-sm btn-primary pull-right" style="margin: 10px 3px;">All Export</a>
                        <a href="javascript:void(0);" class="btn btn-sm btn-success pull-right order_checkbox" style="margin: 10px 3px;">Export Selected</a>
                          <a href="javascript:void(0);" class="btn btn-sm btn-info pull-right bulk_invoice" style="margin: 10px 3px;">Print Invoice</a>

                        <select name="order_status" id="order_status" class="form-control select2" style="display: inline-block;width: 200px;">
                            <option value="1">Select Order Status</option>
                            @foreach($orderStatuses as $orderStatus)
                                <option value="{{ $orderStatus->id }}" >{{ $orderStatus->name }}</option>
                            @endforeach
                        </select>
                        <a href="javascript:void(0);" class="btn btn-sm btn-danger change_status" style="margin: 10px 3px;">Change Status</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Order No.</th>
                                <th>Status</th>
                                <th>Order</th>
                                <th>Purchased</th>
                                <th>Payment Status</th>
                                <th>Address</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th class="sorting-false">Action</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th>Order No.</th>
                                <th>Status</th>
                                <th>Order</th>
                                <th>Purchased</th>
                                <th>Payment Status</th>
                                <th>Address</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th class="sorting-false">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            @if($prebookings->isNotEmpty())
                @include('admin.orders.preorder')
            @endif
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    {{-- <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script> --}}
    <script>
        $(document).ready(function () {
            $('.datatable').DataTable({
                // dom: 'Bfrtip',
                // buttons: [
                //     'copy',
                //     'csv',
                //     'excel',
                //     'pdf',
                //     {
                //         extend: 'print',
                //         text: 'Print all (not just selected)',
                //         exportOptions: {
                //             modifier: {
                //                 selected: null
                //             }
                //         }
                //     }
                // ],
                // select: true,
                aaSorting: [[0, 'desc']],
                columnDefs: [],
                processing: true,
                serverSide: false,
                columns: [
                    {
                        data: 'id',
                        render: function (data, type, row) {
                            return '<input type="checkbox" name="orders" class="order" value="' + data + '">';
                        }
                    },
                    {
                        data: 'order_no',
                        render: function (data, type, row) {
                            var orderEditUrl = "{{ route('admin.order.edit', ':id') }}";

                            orderEditUrl = orderEditUrl.replace(':id', row.id);
                            return '<a href="' + orderEditUrl + '">' + data + '</a>';
                        }
                    },
                    {
                        data: 'order_status',
                        render: function (data, type, row) {
                            var statusClass = '';
                            switch (data) {
                                case 'pending':
                                    statusClass = "warning";
                                    break;
                                case 'approved':
                                    statusClass = "primary";
                                    break;
                                case 'pack':
                                    statusClass = "success";
                                    break;
                                case 'unpack':
                                    statusClass = "danger";
                                    break;
                                case 'delivered':
                                    statusClass = "success";
                                    break;
                                case 'received':
                                    statusClass = "info";
                                    break;
                                case 'cancelled':
                                    statusClass = "danger";
                                    break;
                                case 'review':
                                    statusClass = "info";
                                    break;
                                case 'dispatched':
                                    statusClass = "info";
                                    break;
                                case 'completed':
                                    statusClass = "success";
                                    break;
                                default:
                                    statusClass = "info";
                            }

                            return '<span class="label label-' + statusClass + '">' + data + '</span>';
                        }
                    },
                    {
                        data: 'userOrder',
                        render: function (data, type, row) {
                            var orderId = data.order_id;
                            var userId = data.user_id;
                            var userFirstName = data.user_first_name;
                            var userLastName = data.user_last_name;
                            var userEmail = data.user_email;

                            var orderLink = "{{ url('/admin/order') }}" + "/" + orderId + "/edit";
                            var userLink = userId ? "{{ url('/admin/users/edit') }}" + "/" + userId : "javascript:void(0);";

                            var userOrder = "<ul class='no-margin no-padding no-list-style' style='list-style: none;'>";
                            userOrder += "<li><a href='" + orderLink + "'>#" + orderId + "</a> by ";
                            userOrder += "<a href='" + userLink + "'>";
                            userOrder += userFirstName ? userFirstName + " " : "Guest";
                            userOrder += userLastName ? userLastName : "";
                            userOrder += "</a></li>";
                            userOrder += userEmail ? "<li><a href='mailto:" + userEmail + "'> " + userEmail + "</a></li>" : "";
                            userOrder += "</ul>";
                            return userOrder;
                        }
                    },
                    {
                        data: 'products',
                        render: function (data, type, row) {
                            var products = '<ul class="no-margin no-padding no-list-style" style="list-style: none;">';
                          
                            $.each(data, function (index, value) {
                                {{--var productLink = "{{ url('/product') }}" + "/" + value.product_id + "/edit";--}}

                                    products += "<li><a href='" + '#' + "'><label class='label label-default'>" + value.qty + "</label> " + value.name + "</a></li>";
                            });
                            var id = row.id;
                            var tempInvoiceUrl = "{{ route('admin.order.invoice', ':id') }}";
                            tempInvoiceUrl = tempInvoiceUrl.replace(':id', id);
                            
                            products += "<a href='" + tempInvoiceUrl + "' class='btn btn-xs btn-default mr-5' target='_blank'>Invoice</a>";

                            products += "</ul>";


                            return products;
                        }
                    },
                    {
                        data: 'payment',
                        render: function (data, type, row) {
                            
                            return  data;
                        }
                    },
                    {
                        data: 'address',
                        render: function (data, type, row) {
                            var first_name = data.address_first_name;
                            var last_name = data.address_last_name;

                            var area = data.address_area;
                            var district = data.address_district;
                            var zone = data.address_zone;

                            var address = first_name+' '+last_name ;
                            address += area ? '<br>' + area : '';
                            address += district ? '<br>' + district : '';
                            address += zone ? '<br>' + zone : '';

                            var tempEditUrl = "{{ route('admin.order.edit', ':id') }}";
                            tempEditUrl = tempEditUrl.replace(':id', row.id);

                            return "<a href='" + tempEditUrl + "'>" + address + "</a>";
                        }
                    },
                    {
                        data: 'order_date',
                        render: function (data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 'price_total',
                        render: function (data, type, row) {

                            return 'RS ' + data;
                        }
                    },
            {
                                    @role(['admin','logistics','customer_care'])

                data: 'id',
                    orderable: false,
                render: function (data, type, row) {
                var tempInvoiceUrl = "{{ route('admin.order.invoice', ':id') }}";
                var tempEditUrl = "{{ route('admin.order.edit', ':id') }}";
                var tempDeleteUrl = "{{ route('admin.order.destroy', ':id') }}";
                var tempBarcodeUrl = "{{ route('admin.order.barcode', ':id') }}";

                tempInvoiceUrl = tempInvoiceUrl.replace(':id', data);
                tempEditUrl = tempEditUrl.replace(':id', data);
                tempDeleteUrl = tempDeleteUrl.replace(':id', data);
                tempBarcodeUrl = tempBarcodeUrl.replace(':id', data);

                var actions = '';
                actions += "<a href='" + tempEditUrl + "' class='btn btn-xs btn-info mr-5'><span class='lnr lnr-pencil'></span></a>";
                actions += "<form action='" + tempDeleteUrl + "' method='post' style='display: inline-block;'>";
                actions += "<input type='hidden' name='_token' value='{{ csrf_token() }}'>";
                actions += "<input type='hidden' name='_method' value='DELETE'>";
                actions += "<button type='submit' class='btn btn-xs btn-danger btn-delete'><span class='lnr lnr-trash'></span></button>";
                actions += "</form>";
            <!--actions += "<a href='" + tempInvoiceUrl + "' class='btn btn-xs btn-default mr-5' target='_blank'>Invoice</a>";-->
                actions += "<a href='" + tempBarcodeUrl + "' class='btn btn-xs btn-default mr-5' target='_blank'>Print Barcode</a>";

                return actions;
            }
                                @endrole

            }
        ],
            ajax: '{{ route('admin.orders.json', request('status')) }}'
        });
        });

        $(document).on("click", ".btn-delete", function (e) {
            e.preventDefault();
            if (confirm("Are you sure to delete?") == true) {
                $(this).closest('form').submit();
            } else {

                return false;
            }
        });

        $(document).on('click', '.order_checkbox', function () {
            var query = {
                ids: multiple_values('order')
            }

            var url = "{{ route('admin.export.selected', request()->status) }}?" + $.param(query)

            $('.datatable').DataTable().ajax.reload();
            window.location = url;
        });
        
         $(document).on('click', '.change_status', function () {


            var status = $('#order_status').val();
            if(status != 0){
                var query = {
                    ids: multiple_values('order')
                }
                if(query.ids.length <= 0){
                    alert("Please select Orders");
                }else {
                    alert("Are you to change selected order status");


                    var url = "{{ route('admin.order.bulk.status', ':id') }}?" + $.param(query)
                    newUrl = url.replace(':id', status);
                    window.location = newUrl;
                }



            }else{
                alert("Please select Status");
            }

        });

        $(document).on('click', '.bulk_invoice', function () {



                var query = {
                    ids: multiple_values('order')
                }
                if(query.ids.length <= 0){
                    alert("Please select Orders");
                }else {
                    alert("Are you to Print Multiple Invoice");

                    var url = "{{ route('admin.order.bulk.invoice') }}?" + $.param(query)
                    window.open(url,'_blank')
                }



        });

        function multiple_values(inputclass) {
            var val = new Array();
            $("." + inputclass + ":checked").each(function () {
                val.push($(this).val());
            });
            return val;
        }

        // $(document).on('click', '.order', function() {
        //     $(".order").find("checkbox").each(function(){
        //         if ($(this).prop('checked')==true){ 
        //             $('.order_checkbox').css('display', 'block');
        //         }
        //         else{
        //             $('.order_checkbox').css('display', 'none');
        //         }
        //     });
        // });

        // $(document).ready(function () {
        //     $('#example2').DataTable({
        //         dom: 'Bfrtip',
        //         buttons: [
        //             'csv',
        //             'excel',
        //             'pdf',
        //         ],
        //         select: true,
        //     });
        // });
    </script>
@endpush