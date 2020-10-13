@extends('admin.layouts.app')
@section('title', 'Coupons')

@section('content')
    @include('partials.message-success')
    @include('partials.message-error')

    <section>
        <div class="row">
            <div>
                <h3>Manage Discount Coupons</h3>
                <a href="{{ route('admin.coupon.create') }}" class="btn btn-default btn-xs pull-right">Add New</a>
            </div>
            <div class="col-sm-12 content__box content__box--shadow">
                <table class="table table-striped table-hover" id="couponTable">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Code</th>
                        <th>Title</th>
                        <th>Discount</th>
                        <th>Used Times</th>
                        <th>Valid Dates</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($coupons as $coupon)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $coupon->code }}</td>
                            <td>{{ $coupon->name }}</td>
                            <td>{{ $coupon->discount_value }}</td>
                            <td>{{\App\Model\OrderProduct::where('coupon_id',$coupon->id)->get()->count()}}</td>
                            <td>
                                @if(!empty($coupon->start_date) && !empty($coupon->end_date))
                                    {{ $coupon->start_date }} To {{ $coupon->end_date }}
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.coupon.edit', $coupon->id) }}"
                                   class="btn btn-default btn-xs"><span class="lnr lnr-pencil"></span></a>
                                <a href="{{ route('admin.coupon.delete', $coupon->id) }}"
                                   onclick="return confirm('Are you sure you want to delete this coupon?');"
                                   class="btn btn-default btn-xs"><span class="lnr lnr-trash"></span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#couponTable').DataTable({
            "columnDefs": [
                {"orderable": false, "targets": 4},
                {"orderable": false, "targets": 5}
            ]
        });
    })
</script>
@endpush