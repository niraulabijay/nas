@extends('admin.layouts.app')
@section('title', 'Settings')

@section('content')
    @include('partials.message-success')
    @include('partials.message-error')
    <form action="{{ route('admin.settings.update') }}" method="post" class="form-horizontal"
          enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('category_ads_1') ? ' has-error' : '' }}">
            <label for="category_ads_1" class="col-sm-2 control-label">Home Ad Title 1 *</label>
            <div class="col-sm-10">
                <input type="text" name="category_ads_1" class="form-control" id="category_ads_1"
                       value="{{ getConfiguration('category_ads_1') }}">
                @if ($errors->has('category_ads_1'))
                    <span class="help-block">
                    {{ $errors->first('category_ads_1') }}
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('category_ads_link_1') ? ' has-error' : '' }}">
            <label for="category_ads_link_1" class="col-sm-2 control-label">Home Ad Link 1*</label>
            <div class="col-sm-10">
                <input type="text" name="category_ads_link_1" class="form-control" id="category_ads_link_1"
                       value="{{ getConfiguration('category_ads_link_1') }}">
                @if ($errors->has('category_ads_link_1'))
                    <span class="help-block">
                    {{ $errors->first('category_ads_link_1') }}
                </span>
                @endif
            </div>

        </div>
        <div class="form-group{{ $errors->has('category_ads_image_1') ? ' has-error' : '' }}">
            <label for="category_ads_image_1" class="col-sm-2 control-label">Home Ad Image 1</label>
            <div class="col-sm-10">
                <input type="file" name="category_ads_image_1" id="category_ads_image_1" class="form-control">
                @if ($errors->has('category_ads_image_1'))
                    <span class="help-block">
                    {{ $errors->first('category_ads_image_1') }}
                </span>
                @endif
                @if(getConfiguration('category_ads_image_1') && getConfiguration('category_ads_image_1')!=null)
                    <div class="mt-15 half-width adsoverlay" style="width: 30%;">
                    <button class="btn btn-danger btn-sm pull-right btn-remove-ads" img-id="category_ads_image_1"> <i class=" fa fa-trash"></i></button>
                    <img src="{{ url('storage') . '/' . getConfiguration('category_ads_image_1') }}"
                             class="thumbnail img-responsive">
                    </div>
                @endif
            </div>
        </div>


        <div class="form-group{{ $errors->has('category_ads_2') ? ' has-error' : '' }}">
            <label for="category_ads_2" class="col-sm-2 control-label">Home Ad Title 2 *</label>
            <div class="col-sm-10">
                <input type="text" name="category_ads_2" class="form-control" id="category_ads_2"
                       value="{{ getConfiguration('category_ads_2') }}">
                @if ($errors->has('category_ads_2'))
                    <span class="help-block">
                    {{ $errors->first('category_ads_2') }}
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('category_ads_link_2') ? ' has-error' : '' }}">
            <label for="category_ads_link_2" class="col-sm-2 control-label">Home Ad Link 2*</label>
            <div class="col-sm-10">
                <input type="text" name="category_ads_link_2" class="form-control" id="category_ads_link_2"
                       value="{{ getConfiguration('category_ads_link_2') }}">
                @if ($errors->has('category_ads_link_2'))
                    <span class="help-block">
                    {{ $errors->first('category_ads_link_2') }}
                </span>
                @endif
            </div>

        </div>
        <div class="form-group{{ $errors->has('category_ads_image_2') ? ' has-error' : '' }}">
            <label for="category_ads_image_2" class="col-sm-2 control-label">Home Ad Image 2</label>
            <div class="col-sm-10">
                <input type="file" name="category_ads_image_2" id="category_ads_image_2" class="form-control">
                @if ($errors->has('category_ads_image_2'))
                    <span class="help-block">
                    {{ $errors->first('category_ads_image_2') }}
                </span>
                @endif
                @if(getConfiguration('category_ads_image_2') && getConfiguration('category_ads_image_2')!=null )
                    <div class="mt-15 adsoverlay" style="width: 30%;">
                        <button class="btn btn-danger btn-sm pull-right btn-remove-ads" img-id="category_ads_image_2"> <i class=" fa fa-trash"></i></button>
                        <img src="{{ url('storage') . '/' . getConfiguration('category_ads_image_2') }}"
                             class="thumbnail img-responsive">
                    </div>
                @endif
            </div>
        </div>


        <div class="form-group{{ $errors->has('category_ads_3') ? ' has-error' : '' }}">
            <label for="category_ads_3" class="col-sm-2 control-label">Home Ad Title 3 *</label>
            <div class="col-sm-10">
                <input type="text" name="category_ads_3" class="form-control" id="category_ads_3"
                       value="{{ getConfiguration('category_ads_3') }}">
                @if ($errors->has('category_ads_3'))
                    <span class="help-block">
                    {{ $errors->first('category_ads_3') }}
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('category_ads_link_3') ? ' has-error' : '' }}">
            <label for="category_ads_link_3" class="col-sm-2 control-label">Home Ad Link 3*</label>
            <div class="col-sm-10">
                <input type="text" name="category_ads_link_3" class="form-control" id="category_ads_link_3"
                       value="{{ getConfiguration('category_ads_link_3') }}">
                @if ($errors->has('category_ads_link_3'))
                    <span class="help-block">
                    {{ $errors->first('category_ads_link_3') }}
                </span>
                @endif
            </div>

        </div>
        <div class="form-group{{ $errors->has('category_ads_image_3') ? ' has-error' : '' }}">
            <label for="category_ads_image_3" class="col-sm-2 control-label">Home Ad Image 3</label>
            <div class="col-sm-10">
                <input type="file" name="category_ads_image_3" id="category_ads_image_3" class="form-control">
                @if ($errors->has('category_ads_image_3'))
                    <span class="help-block">
                    {{ $errors->first('category_ads_image_3') }}
                </span>
                @endif
                @if(getConfiguration('category_ads_image_3') && getConfiguration('category_ads_image_3')!==null)
                    <div class="mt-15 half-width adsoverlay" style="width: 30%;">
                        <button class="btn btn-danger btn-sm pull-right btn-remove-ads" img-id="category_ads_image_3"> <i class=" fa fa-trash"></i></button>
                        <img src="{{ url('storage') . '/' . getConfiguration('category_ads_image_3') }}"
                             class="thumbnail img-responsive">
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('category_ads_4') ? ' has-error' : '' }}">
            <label for="category_ads_4" class="col-sm-2 control-label">Home Ad Title 4 *</label>
            <div class="col-sm-10">
                <input type="text" name="category_ads_4" class="form-control" id="category_ads_4"
                       value="{{ getConfiguration('category_ads_4') }}">
                @if ($errors->has('category_ads_4'))
                    <span class="help-block">
                    {{ $errors->first('category_ads_4') }}
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('category_ads_link_4') ? ' has-error' : '' }}">
            <label for="category_ads_link_4" class="col-sm-2 control-label">Home Ad Link 4*</label>
            <div class="col-sm-10">
                <input type="text" name="category_ads_link_4" class="form-control" id="category_ads_link_4"
                       value="{{ getConfiguration('category_ads_link_4') }}">
                @if ($errors->has('category_ads_link_4'))
                    <span class="help-block">
                    {{ $errors->first('category_ads_link_4') }}
                </span>
                @endif
            </div>

        </div>
        <div class="form-group{{ $errors->has('category_ads_image_4') ? ' has-error' : '' }}">
            <label for="category_ads_image_4" class="col-sm-2 control-label">Home Ad Image 4</label>
            <div class="col-sm-10">
                <input type="file" name="category_ads_image_4" id="category_ads_image_4" class="form-control">
                @if ($errors->has('category_ads_image_4'))
                    <span class="help-block">
                    {{ $errors->first('category_ads_image_4') }}
                </span>
                @endif
                @if(getConfiguration('category_ads_image_4') && getConfiguration('category_ads_image_4')!==null)
                    <div class="mt-15 half-width adsoverlay" style="width: 30%;">
                        <button class="btn btn-danger btn-sm pull-right btn-remove-ads" img-id="category_ads_image_4"> <i class=" fa fa-trash"></i></button>
                        <img src="{{ url('storage') . '/' . getConfiguration('category_ads_image_4') }}"
                             class="thumbnail img-responsive">
                    </div>
                @endif
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-danger pull-right">Update</button>

        </div>
        <div class="clearfix"></div>
    </form>
    </div>
@endsection

@push('scripts')

    <script>
        $(document).on('click','.btn-remove-ads',function(e){
            e.preventDefault();
            var self=$(this);
            var img= $(this).attr('img-id');
            var confi=confirm('Do You want to delete?');
            if(confi){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.front.ads.delete') }}" ,
                    data:{
                        key:  img
                    },
                    success: function (data) {
                        console.log(data);
                        self.parent().remove();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        })
    </script>
    @endpush
<!-- /.tab-pane -->