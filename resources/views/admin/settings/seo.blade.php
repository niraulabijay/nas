<div class="tab-pane" id="seo">
    <div class="form-group{{ $errors->has('keywords') ? ' has-error' : '' }}">
        <label for="keywords" class="col-sm-2 control-label">Keywords</label>
        <div class="col-sm-10">
            <input type="text" name="keywords" class="form-control" id="keywords"
                   value="{{ getConfiguration('keywords') }}">
            @if ($errors->has('keywords'))
                <span class="help-block">
                    {{ $errors->first('keywords') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
        <label for="description" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
            <textarea name="description" id="description" class="form-control"
                      rows="5">{{ getConfiguration('description') }}</textarea>
            @if ($errors->has('description'))
                <span class="help-block">
                    {{ $errors->first('description') }}
                </span>
            @endif
        </div>
    </div>
</div>
<!-- /.tab-pane -->