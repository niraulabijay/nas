@extends('admin.layouts.app')
@section('title', 'Edit Shipping Amount')

@section('content')
    @include('partials.message-success')
    @include('partials.message-error')

    <section>
        <div class="row">
            <h3>Edit Shipping Amount</h3>
            <div class="col-sm-12">
                <form action="{{ route('admin.shipping_amount.update') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $shipping_amount->id }}">
                    <div class="form-group ">
                        <label for="name"> Name:</label>
                        <input type="text" name="name" value="{{$shipping_amount->name}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name"> Type:</label>
                        <select name="type" id="theSelect" class="form-control">
                            <option value="State" @if($shipping_amount->type == "State") selected @endif >State</option>
                            <option value="District" @if($shipping_amount->type == "District") selected @endif >District</option>
                            <option value="Area" @if($shipping_amount->type == "Area") selected @endif >Area</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="parent_id">Select Parent Catgory:</label>
                        <select name="parent_id" id="theSelect" class="form-control">
                            <option value="0">Select Areas</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @include('admin.shipping_amount.dropdown')
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name"> Amount:</label>
                        <input type="integer" name="value" value="{{$shipping_amount->value}}" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-danger pull-right">Save</button>

                </form>
            </div>
        </div>
    </section>
@endsection