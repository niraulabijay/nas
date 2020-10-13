@extends('admin.layouts.app')
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
            <form action="{{ route('admin.existing.product') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    {!! Form::select('product', $products, null, ['class' => 'form-control select2', 'placeholder' => 'Select Existing Product']) !!}
                </div>
                <button type="submit" class="btn btn-primary">Create with existing product</button>
                <a href="{{ route('admin.products.create.new') }}" class="btn btn-primary pull-right">Add New</a>
            </form>
            <div class="clearfix"></div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
            $('.select2').select2({
                placeholder: 'Select Existing Product'
            });
        });
</script>
@endpush