<div class="tab-pane" id="vcommission">

    <div class="form-group{{ $errors->has('productcommissinactive') ? ' has-error' : '' }}">
        <label for="productcommissinactive" class="col-sm-2 control-label">ON/OFF</label>
        <div class="col-sm-10">
            <select name="productcommissinactive" id="productcommissinactive" class="form-control">
                <option value="0" @if(getConfiguration('productcommissinactive') == 0) selected @endif>OFF</option>
                <option value="1" @if(getConfiguration('productcommissinactive') == 1) selected @endif>ON</option>
            </select>
            @if ($errors->has('productcommissinactive'))
                <span class="help-block">
                    {{ $errors->first('productcommissinactive') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('productcommissinprice') ? ' has-error' : '' }}">
        <label for="referal" class="col-sm-2 control-label">Product Commission </label>
        <div class="col-sm-10">
            <input type="number" name="productcommissinprice" class="form-control" id="productcommissinprice"
                   value="{{ getConfiguration('productcommissinprice') }}">
            @if ($errors->has('productcommissinprice'))
                <span class="help-block">
                    {{ $errors->first('productcommissinprice') }}
                </span>
            @endif
        </div>
    </div>
</div>
<!-- /.tab-pane -->