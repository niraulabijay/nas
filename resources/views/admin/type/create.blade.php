@extends('admin.layouts.app')

@section('title',"Add Type")

@section('content')

	<div class="row">
		<h3>Add Type</h3>
		<div class="col-md-6 content__box content__box--shadow">
			<form action="{{ route('admin.type.store') }}" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<fieldset>
					<div class="form-group @if($errors->has('type')) has-error @endif">
						<label class="col-md-4 control-label">Advertise Type *</label>
						<div class="col-md-8 inputGroupControl">
							<div class="input-group">
								<span class="input-group-addon"><i></i></span>
								<input type="text" name="type" class="form-control" placeholder="@advertise type" />
							</div>
							@if($errors ->has('type'))
								<span class="help-block">
									{{$errors->first('type')}}
								</span>
							@endif
						</div>
					</div>

					<div class="form-group @if($errors->has('size')) has-error @endif">
						<label class="col-md-4 control-label">Advertise Size *</label>
						<div class="col-md-8 inputGroupControl">
							<div class="input-group">
								<span class="input-group-addon"><i></i></span>
								<input type="text" name="size" class="form-control" placeholder="@advertise size" />
							</div>
							@if($errors ->has('size'))
								<span class="help-block">
									{{$errors->first('size')}}
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

@push('scripts')
@endpush