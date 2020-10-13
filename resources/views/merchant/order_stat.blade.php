@extends('merchant.layouts.app')
@section('title', 'All Orders')

@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3>Orders <small>({{ $name }}-{{ $ordersCount }})</small></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Status</th>
                                <th>Order</th>
                                <th>Purchased</th>
                                <th>Address</th>
                                <th>Date</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Status</th>
                                <th>Order</th>
                                <th>Purchased</th>
                                <th>Address</th>
                                <th>Date</th>
                                <th>Total</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@php
    $route = route('vendor.order_stat.json') .'?name=' .$name;
@endphp

@push('scripts')
<script>
    $(document).ready(function () {
        $('.datatable').DataTable({
            aaSorting: [[0, 'desc']],
            columnDefs: [],
            processing: true,
            serverSide: true,
            columns: [
                {
                    data: 'id',
                    render: function (data, type, row) {
                        var orderEditUrl = "{{ route('admin.order.edit', ':id') }}";

                        orderEditUrl = orderEditUrl.replace(':id', data);
                        return '<a href="' + orderEditUrl + '">#' + data + '</a>';
                    }
                },
                {
                    data: 'order_status',
                    render: function (data, type, row) {
                        var statusClass = '';
                        switch (data) {
                            case 'approved':
                                statusClass = "primary";
                                break;
                            case 'pending':
                                statusClass = "warning";
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
                        var userLink = userId ? "{{ url('/') }}" + "/" + userId + "/edit" : "javascript:void(0);";

                        var userOrder = "<ul class='no-margin no-padding no-list-style'>";
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
                        var products = '<ul class="no-margin no-padding no-list-style">';
                        $.each(data, function (index, value) {
                            {{--var productLink = "{{ url('/product') }}" + "/" + value.product_id + "/edit";--}}
                                products += "<li><a href='" + '#' + "'><label class='label label-default'>" + value.qty + "</label> " + value.name + "</a></li>";
                        });

                        products += "</ul>";

                        return products;
                    }
                },
                {
                    data: 'address',
                    render: function (data, type, row) {
                        var first_name = data.address_first_name;
                        var last_name = data.address_last_name;

                        var landmark = data.address_landmark;
                        var street_name = data.address_street_name;
                        var city = data.address_city;

                        var address = first_name+' '+last_name ;
                        address += landmark ? '<br>' + landmark : '';
                        address += street_name ? '<br>' + street_name : '';
                        address += city ? '<br>' + city : '';

                        return "<a href='javascript:void(0);'>" + address + "</a>";
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
                }
            ],
            ajax: "{!! $route  !!}"
        });
    });
</script>
@endpush