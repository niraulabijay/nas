@extends('admin.layouts.app')
@section('title', 'Commissions')

@section('content')
    @include('partials.message-success')
    @include('partials.message-error')
    <section>
        <div class="row">
            <h3>{{ isset($commission)? 'Edit' : 'Add'}} Commission</h3>
            <div class="col-sm-12">
                {!! Form::model($commission, ['route' => 'admin.commission.update', 'method' => 'post', 'files' =>true]) !!}
                {!! Form::hidden('vendor_id', isset($commission)? $commission->user_id : $vendor->id ) !!}
                @include('admin.commissions.form', ['submitBtn' => isset($commission)? 'Update' : 'Save'])
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection