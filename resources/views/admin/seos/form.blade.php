

<div class="col-md-8">
    <div class="content__box content__box--shadow">
        <div class="form-group @if($errors->has('keyword')) has-error @endif">
            {!! Form::label('keyword','Keyword *',['class'=>'control-label']) !!}
            {!! Form::text('keyword', null,['class'=>'form-control']) !!}
                @if($errors ->has('keyword'))
                    <span class="help-block">
                        {{$errors->first('keyword')}}
                    </span>
            @endif
        </div>
        <div class="form-group @if($errors->has('link')) has-error @endif">
            {!! Form::label('link','Link *',['class'=>'control-label']) !!}
            {!! Form ::text('link', null,['class'=>'form-control'])!!}
            @if($errors->has('link'))
                <span class="help-block">
                    {{$errors->first('link')}}
                </span>
            @endif

        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="content__box content__box--shadow">

        <div class="form-group @if($errors->has('status')) has-error @endif">
            {!! Form::label('status','Status *',['class'=>'control-label']) !!}
            {!! Form::select('status', [1 => 'Enable', 0 => 'Disable'], null, ['class' => 'form-control']) !!}
            @if($errors->has('status'))
                <span class="help-block">{{$errors->first('status')}}</span>
            @endif
        </div>
    
    </div>

    {!! Form::submit($submitButtonText, ['class'=>'btn btn-danger pull-right btn-slideshow-add']) !!}
</div>
