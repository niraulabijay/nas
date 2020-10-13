@extends('admin.layouts.app')
@section('title', 'Brand')
@section('content')
    <div class="col-sm-5 col-sm-offset-3">
      <h3>Edit Payment Method <span style="color:  #CCC;font-size: 20px;"> > {{$payment->name}}</span></h3>
        <form action="{{route('admin.payment.update')}}" enctype="multipart/form-data" method="post">
          <input type="hidden" name="id" value="{{$payment->id}}">
      {{csrf_field()}}
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" value="{{$payment->name}}">
      </div>

      <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image" class="form-control" value="" id="image">
        @if($payment->getImage())
          <img src="{{$payment->getImage()->smallUrl}}" alt="Image" style="width:50%;height:auto;">
        @endif

      </div>

      <div class="form-group">
        <label for="company_name">Company Name</label>
        <input type="text" name="company_name" class="form-control" value="{{$payment->company_name}}">
      </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
    </form>
    </div>
  @endsection
