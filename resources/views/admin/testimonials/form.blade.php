<div class="col-xs-8">
	<div class="content__box content__box--shadow">
		<div class="form-group @if ($errors->has('name')) has-error @endif">
		    {!! Form::label('name','Name *', ['class' => 'control-label']) !!}
		    {!! Form::text('name',null, ['class'=> 'form-control', 'placeholder' => 'Enter Name'], 'required') !!}

		    @if ($errors->has('name'))
		        <span class="help-block">
		            {{ $errors->first('name') }}
		        </span>
		    @endif
		</div>

		<div class="form-group @if ($errors->has('profession')) has-error @endif">
		    {!! Form::label('profession','Profession *', ['class' => 'control-label']) !!}
		    {!! Form::text('profession',null, ['class'=> 'form-control', 'placeholder' => 'Enter Profession']) !!}

		    @if ($errors->has('profession'))
		        <span class="help-block">
		            {{ $errors->first('profession') }}
		        </span>
		    @endif
		</div>

		<div class="form-group @if ($errors->has('description')) has-error @endif">
            {!! Form::label('description','Description *', ['class' => 'control-label']) !!}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 5, 'placeholder' => 'Enter Description']) }}

            @if ($errors->has('description'))
                <span class="help-block">
                    {{ $errors->first('description') }}
                </span>
            @endif
        </div>
    </div>
</div>

<div class="col-xs-4">
	<div class="content__box content__box--shadow">
		<div class="form-group @if ($errors->has('status')) has-error @endif">
		    {!! Form::label('status','Status *', ['class' => 'control-label']) !!}
		    {!! Form::select('status', [1 => 'Enabled', 0 => 'Disabled'], null, ['class'=> 'form-control']) !!}

		    @if ($errors->has('status'))
		        <span class="help-block">
		            {{ $errors->first('status') }}
		        </span>
		    @endif
		</div>

		<div class="form-group @if ($errors->has('featured_image')) has-error @endif">
	        {!! Form::label('featured_image','Featured Image', ['class' => 'control-label']) !!}
	        {!! Form::file('featured_image', ['class'=> 'form-control', 'id' => 'image']) !!}

	        @if ($errors->has('featured_image'))
	            <span class="help-block">
	                {{ $errors->first('featured_image') }}
	            </span>
	        @endif

	        @if(isset($testimonials) && null !== $testimonials->getImage())
	            <div class="mt-15" style="width: 50%;margin: 0 auto;margin-top: 5px;">
	                <img src="{{ $testimonials->getImage()->mediumUrl }}" class="thumbnail img-responsive mb-none">
	            </div>
	        @endif
	    </div>
	</div>
	{!! Form::submit($submitButtonText, ['class'=>'btn btn-danger btn-xs pull-right btn-testimonial-add btn-testimonial-update']) !!}
</div>