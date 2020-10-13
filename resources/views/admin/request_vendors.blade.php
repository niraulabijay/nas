@extends('admin.layouts.app')
@section('title', 'Vendor Requests') 

@section('content')
  <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">
    @include('partials.message-success')

    <div class="table-responsive">
                <table class="table table-straped table-hovered" id="vendor_request">
            <thead>
            <tr>
                <th>S.N.</th>
                <th>Shop Name</th>
                <th>Phone</th>
                <th>Type</th>

                <th>Email</th>
                <th>Pan No</th>
                <th>Tax Clearance No</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
            </thead>
          
            <tbody>
            @foreach($requests as $request)
            <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{$request->name}}</td>
            <td>{{ $request->primary_phone }}</td>
            <td>{{ $request->type }}</td>
            <td>{{$request->primary_email}}</td>
             <td>{{$request->pan_number}}</td>
             <td>{{$request->tax_clearance}}</td>
              <td>{{$request->address}}</td>
            <td>
                <a  href="{{ route('admin.request.view', $request->id) }}"class="btn btn-default btn-xs btn-view" ><span class="lnr lnr-eye"></span></a>
                
                <form method="post" action="{{route('admin.request.delete')}}" style="display:block;float:right;">
                    <input type="hidden" name="id" value="{{$request->id}}">

                    {{csrf_field()}}<button  type="submit" class="btn btn-danger btn-xs"><span class="lnr lnr-trash"></span></button>
                </form>


            </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </section>
@endsection
@push('scripts')
<script>
    $(document).ready( function () {
        $('#vendor_request').DataTable();
    } );
</script>

@endpush