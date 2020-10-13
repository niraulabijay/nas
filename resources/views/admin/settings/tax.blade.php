<div class="tab-pane" id="tax">
    <div class="form-group">
        <label for="enable_tax" class="col-sm-2 control-label">Tax</label>
        <div class="col-sm-10">
            <div class="checkbox">
              <label><input type="checkbox" name="enable_tax" value="{{ getConfiguration('enable_tax') }}" @if(getConfiguration('enable_tax') == 1) checked='checked' @endif>Enable Tax</label>
            </div>
        </div>
    </div>

    <div class="form-group{{ $errors->has('tax_percentage') ? ' has-error' : '' }}">
        <label for="tax_percentage" class="col-sm-2 control-label">Tax Percentage</label>
        <div class="col-sm-10">
            <input type="number" name="tax_percentage" class="form-control" id="tax_percentage"
                   value="{{ getConfiguration('tax_percentage') }}" min="0">
            @if ($errors->has('tax_percentage'))
                <span class="help-block">
                    {{ $errors->first('tax_percentage') }}
                </span>
            @endif
        </div>
    </div>
</div>
<!-- /.tab-pane -->