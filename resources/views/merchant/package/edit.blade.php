@extends('merchant.layouts.app')

@section('title',"Edit Package")

@section('content')
	<div class="row">
		<h3>Edit Package</h3>
		<div class="col-md-8">
			<form action="{{ route('vendor.package.update',$package->id) }}" method="post" class="form-horizontal">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
				<fieldset class="content__box content__box--shadow">
					<div class="form-group">
						<label class="col-md-3 control-label">Period *</label>
						<div class="col-md-9 inputGroupControl">
							<div class="input-group">
								<input type="text" name="period" class="form-control" placeholder="@advertise period" value="{{ $package->period }}">
							</div>
						</div>
					</div>

					<input type="submit" name="submit" value="Set" class="btn btn-warning btn-sm pull-right">
				</fieldset>
			</form>
		</div>
	</div>
@endsection