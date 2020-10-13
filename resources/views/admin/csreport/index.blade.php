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
            <li class="active">CS Report</li>
        </ol>
    </section>


    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">


                        <form method="Get" action="{{ route('admin.cs.report.order') }}">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Select CS Name</label>
                                        <select class="form-control" name="cs">
                                            @foreach($customerCares as $customerCare )
                                                <option @if(isset(request()->cs) == $customerCare->id) selected @endif value="{{ $customerCare->id }}">{{ $customerCare->user_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">

                                        <label>Date From</label>
                                        <input type="date" class="form-control" value="{{ request()->start_date }}" name="start_date">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">

                                        <label>Date To</label>
                                        <input type="date" value="{{ request()->end_date }}" class="form-control" name="end_date">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <button style="margin-top: 27px;" class="btn btn-sm btn-success">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                      </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if(isset($csname))
                            <div class="text-center">
                                <div class="panel content__box content__box--shadow" style="width: 400px;margin: 0 auto;">
                                    <div class="text-center">
                                        <h3>{{ $csname->user_name }}</h3>
                                        <div>Total  Order</div>
                                        <div class="huge">{{ $orders->count() }}</div>
                                    </div>
                                </div>
                            </div>
                           @endif
                        <table id="csreporttbl" class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Order No.</th>
                                <th>Status</th>
                                <th>Products</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($orders as $order)
                            <tr>
                                <td></td>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->orderStatus->name }}</td>
                                <td>
                                    <ul class="no-margin no-padding no-list-style" style="list-style: none;">
                                        @foreach($order->orderProduct as $product)
                                        @isset($product->products)
                                        <li>
                                            <a href="#">
                                                <label class="label label-default">{{ $product->qty }}</label> {{ $product->products->name }}
                                            </a>
                                        </li>
                                        @endisset
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                <td><a href="{{ route('admin.order.edit', $order->id) }}" target="_blank" class="btn btn-xs btn-danger mr-5"><span class="lnr lnr-eye"></span></a></td>
                            </tr>

                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Order No.</th>
                                    <th>Status</th>
                                    <th>Products</th>
                                    <th>Date</th>
                                    <th>Action</th>

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>

        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#csreporttbl').DataTable();
    });
    </script>
@endpush