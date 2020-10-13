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
            <h3>Brands</h3>
            @include('admin.payment.form')
            <div class="col-md-8 content__box content__box--shadow">
                <table id="myTable" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Company Name</th>
                        <th>Image</th>
                        <th class="sorting-false">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    @foreach($payments as $payment)
                        <tr>
                            <th>{{$payment->id}}</th>
                            <th>{{$payment->name}}</th>
                            <th>{{$payment->company_name}}</th>
                            <th><img src="{{ $payment->image }}"> </th>
                            <th class="sorting-false">
                                @if($payment->id != 1)
                                <a href="{{ route('admin.payment.delete',[$payment->id]) }}" class="btn btn-danger btn-xs btn-delete-feature" data-feature=""><i class="fa fa-trash"></i></a>
                                @endif
                                <a href="{{ route('admin.payment.edit',[$payment->id]) }}" class="btn btn-danger btn-xs btn-delete-feature" data-feature=""><i class="fa fa-edit"></i></a>
                            </th>
                        </tr>
                    @endforeach
                    </tfoot>
                </table>
            </div>
        </div>
    </section>

@endsection

