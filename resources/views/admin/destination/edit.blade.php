@extends('admin.layouts.app')
@section('title', 'Destination')
@section('content')
    <div class="col-sm-5 col-sm-offset-3">
      <h3>Edit Delivery Destination <span style="color:  #CCC;font-size: 20px;"> > {{$destination->name}}</span></h3>
        <form action="{{route('admin.delivery.update')}}" enctype="multipart/form-data" method="post">
          <input type="hidden" name="id" value="{{$destination->id}}">
      {{csrf_field()}}
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" value="{{$destination->name}}">
      </div>


            <div class="form-group">
                <label for="remark">Remark(optinal)</label>
                <textarea name="remark" class="form-control">{{$destination->remark}}</textarea>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
    </form>
    </div>
  @endsection
