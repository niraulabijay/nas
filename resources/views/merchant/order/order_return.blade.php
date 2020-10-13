@extends('merchant.layouts.app')
@section('title', 'Order Returns')

@section('content')
    <section>
        <div class="row">
            <h3>Order Returns</h3>
            <div class="col-sm-12 content__box content__box--shadow">
                <table class="table table-striped table-hover" id="orderReturnTable">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>Product Name</th>
                        <th>Address</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>Product Name</th>
                        <th>Address</th>
                        <th>Date</th>
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
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'order_return_status',
                    render: function (data, type, row) {
                        var orderReturnStatus = data.status
                        var statusClass = data.class;

                        return '<span class="label label-' + statusClass + '">' + orderReturnStatus + '</span>';
                    }
                },
                {
                    data: 'userOrder',
                    render: function (data, type, row) {
                        var orderId = data.order_id;
                        var userId = data.user_id;
                        var userName = data.username;
                        var userEmail = data.email;

                        {{--var orderLink = "{{ url('/dashboard/order') }}" + "/" + orderId + "/edit";--}}
                        {{--var userLink = userId ? "{{ url('/dashboard/user') }}" + "/" + userId + "/edit" : "javascript:void(0);";--}}

                        var userOrder = "<ul class='no-margin no-padding no-list-style' style='list-style: none'>";
                        userOrder += "<li><a href='#'>#" + orderId + "</a> by ";
                        userOrder += "<a href=''>";
                        userOrder += userName ? userName + " " : "Guest";
                        userOrder += "</a></li>";
                        userOrder += userEmail ? "<li><a href='mailto:" + userEmail + "'> " + userEmail + "</a></li>" : "";
                        userOrder += "</ul>";

                        return userOrder;
                    }
                },
                {
                    data: 'products',
                    render: function (data, type, row) {
                        var products = '<ul class="no-margin no-padding no-list-style" style="list-style:none;">';
//                        $.each(data, function (index, value) {
                            {{--var productLink = "{{ url('/vendor/product') }}" + "/" + value.product_id + "/edit";--}}
                            products += "<li><a href='#'><label class='label label-default'>" + data.qty + "</label> " + data.name + "</a></li>";
//                        });

                        products += "</ul>";

                        return products;
                    }
                },
                {
                    data: 'address',
                    render: function (data, type, row) {
                        var first_name = data.address_first_name;
                        var last_name = data.address_last_name;
                        var district = data.address_district;
                        var zone = data.address_zone;
                        var area = data.address_area;

                        var address = first_name + ' ' + last_name;
                        address += zone ? '<br>' + zone : '';
                        address += district ? '<br>' + district : '';
                        address += area ? '<br>' + area : '';

                        return "<a href='javascript:void(0);'>" + address + "</a>";
                    }
                },
                {
                    data: 'order_date',
                    render: function (data, type, row) {

                        return data;
                    }
                }
            ],
            ajax: '{{ route('vendor.order_return.json') }}'
        });
    });
</script>
@endpush