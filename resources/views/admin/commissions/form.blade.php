<div class="content__box content__box--shadow">
    <div class="form-group @if ($errors->has('commission')) has-error @endif">
        {!! Form::label('commission', 'Commission', ['class' => 'control-label']) !!}
        {!! Form::text('commission', null, ['class' => 'form-control', 'placeholder' => 'Enter Commission']) !!}
        @if ($errors->has('commission'))
            <span class="help-block">
                {{ $errors->first('commission') }}
            </span>
        @endif
    </div>

    {!! Form::submit($submitBtn, ['class' => 'btn btn-primary btn-xs']) !!}
</div>