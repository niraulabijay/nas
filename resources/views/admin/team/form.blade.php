<div class="col-xs-4">
    <h4 class="text-center">Info</h4>
	<div class="content__box content__box--shadow">
		<div class="form-group @if ($errors->has('name')) has-error @endif">
            {!! Form::label('name','Name *', ['class' => 'control-label']) !!}
            {!! Form::text('name',null, ['class'=> 'form-control', 'placeholder' => 'Enter Name']) !!}

            @if ($errors->has('name'))
                <span class="help-block">
                    {{ $errors->first('name') }}
                </span>
            @endif
        </div>

        <div class="form-group @if ($errors->has('position')) has-error @endif">
            {!! Form::label('position','Position *', ['class' => 'control-label']) !!}
            {!! Form::text('position',null, ['class'=> 'form-control', 'placeholder' => 'Enter Position']) !!}

            @if ($errors->has('position'))
                <span class="help-block">
                    {{ $errors->first('position') }}
                </span>
            @endif
        </div>

        <div class="form-group @if ($errors->has('content')) has-error @endif">
            {!! Form::label('content','Content *', ['class' => 'control-label']) !!}
            {{ Form::textarea('content', null, ['class' => 'form-control', 'rows' => 1, 'placeholder' => 'Enter Content']) }}

            @if ($errors->has('content'))
                <span class="help-block">
                    {{ $errors->first('content') }}
                </span>
            @endif
        </div>
	</div>
</div>

<div class="col-xs-4">
    <h4 class="text-center">Social</h4>
	<div class="content__box content__box--shadow">
		<div class="form-group @if ($errors->has('facebook_link')) has-error @endif">
            {!! Form::label('facebook_link','Facebook Link *', ['class' => 'control-label']) !!}
            {!! Form::text('facebook_link',null, ['class'=> 'form-control', 'placeholder' => 'Enter Link']) !!}

            @if ($errors->has('facebook_link'))
                <span class="help-block">
                    {{ $errors->first('facebook_link') }}
                </span>
            @endif
        </div>

        <div class="form-group @if ($errors->has('twitter_link')) has-error @endif">
            {!! Form::label('twitter_link','Twitter Link *', ['class' => 'control-label']) !!}
            {!! Form::text('twitter_link',null, ['class'=> 'form-control', 'placeholder' => 'Enter Link']) !!}

            @if ($errors->has('twitter_link'))
                <span class="help-block">
                    {{ $errors->first('twitter_link') }}
                </span>
            @endif
        </div>

        <div class="form-group @if ($errors->has('googleplus_link')) has-error @endif">
            {!! Form::label('googleplus_link','Google Plus Link *', ['class' => 'control-label']) !!}
            {!! Form::text('googleplus_link',null, ['class'=> 'form-control', 'placeholder' => 'Enter Link']) !!}

            @if ($errors->has('googleplus_link'))
                <span class="help-block">
                    {{ $errors->first('googleplus_link') }}
                </span>
            @endif
        </div>
	</div>
</div>

<div class="col-xs-4">
    <h4 class="text-center">Status</h4>
	<div class="content__box content__box--shadow">
		<div class="form-group @if ($errors->has('status')) has-error @endif">
            {!! Form::label('status','Status', ['class' => 'control-label']) !!}
            {{ Form::select('status', [1 => 'Enabled', 0 => 'Disabled'], null, ['class' => 'form-control']) }}

            @if ($errors->has('status'))
                <span class="help-block">
                    {{ $errors->first('status') }}
                </span>
            @endif
        </div>

        <div class="form-group @if ($errors->has('featured_image')) has-error @endif">
            {!! Form::label('featured_image','Featured Image', ['class' => 'control-label']) !!}
            {!! Form::file('featured_image', ['class'=> 'form-control']) !!}

            @if ($errors->has('featured_image'))
                <span class="help-block">
                    {{ $errors->first('featured_image') }}
                </span>
            @endif

            @if(isset($team) && null !== $team->getImage())
                <div class="mt-15" style="width: 50%;margin: 0 auto;margin-top: 5px;">
                    <img src="{{ $team->getImage()->mediumUrl }}" class="thumbnail img-responsive mb-none">
                </div>
            @endif
        </div>

        <div class="form-group @if ($errors->has('priority')) has-error @endif">
            {!! Form::label('priority','Priority', ['class' => 'control-label']) !!}
            {{ Form::text('priority', null, ['class' => 'form-control', 'placeholder' => 'Enter Priority']) }}

            @if ($errors->has('priority'))
                <span class="help-block">
                    {{ $errors->first('priority') }}
                </span>
            @endif
        </div>
	</div>
</div>

<div class="col-xs-12">
	{!! Form::submit($submitButtonText, ['class'=>'btn btn-danger pull-right btn-team-add']) !!}
</div>