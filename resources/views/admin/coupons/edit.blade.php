@extends('admin.layouts.app')
@section('title', 'Coupons')

@section('content')
    @include('partials.message-success')
    @include('partials.message-error')
    <section>
        <div class="row">
            <h3>Edit Coupon</h3>
            <div class="col-sm-12">
                {!! Form::model($coupon, ['route' => 'admin.coupon.update', 'method' => 'post', 'files' => true]) !!}
                {!! Form::hidden('id', $coupon->id) !!}
                @include('admin.coupons.form', ['submitBtn' => 'Save changes'])
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