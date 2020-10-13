@extends('admin.layouts.app')

@section('title',"Edit Area")

@section('content')
	<div class="row">
		<h3>Edit Area</h3>
		<div class="col-md-8">
			<form action="{{ route('admin.area.update',$area->id) }}" method="post" class="form-horizontal">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
				<fieldset class="content__box content__box--shadow">
					<div class="form-group @if($errors->has('area')) has-error @endif">
						<label class="col-md-3 control-label">Area *</label>
						<div class="col-md-9 inputGroupControl">
							<div class="input-group">
								<input type="text" name="area" class="form-control" placeholder="@advertise area" value="{{ $area->area }}">
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