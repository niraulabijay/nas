@extends('merchant.layouts.app')

@section('title',"Add Area")

@section('content')
	<div class="row">
		<h3>Add Area</h3>
		<div class="col-md-6">
			<form action="{{ route('vendor.area.store') }}" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<fieldset class="content__box content__box--shadow">
					<div class="form-group">
						<label class="col-md-4 control-label">Advertise Area *</label>
						<div class="col-md-8 inputGroupContainer">
							<div class="input-group">
								<span class="input-group-addon"><i></i></span>
								<input type="text" name="area" class="form-control" placeholder="@advertise area" />
							</div>
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