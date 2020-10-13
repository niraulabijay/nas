<div class="tab-pane" id="about">
    <div class="form-group{{ $errors->has('who_we_are') ? ' has-error' : '' }}">
        <label for="who_we_are" class="col-sm-2 control-label">Who we are</label>
        <div class="col-sm-10">
            <textarea name="who_we_are" id="who_we_are" class="form-control"
                      rows="5">{{ getConfiguration('who_we_are') }}</textarea>
            @if ($errors->has('who_we_are'))
                <span class="help-block">
                    {{ $errors->first('who_we_are') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('our_mission') ? ' has-error' : '' }}">
        <label for="our_mission" class="col-sm-2 control-label">Mission/Vision</label>
        <div class="col-sm-10">
            <textarea name="our_mission" class="form-control" id="our_mission"
                   rows="5">{{ getConfiguration('our_mission') }}</textarea>
            @if ($errors->has('our_mission'))
                <span class="help-block">
                    {{ $errors->first('our_mission') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('payments') ? ' has-error' : '' }}">
        <label for="payments" class="col-sm-2 control-label">Payments</label>
        <div class="col-sm-10">
            <textarea name="payments" class="form-control" id="payments"
                   rows="5">{{ getConfiguration('payments') }}</textarea>
            @if ($errors->has('payments'))
                <span class="help-block">
                    {{ $errors->first('payments') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('shipping') ? ' has-error' : '' }}">
        <label for="shipping" class="col-sm-2 control-label">Shipping</label>
        <div class="col-sm-10">
            <textarea name="shipping" class="form-control" id="shipping"
                   rows="5">{{ getConfiguration('shipping') }}</textarea>
            @if ($errors->has('shipping'))
                <span class="help-block">
                    {{ $errors->first('shipping') }}
                </span>
            @endif
        </div>
    </div>
</div>
<!-- /.tab-pane -->