@extends('merchant.layouts.app')
@section('title', 'Disputes')

@section('content')
    <section>
        <div class="row">
            <h3>Dispute List</h3>
            @if(!empty($myDisputes))
            <div class="col-xs-12 content__box content__box--shadow">
                <table class="table table-striped table-hover" id="disputeVendorTable">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Product Name</th>
                        <th>Customer Name</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($myDisputes as $dispute)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td> {{$dispute->product->products->name}} </td>
                        <td> {{$dispute->product->order->user->first_name . ' ' . $dispute->product->order->user->last_name}} </td>
                        <td>{{ \Carbon\Carbon::parse($dispute->created_at)->format('F j, Y')}}</td>
                        <td><a href="{{route('vendor.disputes.view', $dispute->id )}}"><span class="fa fa-eye text-danger"></span></a></td>
                    </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Product Name</th>
                        <th>Customer Name</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            @else
                <div class="col-xs-12 content__box content__box--shadow">
                    <h4 class="text-center">No Disputes Yet.</h4>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
    $(document).ready(function (){
       $('#disputeVendorTable').DataTable();
    });
</script>
@endpush