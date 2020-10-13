@extends('admin.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>All Orders
            <small>({{ $ordersCount }})</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-userpanel"></i>Home</a></li>
            <li class="active">Orders</li>
        </ol>
        <div class="box-header">
                        <h3 class="box-title">All Orders <small>({{ $ordersCount }})</small></h3>
                        <a href="{{ route('admin.order.create') }}" class="btn btn-sm btn-danger pull-right">Add New</a>
                    </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">All Orders</h3>
                        
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
                                <th class="sorting-false">Action</th>
                            </tr>
                            </thead>
                            <tbody><h2><center>You Have No Orders</center></h2></tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Status</th>
                                <th>Order</th>
                                <th>Purchased</th>
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
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
  
@endpush