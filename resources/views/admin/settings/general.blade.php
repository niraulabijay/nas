<div class="tab-pane active" id="general">
    <div class="form-group{{ $errors->has('site_title') ? ' has-error' : '' }}">
        <label for="site_title" class="col-sm-2 control-label">Site Title *</label>
        <div class="col-sm-10">
            <input type="text" name="site_title" class="form-control" id="site_title"
                   value="{{ getConfiguration('site_title') }}">
            @if ($errors->has('site_title'))
                <span class="help-block">
                    {{ $errors->first('site_title') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('site_description') ? ' has-error' : '' }}">
        <label for="site_description" class="col-sm-2 control-label">Site Description</label>
        <div class="col-sm-10">
            <input type="text" name="site_description" class="form-control" id="site_description"
                   value="{{ getConfiguration('site_description') }}">
            <span>In a few words, explain what this site is about.</span>
            @if ($errors->has('site_description'))
                <span class="help-block">
                    {{ $errors->first('site_description') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('site_primary_email') ? ' has-error' : '' }}">
        <label for="site_primary_email" class="col-sm-2 control-label">Primary Email *</label>
        <div class="col-sm-10">
            <input type="email" name="site_primary_email" class="form-control" id="site_primary_email"
                   value="{{ getConfiguration('site_primary_email') }}" required>
            @if ($errors->has('site_primary_email'))
                <span class="help-block">
                    {{ $errors->first('site_primary_email') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('site_secondary_email') ? ' has-error' : '' }}">
        <label for="site_secondary_email" class="col-sm-2 control-label">Secondary Email *</label>
        <div class="col-sm-10">
            <input type="email" name="site_secondary_email" class="form-control" id="site_secondary_email"
                   value="{{ getConfiguration('site_secondary_email') }}">
            @if ($errors->has('site_secondary_email'))
                <span class="help-block">
                    {{ $errors->first('site_secondary_email') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('site_primary_phone') ? ' has-error' : '' }}">
        <label for="site_primary_phone" class="col-sm-2 control-label">Primary Phone *</label>
        <div class="col-sm-10">
            <input type="text" name="site_primary_phone" class="form-control" id="site_primary_phone"
                   value="{{ getConfiguration('site_primary_phone') }}" required>
            @if ($errors->has('site_primary_phone'))
                <span class="help-block">
                    {{ $errors->first('site_primary_phone') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('site_secondary_phone') ? ' has-error' : '' }}">
        <label for="site_secondary_phone" class="col-sm-2 control-label">Secondary Phone</label>
        <div class="col-sm-10">
            <input type="text" name="site_secondary_phone" class="form-control" id="site_secondary_phone"
                   value="{{ getConfiguration('site_secondary_phone') }}">
            @if ($errors->has('site_secondary_phone'))
                <span class="help-block">
                    {{ $errors->first('site_secondary_phone') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('site_address') ? ' has-error' : '' }}">
        <label for="site_address" class="col-sm-2 control-label">Shop Address *</label>
        <div class="col-sm-10">
            <textarea name="site_address" id="site_address" class="form-control"
                      rows="6">{{ getConfiguration('site_address') }}</textarea>
            @if ($errors->has('site_address'))
                <span class="help-block">
                    {{ $errors->first('site_address') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('order_email') ? ' has-error' : '' }}">
        <label for="order_email" class="col-sm-2 control-label">Order Email</label>
        <div class="col-sm-10">
            <input type="email" name="order_email" class="form-control" id="order_email"
                   value="{{ getConfiguration('order_email') }}">
            <span>Get email when someone order</span>
            @if ($errors->has('order_email'))
                <span class="help-block">
                    {{ $errors->first('order_email') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('site_logo') ? ' has-error' : '' }}">
        <label for="site_logo" class="col-sm-2 control-label">Site Logo</label>
        <div class="col-sm-10">
            <input type="file" name="site_logo" id="site_logo" class="form-control">
            @if ($errors->has('site_logo'))
                <span class="help-block">
                    {{ $errors->first('site_logo') }}
                </span>
            @endif

            @if(getConfiguration('site_logo'))
                <div class="mt-15 half-width" style="width: 300px;">
                    <img src="{{ url('storage') . '/' . getConfiguration('site_logo') }}"
                         class="thumbnail img-responsive">
                </div>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('site_favicon') ? ' has-error' : '' }}">
        <label for="site_favicon" class="col-sm-2 control-label">Site Favicon</label>
        <div class="col-sm-10">
            <input type="file" name="site_favicon" id="site_favicon" class="form-control">
            @if ($errors->has('site_favicon'))
                <span class="help-block">
                    {{ $errors->first('site_favicon') }}
                </span>
            @endif

            @if(getConfiguration('site_favicon'))
                <div class="mt-15 half-width" style="width: 300px;">
                    <img src="{{ url('storage') . '/' . getConfiguration('site_favicon') }}"
                         class="thumbnail img-responsive">
                </div>
            @endif
        </div>
    </div>

</div>
<!-- /.tab-pane -->