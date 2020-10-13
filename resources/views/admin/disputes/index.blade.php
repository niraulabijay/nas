@extends('admin.layouts.app')
@section('title', 'Disputes Management')

@section('content')
    <section>
        <div class="row">
            <h3>Dispute List</h3>
            <div class="col-xs-12 content__box content__box--shadow">
                <table class="table table-striped table-hover table-bordered text-center" id="dispute-list">
                    <thead>
                    <tr>
                        <th class="text-center">SN</th>
                        <th class="text-center">Buyer Name</th>
                        <th class="text-center">Reason</th>
                        <th class="text-center">Seller Name</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($disputes))
                    @foreach($disputes as $order_product)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{\App\User::where('id', $order_product->order->user_id)->first()->first_name}}</td>
                        <td>{{\App\Model\Dispute::where('order_product_id', $order_product->id)->first()->message}}</td>
                        <td>{{\App\User::where('id', $order_product->owner_id)->first()->first_name}}</td>
                        <td>
                        @if(\App\Model\Dispute::where('order_product_id', $order_product->id)->first()->status == '1')
                            <button class="btn btn-danger btn-xs dispute_status" data-id="{{$order_product->id}}">Opened</button>
                        @elseif(\App\Model\Dispute::where('order_product_id', $order_product->id)->first()->status == '0')
                                <button class="btn btn-success btn-xs dispute_status" data-id="{{$order_product->id}}">Closed</button>
                        @else
                                <button class="btn btn-warning btn-xs dispute_status" data-id="{{$order_product->id}}">Unapproved</button>
                        @endif
                        </td>
                        <td><a href="{{route('admin.disputes.view_details', \App\Model\Dispute::where('order_product_id', $order_product->id)->first()->id)}}"><span class="fa fa-eye text-danger"></span></a></td>
                    </tr>
                    @endforeach
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <th class="text-center">SN</th>
                        <th class="text-center">Buyer Name</th>
                        <th class="text-center">Reason</th>
                        <th class="text-center">Seller Name</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    $('document').ready(function () {
       $('#dispute-list').DataTable();
    });

    $(document).on("click", ".dispute_status", function (e) {
        e.preventDefault();
        var $this = $(this);

        var id = $this.attr('data-id');
        var tempUpdateUrl = "{{ route('admin.disputes.status_update', ':id') }}";
        tempUpdateUrl = tempUpdateUrl.replace(':id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: tempUpdateUrl,
//            contentType: false,
//            processData: false,
//            cache: false,
            data: id,
            beforeSend: function (data) {
            },
            success: function (data) {
//                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {

            },
            complete: function () {
                window.location.reload();
            }
        });
    });
</script>
@endpush