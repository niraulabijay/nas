@extends('admin.layouts.app')
@section('title', 'Brand')
@section('content')
    @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $e)
                    <li> {{ $e }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    <section>
        <div class="modal right fade" id="quickViewModal" tabindex="-1"></div>

        <div class="row">
            <h3>Delivery Destination</h3>
            @include('admin.destination.form')
            <div class="col-md-8 content__box content__box--shadow">
                <table id="myTable" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Remark</th>
                        <th>Orders(COD)</th>
                        <th class="sorting-false">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    @foreach($destinations as $destination)
                        <tr>
                            <th>{{$destination->id}}</th>
                            <th>{{$destination->name}}</th>
                            <th>{{$destination->remark}}</th>
                            <th>{{ App\Model\Order::where('delivery_destination_id', $destination->id)->where('payment_method_id', 1)->count() }}</th>
                            <th class="sorting-false">
                                <a href="{{ route('admin.delivery.edit',[$destination->id]) }}" class="btn btn-danger btn-xs btn-delete-feature" data-feature=""><i class="fa fa-edit"></i></a>
                                <a href="{{ route('admin.delivery.delete',[$destination->id]) }}" class="btn btn-danger btn-xs btn-delete-feature" data-feature=""><i class="fa fa-trash"></i></a>
                            </th>
                        </tr>
                    @endforeach
                    </tfoot>
                </table>
            </div>
        </div>
    </section>

@endsection

