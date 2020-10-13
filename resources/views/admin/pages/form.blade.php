<div class="col-md-12">
    <div class="box box-default">
        <div class="box-body">

            <div class="form-group @if ($errors->has('name')) has-error @endif">
                {!! Form::label('name','Name *', ['class' => 'control-label']) !!}
                {!! Form::text('name',null, ['class'=> 'form-control']) !!}
                @if ($errors->has('name'))
                    <span class="help-block">
                        {{ $errors->first('name') }}
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

                @if(isset($page) && null !== $page->getImage())
                    <div class="mt-15">
                        <img src="{{ $page->getImage()->mediumUrl }}" class="thumbnail img-responsive mb-none">
                    </div>
                @endif

            </div>

            <div class="form-group @if ($errors->has('content')) has-error @endif">
                {!! Form::label('content','Content', ['class' => 'control-label']) !!}
                {{ Form::textarea('content', null, ['class' => 'form-control']) }}
                @if ($errors->has('content'))
                    <span class="help-block">
                        {{ $errors->first('content') }}
                    </span>
                @endif

            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {!! Form::submit($submitButtonText, ['class'=>'btn btn-danger pull-right']) !!}
        </div>
    </div>
    <!-- /.box -->

</div>