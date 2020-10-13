<div class="tab-pane" id="referal">

    <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
        <label for="active" class="col-sm-2 control-label">ON/OFF</label>
        <div class="col-sm-10">
            <select name="active" id="active" class="form-control">
                <option value="0" @if(getConfiguration('active') == 0) selected @endif>OFF</option>
                <option value="1" @if(getConfiguration('active') == 1) selected @endif>ON</option>
            </select>
            @if ($errors->has('active'))
                <span class="help-block">
                    {{ $errors->first('active') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('referal') ? ' has-error' : '' }}">
        <label for="referal" class="col-sm-2 control-label">Referal</label>
        <div class="col-sm-10">
            <input type="text" name="referal" class="form-control" id="referal"
                   value="{{ getConfiguration('referal') }}">
            @if ($errors->has('referal'))
                <span class="help-block">
                    {{ $errors->first('referal') }}
                </span>
            @endif
        </div>
    </div>
</div>
<!-- /.tab-pane -->