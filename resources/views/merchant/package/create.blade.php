@extends('merchant.layouts.app')

@section('title',"Add Package")

@section('content')
	<div class="row">
		<h3>Add Package</h3>
		<div class="col-md-6">
			<form action="{{ route('vendor.package.store') }}" method="post" class="form-horizontal">
				{{ csrf_field() }}
				<fieldset class="content__box content__box--shadow">
					<div class="form-group">
						<label class="col-md-4 control-label">Advertise Period *</label>
						<div class="col-md-8 inputGroupContainer">
							<div class="input-group">
								<span class="input-group-addon"><i></i></span>
								<input type="text" name="period" class="form-control" placeholder="@advertise period" />
							</div>
						</div>
					</div>

					<input type="submit" name="submit" value="Set" class="btn btn-warning btn-sm pull-right">
				</fieldset>
			</form>
		</div>
	</div>
@endsection