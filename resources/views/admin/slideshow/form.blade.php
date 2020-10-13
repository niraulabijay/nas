

<div class="col-md-8">
    <div class="content__box content__box--shadow">
        <div class="form-group @if($errors->has('name')) has-error @endif">
            {!! Form::label('name','Name *',['class'=>'control-label']) !!}
            {!! Form::text('name', null,['class'=>'form-control']) !!}
                @if($errors ->has('name'))
                    <span class="help-block">
                        {{$errors->first('name')}}
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
        <div class="form-group @if($errors->has('priority')) has-error @endif">
            {!! Form::label('priority','Priority *',['class'=>'control-label']) !!}
            {!! Form::number('priority', null, ['class'=>'form-control']) !!}
            @if($errors->has('priority'))
                <span class="help-block">{{$errors->first()}}</span>
            @endif
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="content__box content__box--shadow">
        <div class="form-group @if($errors->has('option')) has-error @endif">
            {!! Form::label('option','Option *',['class'=>'control-label']) !!}
            {!! Form::select('option', [1 => 'Product', 0 => 'Service'], null, ['class' => 'form-control']) !!}
            @if($errors->has('option'))
                <span class="help-block">{{$errors->first('option')}}</span>
            @endif
        </div>

        <div class="form-group @if($errors->has('status')) has-error @endif">
            {!! Form::label('status','Status *',['class'=>'control-label']) !!}
            {!! Form::select('status', [1 => 'Enable', 0 => 'Disable'], null, ['class' => 'form-control']) !!}
            @if($errors->has('status'))
                <span class="help-block">{{$errors->first('status')}}</span>
            @endif
        </div>

        <div class="form-group @if($errors->has('image')) has-error @endif">
            {!! Form::label('image','Image *',['class'=>'control-label']) !!}
            {!! Form::file('image',['class'=>'form-control']) !!}
            @if($errors->has('image'))
                <span class="help-block">{{$errors->first('image')}}</span>
            @endif

            @if(isset($slideshow) && null !== $slideshow->image)
                <div class="mt-15" style="width: 30%;margin-top: 5px;">
                    <img src="{{ url('/').$slideshow->image }}" class="thumbnail img-responsive mb-none">
                </div>
            @endif
        </div>
    
    </div>

    {!! Form::submit($submitButtonText, ['class'=>'btn btn-danger pull-right btn-slideshow-add']) !!}
</div>
