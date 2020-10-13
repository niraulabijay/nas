<div class="tab-pane" id="footer">
    <div class="form-group{{ $errors->has('footer_logo') ? ' has-error' : '' }}">
        <label for="footer_logo" class="col-sm-2 control-label">Footer Logo</label>
        <div class="col-sm-10">
            <input type="file" name="footer_logo" id="footer_logo" class="form-control">
            @if ($errors->has('footer_logo'))
                <span class="help-block">
                    {{ $errors->first('footer_logo') }}
                </span>
            @endif

            @if(getConfiguration('footer_logo'))
                <div class="mt-15 half-width" style="width: 300px;">
                    <img src="{{ url('storage') . '/' . getConfiguration('footer_logo') }}"
                         class="thumbnail img-responsive">
                </div>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('payments_logo') ? ' has-error' : '' }}">
        <label for="payments_logo" class="col-sm-2 control-label">Payments Logo</label>
        <div class="col-sm-10">
            <input type="file" name="payments_logo" id="payments_logo" class="form-control">
            @if ($errors->has('payments_logo'))
                <span class="help-block">
                    {{ $errors->first('payments_logo') }}
                </span>
            @endif

            @if(getConfiguration('payments_logo'))
                <div class="mt-15 half-width" style="width: 300px;">
                    <img src="{{ url('storage') . '/' . getConfiguration('payments_logo') }}"
                         class="thumbnail img-responsive">
                </div>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('copyright') ? ' has-error' : '' }}">
        <label for="copyright" class="col-sm-2 control-label">Copyright</label>
        <div class="col-sm-10">
            <input type="text" name="copyright" class="form-control" id="copyright"
                   value="{{ getConfiguration('copyright') }}">
            @if ($errors->has('copyright'))
                <span class="help-block">
                    {{ $errors->first('copyright') }}
                </span>
            @endif
        </div>
    </div>
</div>
<!-- /.tab-pane -->