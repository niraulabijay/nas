@extends('merchant.layouts.app')
@section('title',"Configuration|Edit")
@section('content')
@foreach($vendor->documents as $doc)
{{ $doc->image }}
@endforeach
{{ $vendor->description }}
	<form action="{{ route('vendors.detail.create') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
		{{ csrf_field() }}
		<fieldset>
			<input type="hidden" name="user_id" value="{{ Auth::User()->id }}">
			<div class="form-group">
				<label class="col-md-3 control-label">Shop Name *</label>
				<div class="col-md-9 inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
						<input type="text" name="name" class="form-control" value="{{ $vendor->name }}" />
					</div>
				</div>
			</div>
			<!-- text input -->
			<div class="form-group">
				<label class="col-md-3 control-label">Shop Address *</label>
				<div class="col-md-9 inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
						<input type="text" name="address" class="form-control" value="{{ $vendor->address }}" />
					</div>
				</div>
			</div>
			<!-- text input -->
			<div class="form-group">
				<label class="col-md-3 control-label">Primary Email *</label>
				<div class="col-md-9 inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
						<input type="email" name="primary_email" class="form-control" value="{{ $vendor->primary_email }}"/>
					</div>
				</div>
			</div>
			<!-- text input -->
			<div class="form-group">
				<label class="col-md-3 control-label">Secondary Email *</label>
				<div class="col-md-9 inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
						<input type="email" name="secondary_email" class="form-control" value="{{ $vendor->secondary_email }}"/>
					</div>
				</div>
			</div>
			<!-- text input -->
			<div class="form-group">
				<label class="col-md-3 control-label">Primary Phone *</label>
				<div class="col-md-9 inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
						<input type="tel" name="primary_phone" class="form-control" value="{{ $vendor->primary_phone }}"/>
					</div>
				</div>
			</div>
			<!-- text input -->
			<div class="form-group">
				<label class="col-md-3 control-label">Secondary Phone *</label>
				<div class="col-md-9 inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
						<input type="tel" name="secondary_phone" class="form-control" value="{{ $vendor->secondary_phone }}"/>
					</div>
				</div>
			</div>
			<!-- text input -->
			<div class="form-group">
				<label class="col-md-3 control-label">Shop Description *</label>
				<div class="col-md-9 inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="fas fa-edit"></i></span>
						<textarea name="description" cols="30" rows="10" class="form-control">{{ $vendor->description }}</textarea>
					</div>
				</div>
			</div>
			<!-- text input -->
			<div class="form-group">
                <label class="col-md-3 control-label">Facebook *</label>
                <div class="col-md-9 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fab fa-facebook-f"></i></span>
                        <input type="text" name="facebook" class="form-control" value="{{ $vendor->socials->facebook_url }}" />
                    </div>
                </div>
            </div>

            <!-- text input -->

            <div class="form-group">
                <label class="col-md-3 control-label">Google Plus Link*</label>
                <div class="col-md-9 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fab fa-google-plus-g"></i></span>
                        <input type="text" name="google" class="form-control" value="{{ $vendor->socials->google_url }}"/>
                    </div>
                </div>
            </div>

            <!-- text input -->

            <div class="form-group">
                <label class="col-md-3 control-label">Twitter Link*</label>
                <div class="col-md-9 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fab fa-twitter"></i></span>
                        <input type="text" name="twitter" class="form-control" value="{{ $vendor->socials->twitter_url }}"/>
                    </div>
                </div>
            </div>

            <!-- text input -->

            <div class="form-group">
                <label class="col-md-3 control-label">Instagram Link *</label>
                <div class="col-md-9 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fab fa-instagram"></i></span>
                        <input type="text" name="instagram" class="form-control" value="{{ $vendor->socials->instagram_url }}"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Keywords *</label>
                <div class="col-md-9 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-key"></i></span>
                        <input type="text" name="title" class="form-control" value="
	                        @foreach($vendor->documents as $doc)
								{{ $doc->title }}
							@endforeach" 
							/>
                    </div>
                </div>
            </div>

            <!-- text input -->

            <div class="form-group">
                <label class="col-md-3 control-label">Chose File *</label>
                <div class="col-md-9 inputGroupContainer">
                    <div class="input-group">
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
            </div>

            <!-- text input -->

            <div class="form-group">
                <label class="col-md-3 control-label">Keywords *</label>
                <div class="col-md-9 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-key"></i></span>
                        <input type="text" name="seo_keywords" class="form-control" />
                    </div>
                </div>
            </div>

            <!-- text input -->

            <div class="form-group">
                <label class="col-md-3 control-label">Description *</label>
                <div class="col-md-9 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-keyboard"></i></span>
                        <textarea name="seo_description" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                </div>
            </div>

            <!-- text input -->

			 <div class="form-group">
                <label class="col-md-3 control-label">Category *</label>
                <div class="col-md-9 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-key"></i></span>
                        <input type="text" name="categories" class="form-control" />
                    </div>
                </div>
            </div>

            <!-- text input -->

             <input type="submit" name="Ok" class="btn btn-warning btn-sm" />
		</fieldset>
	</form>
@endsection