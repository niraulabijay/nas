@extends('admin.layouts.app')
@section('title', 'Vendor Details')

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
            <tr>
            <td>{{$request->name}}</td>
            <td>{{ $request->primary_phone }}</td>
            <td>{{ $request->type }}</td>
            <td>{{$request->primary_email}}</td>
             <td>{{$request->pan_number}}</td>
             <td>{{$request->tax_clearance}}</td>
              <td>{{$request->address}}</td>
              <td>       <form method="post" action="{{route('admin.vendor.accept')}}" style="display:inline;">
                    <input type="hidden" name="id" value="{{$request->id}}">
                    {{csrf_field()}}<button type="submit" class="btn btn-default btn-xs">Accept</button>
                </form>
         <form method="post" action="{{route('admin.vendor.reject')}}" style="display:block;float:right;">
                    <input type="hidden" name="id" value="{{$request->id}}">

                    {{csrf_field()}}<button  type="submit" class="btn btn-danger btn-xs">Reject</button>
         </form></td>
                 </tbody>
        </table>
        <div class="row">
            
        @if(\App\Model\VendorDocument::where('vendor_detail_id',$request->id)->where('title','pan_image')->first())
        <div class="col-sm-4">
            <h3>Pan Image</h3>
                <a href="{{ url ('').'/'. \App\Model\VendorDocument::where('vendor_detail_id',$request->id)->where('title','pan_image')->first()->image}}" class="product-img-zoom" title="Zoom">

       <img src="{{ url ('').'/'. \App\Model\VendorDocument::where('vendor_detail_id',$request->id)->where('title','pan_image')->first()->image}}" alt="pan_image" style="width:300px;"></a>
       </div>
       @endif
       
       @if(\App\Model\VendorDocument::where('vendor_detail_id',$request->id)->where('title','company_image')->first())
       <div class="col-sm-4">
         <h3>Company Image</h3>
           <a href="{{ url ('').'/'. \App\Model\VendorDocument::where('vendor_detail_id',$request->id)->where('title','company_image')->first()->image}}" class="product-img-zoom" title="Zoom">
       <img src="{{ url ('').'/'. \App\Model\VendorDocument::where('vendor_detail_id',$request->id)->where('title','company_image')->first()->image}}" alt="pan_image" style="width:300px;"></a>
       </div>
       @endif
       
       
       @if(\App\Model\VendorDocument::where('vendor_detail_id',$request->id)->where('title','signature_image')->first())
        <div class="col-sm-4">
            <h3>Signature Image</h3>
           <a href="{{ url ('').'/'. \App\Model\VendorDocument::where('vendor_detail_id',$request->id)->where('title','signature_image')->first()->image}}" class="product-img-zoom" title="Zoom">
       <img src="{{ url ('').'/'. \App\Model\VendorDocument::where('vendor_detail_id',$request->id)->where('title','signature_image')->first()->image}}" alt="pan_image" style="width:300px;"></a>
       </div>
       @endif
       </div>
      </div>
   
             
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
        $('.product-img-zoom').magnificPopup({
            type: 'image'
            // other options
        });
    </script>
    @endpush