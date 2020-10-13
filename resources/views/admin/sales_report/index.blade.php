@extends('admin.layouts.app')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

@section('content')
    <style>
        li{
            text-align: center;
        }
        @media (min-width: 564px) {
            .daterangepicker .ranges ul {
                width: 160px;
            }
        }
        .range_inputs{
            text-align: center;
            padding-bottom: 10px;
        }
    </style>
    <section class="content__box content__box--shadow">
        <div class="  details-of-orders">
            <div class="row">
                <div class="col-sm-3">
                    
                        <div class="form-group">
                    <label>Start Date</label>
                            <input type="text" name="start_date" id="start_date" class="form-control reportrange">
                        </div>

                </div>
                <div class="col-sm-3">
                        <div class="form-group">
                    <label>End Date</label>
                            <input type="text" name="end_date" id="end_date" class="form-control reportrange">
                        </div>

                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                    <label>Status</label>
                    <select name="order_status" class="form-control select2" id="order_status">
                        <option value="0">All Order Status</option>
                        @foreach($orderStatuses as $orderStatus)
                            <option value="{{ $orderStatus->id }}" @if($orderStatus->id == 4) selected @endif >{{ $orderStatus->name }}</option>
                        @endforeach
                    </select>

                </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <button class="btn btn-sm btn-primary report_filter" style="margin-top:25px;">Filter</button>

                    </div>
                </div>



            <div class="clearfix"></div>
        </div>
        </div>
    </section>
    <div class="content__box content__box--shadow">
            <div id="salesReport">
                @include('admin.sales_report.report')
            </div>
    </div>
@endsection

@push('scripts')



<script>
    $(function(){
        $('.report_filter').click(function(e){
//            e.preventDefault();
            var startdate = $('#start_date').val();
            var enddate = $('#end_date').val();
            var orderstatus = $('#order_status').val();


            if (startdate) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url:"{{ route('admin.sales-report.filter') }}",
                    data: {
                        startdate: startdate,
                        enddate: enddate,
                        orderstatus: orderstatus,
                    },
                    success:function(result){
                        
                        $('#salesReport').replaceWith($('#salesReport').html(result));

                        $('#myTable').DataTable({
                            aaSorting: [0,'desc'],
                            processing: true,
                            serverSide: true,
                            columns: [
                                {
                                    "data": "id"},
                                {data: 'product_name'},
                                {data: 'price'},
                                {data: 'qty'},
                                {data: 'shipping'},
                                {data: 'discount'},
                                {data: 'grandTotal'},

                            ],
                            ajax: {

                                url: '{{route('admin.sales-report.json')}}',
                                type:'get',
                                 data: {
                                    startdate: startdate,
                                    enddate: enddate,
                                    orderstatus: orderstatus,
                                },

                            }

                        });
                    }
                });
            }

        });

    });



</script>

<script>

    $(document).ready(function(){
        $('#myTable').DataTable({
            aaSorting: [0,'desc'],
            processing: true,
            serverSide: true,
            columns: [
                {
                    "data": "id"},
                {data: 'product_name'},
                {data: 'price'},
                {data: 'qty'},
                {data: 'shipping'},
                {data: 'discount'},
                {data: 'grandTotal'},

            ],
            ajax: '{{route('admin.sales-report.json')}}'

        });
    });
</script>

@endpush