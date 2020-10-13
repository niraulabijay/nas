<div class="tab-pane" id="policy">
    <div class="form-group{{ $errors->has('return_policy') ? ' has-error' : '' }}">
        <label for="return_policy" class="col-sm-2 control-label">Return Policy</label>
        <div class="col-sm-10">
            <textarea name="return_policy" id="return_policy" class="form-control"
                      rows="5">{{ getConfiguration('return_policy') }}</textarea>
            @if ($errors->has('return_policy'))
                <span class="help-block">
                    {{ $errors->first('return_policy') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('privacy_policy') ? ' has-error' : '' }}">
        <label for="privacy_policy" class="col-sm-2 control-label">Privacy Policy</label>
        <div class="col-sm-10">
            <textarea name="privacy_policy" class="form-control" id="privacy_policy"
                   rows="5">{{ getConfiguration('privacy_policy') }}</textarea>
            @if ($errors->has('privacy_policy'))
                <span class="help-block">
                    {{ $errors->first('privacy_policy') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('terms_conditions') ? ' has-error' : '' }}">
        <label for="terms_conditions" class="col-sm-2 control-label">Terms & Conditions</label>
        <div class="col-sm-10">
            <textarea name="terms_conditions" class="form-control" id="terms_conditions"
                   rows="5">{{ getConfiguration('terms_conditions') }}</textarea>
            @if ($errors->has('terms_conditions'))
                <span class="help-block">
                    {{ $errors->first('terms_conditions') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('cancellation') ? ' has-error' : '' }}">
        <label for="cancellation" class="col-sm-2 control-label">Cancellation & Refunds</label>
        <div class="col-sm-10">
            <textarea name="cancellation" class="form-control" id="cancellation"
                   rows="5">{{ getConfiguration('cancellation') }}</textarea>
            @if ($errors->has('cancellation'))
                <span class="help-block">
                    {{ $errors->first('cancellation') }}
                </span>
            @endif
        </div>
    </div>
</div>
<!-- /.tab-pane -->