@extends('merchant.layouts.app')

@section('title',"Add Advertise")

@section('content')
	<div class="row">
		<h3>Add Advertise</h3>
		<div class="col-md-6">
			<form action="{{ route('vendor.advertise.store') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
				{{ csrf_field() }}
				<fieldset class="content__box content__box--shadow">
					<div class="form-group @if($errors->has('title')) has-error @endif">
						<label class="col-md-4 control-label">Advertise Title *</label>
						<div class="col-md-8 inputGroupContainer">
							<div class="input-group">
								<span class="input-group-addon"><i></i></span>
								<input type="text" name="title" class="form-control" placeholder="@advertise name" />
							</div>
							@if($errors ->has('title'))
								<span class="help-block">
									{{$errors->first('title')}}
								</span>
							@endif
						</div>
					</div>

					<div class="form-group @if($errors->has('image_type')) has-error @endif">
						<label class="col-md-4 control-label">Advertise Type *</label>
						<div class="col-md-8 inputGroupContainer">
							<div class="input-group">
								<span class="input-group-addon"><i></i></span>
								<select name="image_type"  class="form-control">

									<option value="0">Choose a type</option>
								@foreach($types as $type)
									<option value="{{ $type->id }}">{{ $type->type }} ({{ $type->size }})</option>
								@endforeach

								</select>
							</div>
							@if($errors ->has('image_type'))
								<span class="help-block">
									{{$errors->first('image_type')}}
								</span>
							@endif
						</div>
					</div>
					
					<div class="form-group @if($errors->has('image')) has-error @endif">
						<label class="col-md-4 control-label">Image</label>
						<div class="col-md-8">
							<input type="file" name="image" class="custom-file-input">
							@if($errors ->has('image'))
								<span class="help-block">
									{{$errors->first('image')}}
								</span>
							@endif
						</div>
					</div>
					
					<div class="form-group @if($errors->has('advertise_area')) has-error @endif">
						<label class="col-md-4 control-label">Pick A Place</label>
						<div class="col-md-8 inputGroupContainer">
							<div class="input-group">
								<span class="input-group-addon"><i></i></span>
								<select name="advertise_area" class="form-control">

									<option value="0">Select a area</option>
								@foreach($areas as $area)
									<option value="{{ $area->id }}">{{ $area->area }}</option>
								@endforeach

								</select>
							</div>
							@if($errors ->has('advertise_area'))
								<span class="help-block">
									{{$errors->first('advertise_area')}}
								</span>
							@endif
						</div>
					</div>

					<div class="form-group @if($errors->has('package')) has-error @endif">
						<label class="col-md-4 control-label">Choose Package</label>
						<div class="col-md-8 inputGroupContainer">
							<div class="input-group">
								<span class="input-group-addon"><i></i></span>
								<select name="package" class="form-control">

									<option value="0">Choose a package</option>
								@foreach($packages as $package)
									<option value="{{ $package->id }}">{{ $package->period }}</option>
								@endforeach

								</select>
							</div>
							@if($errors ->has('package'))
								<span class="help-block">
									{{$errors->first('package')}}
								</span>
							@endif
						</div>
					</div>

					<input type="submit" name="submit" value="Set" class="btn btn-warning btn-sm pull-right">
				</fieldset>
			</form>
		</div>
	</div>
@endsection