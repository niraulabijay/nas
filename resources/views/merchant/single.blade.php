{{--@extends('merchant.layouts.app')--}}

{{--@section('content')--}}
{{--<section class="content__box content__box--shadow">--}}
    {{--<h3>Products <small>({{ $name }}-{{ $productsCount }})</small></h3>--}}
{{--</section>--}}
{{--<section class="content__box content__box--shadow">--}}
	{{--<table id="productsTable" class="table table-striped example" cellspacing="0" width="100%">--}}
	    {{--<thead>--}}
	        {{--<tr>--}}
	            {{--<th>Sn</th>--}}
	            {{--<th>Name</th>--}}
	            {{--<th>Slug</th>--}}
	            {{--<th>Price</th>--}}
                {{--<th>Sale Price</th>--}}
                {{--<th>Discount (%)</th>--}}
	            {{--<th>Status</th>--}}
	            {{--<th>Actions</th>--}}
	            {{--<th>Date</th>--}}
	        {{--</tr>--}}
	    {{--</thead>--}}
	    {{--<tbody>--}}
	    {{--</tbody>--}}
	    {{--<tfoot>--}}
	        {{--<tr>--}}
	            {{--<th>Sn</th>--}}
	            {{--<th>Name</th>--}}
	            {{--<th>Slug</th>--}}
	            {{--<th>Price</th>--}}
                {{--<th>Sale Price</th>--}}
                {{--<th>Discount (%)</th>--}}
	            {{--<th>Status</th>--}}
	            {{--<th>Actions</th>--}}
	            {{--<th>Date</th>--}}
	        {{--</tr>--}}
	    {{--</tfoot>--}}
	{{--</table>--}}
{{--</section>--}}
{{--@endsection--}}
    {{--@php--}}
        {{--$route = route('vendor.dashboard.json') .'?name=' .$name;--}}
    {{--@endphp--}}
{{--@push('scripts')--}}
{{--<script>--}}
    {{--$(document).ready(function($) {--}}
        {{--$("#productsTable").DataTable({--}}
            {{--aaSorting: [0,'desc'],--}}
            {{--processing: true,--}}
            {{--serverSide: true,--}}
            {{--columns: [--}}
                {{--{--}}
                {{--"data": "id",--}}
                   {{--render: function (data, type, row, meta) {--}}
                       {{--return meta.row + meta.settings._iDisplayStart + 1;--}}
                   {{--}--}}
                {{--},--}}
                {{--{data: 'name',--}}
                    {{--render: function (data, type, row) {--}}
                            {{--var productViewUrl = "{{ route('vendor.products.edit', ':id') }}";--}}

                            {{--productViewUrl = productViewUrl.replace(':id', row.id);--}}

                            {{--return '<a href="' + productViewUrl + '">' + data + '</a>';--}}
                        {{--}--}}
                {{--},--}}
                {{--{data: 'slug', name: 'slug'},--}}
                {{--{data: 'product_price', name: 'product_price'},--}}
                {{--{data: 'sale_price', name: 'sale_price'},--}}
                {{--{data: 'discount',--}}
                    {{--render: function(data, type, row) {--}}
                        {{--var price = parseInt(row.product_price);--}}
                        {{--var sale_price = parseInt(row.sale_price);--}}
                        {{--var discount = (((price - sale_price)/price ) * 100).toFixed(2);--}}
                        {{--return discount;--}}
                    {{--}--}}
                {{--},--}}
                {{--{data: 'approved', name: 'approved',--}}
                    {{--render: function(data, type, row) {--}}
                        {{--return data === '1' ? '<span class="label label-success">Approved</span>' : '<span class="label label-danger">Pending</span>';--}}
                    {{--}--}}
                {{--},--}}
                {{--{--}}
                    {{--data: 'id',--}}
                    {{--orderable: false,--}}
                    {{--render: function (data, type, row) {--}}
                        {{--var tempViewUrl = "{{ route('admin.singleProduct', ':id') }}";--}}
                        {{--tempViewUrl = tempViewUrl.replace(':id', data);--}}
                        {{--var actions = '';--}}
                        {{--actions += "<a href='"+ tempViewUrl +"' class='btn btn-xs btn-default btn-products-edit' data-id=" + row.id + " style='margin-right:5px'><span class='lnr lnr-eye'></span></a>";--}}

                        {{--return actions;--}}
                    {{--}--}}
                {{--},--}}
                {{--{data: 'created_at', name: 'created_at',}--}}
            {{--],--}}
           {{--ajax: "{!! $route  !!}"--}}
        {{--});--}}
    {{--});--}}
{{--</script>--}}
{{--@endpush--}}