{{-- <div class="content__box content__boxshadow"> --}}
	<div class="form-group @if ($errors->has('name')) has-error @endif">
		{{-- <div class="col-xs-6"> --}}
			{!! Form::label('name', 'Name *', ['class' => 'control-label']) !!}
		{{-- </div>
		<div class="col-xs-10"> --}}
			{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter your Deal...']) !!}

			@if ($errors->has('name'))
		        <span class="help-block">
		            {{ $errors->first('name') }}
		        </span>
		    @endif
		</div>
	{{-- </div> --}}
	{!! Form::submit($submitButtonText, ['class'=>'btn btn-danger btn-xs']) !!}
{{-- </div> --}}