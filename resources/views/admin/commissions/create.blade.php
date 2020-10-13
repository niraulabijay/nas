@extends('admin.layouts.app')
@section('title', 'Commissions')

@section('content')
    <section>
        <div class="row">
            <h3>Add Commission</h3>
            <div class="col-sm-12">
                {!! Form::open(['route' => 'admin.commission.store', 'method' => 'post', 'files' =>true]) !!}
                {!! Form::hidden('vendor_id', $vendor->id) !!}
                @include('admin.commissions.form', ['submitBtn' => 'Save'])
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection