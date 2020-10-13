@extends('admin.layouts.app')
@section('title', 'All Orders')

@push('styles')
<style>
    .ajax-loader{
        position: fixed;
        z-index: 9999;
        left: 50%;
        /* right: 0; */
        top: 50%;
        margin-left: 0;
    }
    .ajax-loader img{
        width: 120px;
    }
    .tbody-onload{
        opacity: 0.2;
    }
    .hidden{
        display: none;
    }
    .hidden-privent{
        display: none;
    }

</style>
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css"> --}}
@endpush

@section('content')
    <div class="ajax-loader hidden" >
        <img src="https://nepalallshop.com.np/storage/settings/eZ5dRDACnQFWNyhuTXdeC7aRoDlXSvFsFqteQUkp.png" alt="Nas" title="Nas">
    </div>
    @include('partials.message-success')
    @include('partials.message-error')



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

                       <ul class="liststyle--none" style="display: flex;">
                            <li><a href="{{ route('admin.order.list', 'status='.'all') }}" style="padding-right: 10px;">All <small>({{ $ordersCount }})</small></a></li>
                            @if(!Auth::user()->hasRole('delivery'))
                                <li><a href="{{ route('admin.order.list', 'status='.'pending') }}" style="padding-right: 10px;">Pending <small>({{ $orderPendingCount }})</small></a></li>
                                <li><a href="{{ route('admin.order.list', 'status='.'approved') }}" style="padding-right: 10px;">Approved <small>({{ $orderApprovedCount }})</small></a></li>
                                <li><a href="{{ route('admin.order.list', 'status='.'pack') }}" style="padding-right: 10px;">Pack <small>({{ $orderPackCount }})</small></a></li>
                                <li><a href="{{ route('admin.order.list', 'status='.'unpack') }}" style="padding-right: 10px;">Unpack <small>({{ $orderUnpackCount }})</small></a></li>
                                <li><a href="{{ route('admin.order.list', 'status='.'received') }}" style="padding-right: 10px;">Received <small>({{ $orderReceivedCount }})</small></a></li>
                                <li><a href="{{ route('admin.order.list', 'status='.'delivered') }}" style="padding-right: 10px;">Delivered <small>({{ $orderDeliveredCount }})</small></a></li>
                                <li><a href="{{ route('admin.order.list', 'status='.'cancelled') }}" style="padding-right: 10px;">Cancelled <small>({{ $orderCancelledCount }})</small></a></li>
                                <li><a href="{{ route('admin.order.list', 'status='.'review') }}" style="padding-right: 10px;">Review <small>({{ $orderReviewCount }})</small></a></li>
                                <li><a href="{{ route('admin.order.list', 'status='.'dispatched') }}" style="padding-right: 10px;">Dispatched <small>({{ $orderDispatchedCount }})</small></a></li>
                                <li><a href="{{ route('admin.order.list', 'status='.'completed') }}" style="padding-right: 10px;">Completed <small>({{ $orderCompletedCount }})</small></a></li>
                            @endif
                        </ul>

                        <div class="content__box--shadow" style="padding-top: 20px;">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Select District</label>
                                        <select name="district_select[]" multiple id="district_select" class="form-control select2" style="display: inline-block;width: 100%">
                                            <option value="">Select District</option>
                                            @foreach($districts as $district)
                                                <option value="{{ $district->name }}" >{{ $district->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Select Payment Method</label>
                                        <select name="payment"  id="payment" class="form-control select2" style="display: inline-block;width: 100%">
                                            <option value="">Select Payment Method</option>
                                            @foreach($payments as $payment)
                                                <option value="{{ $payment->id }}" >{{ $payment->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input type="date" id="start_date" name="start_date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input type="date" id="end_date" name="end_date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Search Text</label>
                                        <input type="text" id="search-text" name="search" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12" style="text-align: center;">
                                    <button id="filter-order" class="btn btn-sm btn-info hidden-privent" style="margin: 10px 3px;">Filter Order</button>
                                </div>
                            </div>
                            <div style="padding: 0 20px;">
                                <a href="{{ route('admin.order.create') }}" class="btn btn-sm btn-danger pull-right" style="margin: 10px 3px;">Add New</a>
                                <a href="{{ route('admin.export.excel', request()->status) }}" class="btn btn-sm btn-primary pull-right" style="margin: 10px 3px;">All Export</a>
                                <a href="javascript:void(0);" class="btn btn-sm btn-success pull-right order_checkbox" style="margin: 10px 3px;">Export Selected</a>
                                <a href="javascript:void(0);" class="btn btn-sm btn-info pull-right bulk_invoice" style="margin: 10px 3px;">Print Invoice</a>
                                <a href="javascript:void(0);" class="btn btn-sm btn-warning pull-right bulk_barcode" style="margin: 10px 3px;">Print Barcode</a>
                                <select name="order_status" id="order_status" class="form-control select2" style="display: inline-block;width: 200px;">
                                    <option value="0">Select Order Status</option>
                                    @foreach($orderStatuses as $orderStatus)
                                        <option value="{{ $orderStatus->id }}" >{{ $orderStatus->name }}</option>
                                    @endforeach
                                </select>
                                <a href="javascript:void(0);" class="btn btn-sm btn-danger change_status" style="margin: 10px 3px;">Change Status</a>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="example1" class="table table-bordered table-striped datatable">

                            <thead>
                            <tr>
                                <th><input type="checkbox" name="orders" id="checkAllOrder"></th>
                                <th>Order No.</th>
                                <th>Status</th>
                                <th>Order</th>
                                <th>Purchased</th>
                                <th>Payment Status</th>
                                <th>Address</th>
                                <th>Date</th>
                                <th>Total</th>
                                @role('admin', 'manager', 'editor')
                                <th class="sorting-false">Action</th>
                                @endrole
                            </tr>
                            </thead>
                            <tbody>
                            @include('admin.orders.paginate')
                            </tbody>
                            <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                            <input type="hidden" name="search_page" id="search_page" value="" />
                            <input type="hidden" name="payment_page" id="payment_page" value="" />
                            <input type="hidden" name="district_page" id="district_page" value="" />
                            <input type="hidden" name="start_date_page" id="start_date_page" value="" />
                            <input type="hidden" name="end_date_page" id="end_date_page" value="" />
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>

        </div>
        <!-- /.row -->
    </section>

    <!-- Content Header (Page header) -->


    <!-- /.content -->
@endsection

@push('scripts')
<script>
    $(document).ready(function(){

        function clear_icon()
        {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
        }
        var status = "{{ request()->status  }}";

        function fetch_data(page, district, payment, query, start_date, end_date)
        {

            $.ajax({
                type:'GET',
                url:"/admin/order/list?page="+page+"&query="+query+"&status="+status+"&district="+district+"&payment="+payment+"&start_date="+start_date+"&end_date="+end_date,
                beforeSend:function()
                {
                    $('#filter-order').attr("disabled", true);
                    $('tbody').addClass('tbody-onload');
                    $('.ajax-loader').removeClass('hidden');
                },
                success:function(data)
                {
//                    if(data == "empty"){
//                        alert('No Date for this filter')
//                    }
                    $('tbody').html('');
                    $('tbody').html(data);
                },
//                error: function(xhr) { // if error occured
//                    alert("Error occured.please try again");
//                    $('tbody').addClass('hidden')
//
//                },
                complete:function () {
                    $('tbody').removeClass('tbody-onload');
                    $('.ajax-loader').addClass('hidden');
                    $('#filter-order').attr("disabled", false);
                    $('.hidden-privent').removeClass('hidden-privent');
                }
            })
        }

        $(document).on('click', '#filter-order', function(){
            var query = $('#search-text').val();
             $('#search_page').val(query);

            $('#hidden_page').val(1);

            var district = $('#district_select').val();
            $('#district_page').val(district);

            var payment = $('#payment').val();
            $('#payment_page').val(payment);

            var start_date = $('#start_date').val();
            $('#start_date_page').val(start_date);

            var end_date = $('#end_date').val();
            $('#end_date_page').val(end_date);

            var page = $('#hidden_page').val();
            fetch_data(page, district, payment, query, start_date, end_date);
        });



        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var district = $('#district_page').val();
            var payment = $('#payment_page').val();
            var start_date = $('#start_date_page').val();
            var end_date = $('#end_date_page').val();

            var query = $('#search_page').val();

            $('li').removeClass('active');
            $(this).parent().addClass('active');
            fetch_data(page, district, payment, query, start_date, end_date);
        });

    });

    $("#checkAllOrder").change(function(){

        $this = $(this);
        var status = this.checked;
        $('.order').each(function(){ //iterate all listed checkbox items
            this.checked = status; //change ".checkbox" checked status
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
    $(document).on('click', '.bulk_barcode', function () {
        var query = {
            ids: multiple_values('order')
        }
        if(query.ids.length <= 0){
            alert("Please select Orders");
        }else {
            alert("Are you to Print Multiple Barcode");

            var url = "{{ route('admin.order.bulk.barcode') }}?" + $.param(query)
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

    $('.select2').select2();
    $('.hidden-privent').removeClass('hidden-privent');


</script>
@endpush

