@extends('admin.layouts.app')

@section('title',"Add Area")

@section('content')
	<div class="row">
		<h3>Add Area</h3>
		<div class="col-md-6">
			<form action="{{ route('admin.area.store') }}" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<fieldset class="content__box content__box--shadow">
					<div class="form-group @if($errors->has('area')) has-error @endif">
						<label class="col-md-4 control-label">Advertise Area *</label>
						<div class="col-md-8 inputGroupContainer">
							<div class="input-group">
								<span class="input-group-addon"><i></i></span>
								<input type="text" name="area" class="form-control" placeholder="@advertise area" />
							</div>
							@if($errors ->has('area'))
								<span class="help-block">
									{{$errors->first('area')}}
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