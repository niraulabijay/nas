@extends('merchant.layouts.app')

@section('title',"Edit Type")

@section('content')
	<div class="row">
		<h3>Edit Type</h3>
		<div class="col-md-8 content__box content__box--shadow">
			<form action="{{ route('vendor.type.update',$type->id) }}" method="post" class="form-horizontal">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label">Type *</label>
						<div class="col-md-9 inputGroupControl">
							<div class="input-group">
								<input type="text" name="type" class="form-control" placeholder="@advertise type" value="{{ $type->type }}">
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Size *</label>
						<div class="col-md-9 inputGroupControl">
							<div class="input-group">
								<input type="text" name="size" class="form-control" placeholder="@advertise size" value="{{ $type->size }}">
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