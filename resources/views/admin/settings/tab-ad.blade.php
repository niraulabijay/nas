@role(['manager'])



<div class="tab-pane active" id="ad">
@endrole
@role(['admin'])



<div class="tab-pane " id="ad">
@endrole
    <div class="form-group{{ $errors->has('header_ad') ? ' has-error' : '' }}">
        <label for="header_ad" class="col-sm-2 control-label">Header Ad</label>
        <div class="col-sm-10">
            <input type="file" name="header_ad" id="header_ad" class="form-control">
            @if ($errors->has('header_ad'))
                <span class="help-block">
                    {{ $errors->first('header_ad') }}
                </span>
            @endif
        </div>
    </div>
            <div class="form-group{{ $errors->has('header_ad_link') ? ' has-error' : '' }}">
                <label for="header_ad_link" class="col-sm-2 control-label">Header Ad Link*</label>
                <div class="col-sm-10">
                    <input type="text" name="header_ad_link" class="form-control" id="header_ad_link"
                           value="{{ getConfiguration('header_ad_link') }}">
                    @if ($errors->has('header_ad_link'))
                        <span class="help-block">
                    {{ $errors->first('header_ad_link') }}
                </span>
                    @endif
                </div>

            </div>
            @if(getConfiguration('header_ad'))
                <div class="mt-15 half-width">
                    <img src="{{ url('storage') . '/' . getConfiguration('header_ad') }}"
                         class="thumbnail img-responsive">
                </div>
            @endif





    <div class="form-group{{ $errors->has('home_ad_1') ? ' has-error' : '' }}">
        <label for="home_ad_1" class="col-sm-2 control-label">Home Page Ad 1</label>
        <div class="col-sm-10">
            <input type="file" name="home_ad_1" id="home_ad_1" class="form-control">
            @if ($errors->has('home_ad_1'))
                <span class="help-block">
                    {{ $errors->first('home_ad_1') }}
                </span>
            @endif
        </div>
    </div>
            <div class="form-group{{ $errors->has('home_ad_1_link') ? ' has-error' : '' }}">
                <label for="home_ad_1_link" class="col-sm-2 control-label">Home Page Ad 1 Link*</label>
                <div class="col-sm-10">
                    <input type="text" name="home_ad_1_link" class="form-control" id="home_ad_1_link'"
                           value="{{ getConfiguration('home_ad_1_link') }}">
                    @if ($errors->has('home_ad_1_link'))
                        <span class="help-block">
                    {{ $errors->first('home_ad_1_link') }}
                </span>
                    @endif
                </div>
            </div>

            @if(getConfiguration('home_ad_1'))
                <div class="mt-15 half-width">
                    <img src="{{ url('storage') . '/' . getConfiguration('home_ad_1') }}"
                         class="thumbnail img-responsive">
                </div>
            @endif

    <div class="form-group{{ $errors->has('home_ad_2') ? ' has-error' : '' }}">
        <label for="home_ad_2" class="col-sm-2 control-label">Home Page Ad 2</label>
        <div class="col-sm-10">
            <input type="file" name="home_ad_2" id="home_ad_2" class="form-control">
            @if ($errors->has('home_ad_2'))
                <span class="help-block">
                    {{ $errors->first('home_ad_2') }}
                </span>
            @endif
        </div>
    </div>
            <div class="form-group{{ $errors->has('home_ad_2_link') ? ' has-error' : '' }}">
                <label for="home_ad_1_link" class="col-sm-2 control-label">Home Page Ad 2 Link*</label>
                <div class="col-sm-10">
                    <input type="text" name="home_ad_2_link" class="form-control" id="home_ad_2_link'"
                           value="{{ getConfiguration('home_ad_2_link') }}">
                    @if ($errors->has('home_ad_2_link'))
                        <span class="help-block">
                    {{ $errors->first('home_ad_2_link') }}
                </span>
                    @endif
                </div>
            </div>

            @if(getConfiguration('home_ad_2'))
                <div class="mt-15 half-width">
                    <img src="{{ url('storage') . '/' . getConfiguration('home_ad_2') }}"
                         class="thumbnail img-responsive">
                </div>
            @endif



    <div class="form-group{{ $errors->has('home_side_ad_1') ? ' has-error' : '' }}">
        <label for="home_side_ad_1" class="col-sm-2 control-label">Home Page Side Ad 1</label>
        <div class="col-sm-10">
            <input type="file" name="home_side_ad_1" id="home_side_ad_1" class="form-control">
            @if ($errors->has('home_side_ad_1'))
                <span class="help-block">
                    {{ $errors->first('home_side_ad_1') }}
                </span>
            @endif
        </div>
    </div>
            <div class="form-group{{ $errors->has('home_side_ad_1_link') ? ' has-error' : '' }}">
                <label for="home_side_ad_1_link" class="col-sm-2 control-label">Home Page Side Ad 1 Link*</label>
                <div class="col-sm-10">
                    <input type="text" name="home_side_ad_1_link" class="form-control" id="home_side_ad_1_link"
                           value="{{ getConfiguration('home_side_ad_2_link') }}">
                    @if ($errors->has('home_side_ad_1_link'))
                        <span class="help-block">
                    {{ $errors->first('home_side_ad_1_link') }}
                </span>
                    @endif
                </div>
            </div>

            @if(getConfiguration('home_side_ad_1'))
                <div class="mt-15 half-width">
                    <img src="{{ url('storage') . '/' . getConfiguration('home_side_ad_1') }}"
                         class="thumbnail img-responsive">
                </div>
            @endif

    <div class="form-group{{ $errors->has('home_side_ad_2') ? ' has-error' : '' }}">
        <label for="home_side_ad_2" class="col-sm-2 control-label">Home Page Side Ad 2</label>
        <div class="col-sm-10">
            <input type="file" name="home_side_ad_2" id="home_side_ad_2" class="form-control">
            @if ($errors->has('home_side_ad_2'))
                <span class="help-block">
                    {{ $errors->first('home_side_ad_2') }}
                </span>
            @endif
        </div>
    </div>
            <div class="form-group{{ $errors->has('home_side_ad_2_link') ? ' has-error' : '' }}">
                <label for="home_side_ad_2_link" class="col-sm-2 control-label">Home Page Side Ad 2 Link*</label>
                <div class="col-sm-10">
                    <input type="text" name="home_side_ad_2_link" class="form-control" id="home_side_ad_2_link"
                           value="{{ getConfiguration('home_side_ad_2_link') }}">
                    @if ($errors->has('home_side_ad_2_link'))
                        <span class="help-block">
                    {{ $errors->first('home_side_ad_2_link') }}
                </span>
                    @endif
                </div>
            </div>

            @if(getConfiguration('home_side_ad_2'))
                <div class="mt-15 half-width">
                    <img src="{{ url('storage') . '/' . getConfiguration('home_side_ad_2') }}"
                         class="thumbnail img-responsive">
                </div>
            @endif


    <div class="form-group{{ $errors->has('single_ad') ? ' has-error' : '' }}">
        <label for="single_ad" class="col-sm-2 control-label">Single Page Ad</label>
        <div class="col-sm-10">
            <input type="file" name="single_ad" id="single_ad" class="form-control">
            @if ($errors->has('single_ad'))
                <span class="help-block">
                    {{ $errors->first('single_ad') }}
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('single_ad_link') ? ' has-error' : '' }}">
        <label for="single_ad_link" class="col-sm-2 control-label">Single Page Ad Link*</label>
        <div class="col-sm-10">
            <input type="text" name="single_ad_link" class="form-control" id="single_ad_link"
                   value="{{ getConfiguration('single_ad_link') }}">
            @if ($errors->has('single_ad_link'))
                <span class="help-block">
                    {{ $errors->first('single_ad_link') }}
                </span>
            @endif
        </div>
    </div>

    @if(getConfiguration('single_ad_link'))
        <div class="mt-15 half-width">
            <img src="{{ url('storage') . '/' . getConfiguration('single_ad') }}"
                 class="thumbnail img-responsive">
        </div>
    @endif
</div>
