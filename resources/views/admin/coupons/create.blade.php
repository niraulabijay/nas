@extends('admin.layouts.app')
@section('title', 'Coupons')

@section('content')
    @include('partials.message-success')
    @include('partials.message-error')
    <section>
        <div class="row">
            <h3>Add New Coupon</h3>
            <div class="col-sm-12">
                {!! Form::open(['route' => 'admin.coupon.store', 'method' => 'post', 'files' => true]) !!}
                @include('admin.coupons.form', ['submitBtn' => 'Save'])
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    $(function () {
        $('.select2').select2({placeholder: 'Select Options'});
    });
</script>
@endpush