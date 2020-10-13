@extends('merchant.layouts.app')
@section('title',"Add Product")

@section('content')

    @include('partials.message-success')
    @include('partials.message-error')

    @if(count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $e)
                    <li> {{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <section class="content__box content__box--shadow">
        <div class="  details-of-orders">
            <span class="title">Add Products</span>
            <form action="{{ route('vendor.existing.product') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <select name="product" class="form-control select2">
                        <option>Select Existing Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Create with existing product</button>
                <a href="{{ route('vendor.products.create.new') }}" class="btn btn-primary pull-right">Add New</a>
            </form>
            <div class="clearfix"></div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
            $('.select2').select2();
        });
</script>
@endpush