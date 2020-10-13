<div class="tab-pane" id="social">
    <div class="form-group{{ $errors->has('facebook_link') ? ' has-error' : '' }}">
        <label for="facebook_link" class="col-sm-2 control-label">Facebook Link</label>
        <div class="col-sm-10">
            <input type="text" name="facebook_link" class="form-control" id="facebook_link"
                   value="{{ getConfiguration('facebook_link') }}">
            @if ($errors->has('facebook_link'))
                <span class="help-block">
                    {{ $errors->first('facebook_link') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('twitter_link') ? ' has-error' : '' }}">
        <label for="twitter_link" class="col-sm-2 control-label">Twitter Link</label>
        <div class="col-sm-10">
            <input type="text" name="twitter_link" class="form-control" id="twitter_link"
                   value="{{ getConfiguration('twitter_link') }}">
            @if ($errors->has('twitter_link'))
                <span class="help-block">
                    {{ $errors->first('twitter_link') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('instagram_link') ? ' has-error' : '' }}">
        <label for="instagram_link" class="col-sm-2 control-label">Instagram Link</label>
        <div class="col-sm-10">
            <input type="text" name="instagram_link" class="form-control" id="instagram_link"
                   value="{{ getConfiguration('instagram_link') }}">
            @if ($errors->has('instagram_link'))
                <span class="help-block">
                    {{ $errors->first('instagram_link') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('youtube_link') ? ' has-error' : '' }}">
        <label for="youtube_link" class="col-sm-2 control-label">Youtube Link</label>
        <div class="col-sm-10">
            <input type="text" name="youtube_link" class="form-control" id="youtube_link"
                   value="{{ getConfiguration('youtube_link') }}">
            @if ($errors->has('youtube_link'))
                <span class="help-block">
                    {{ $errors->first('youtube_link') }}
                </span>
            @endif
        </div>
    </div>
</div>
<!-- /.tab-pane -->
