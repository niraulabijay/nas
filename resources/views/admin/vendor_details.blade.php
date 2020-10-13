@extends('admin.layouts.app')

@section('title','Setting')

{{-- for_additional_stylesheet | only for this page --}}
@push('stylesheets')

<style>
.tab-custom-style>li.active>a{
    border-top: 4px solid #f7ca18 !important;
}
</style>

@endpush

{{-- main_content --}}
@section('content')

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h2>Setting</h2>
            <ul class="nav nav-tabs tab-custom-style">
                <li class="active"><a data-toggle="tab" href="#home">General</a></li>
                <li><a data-toggle="tab" href="#menu1">Social Links</a></li>
                <li><a data-toggle="tab" href="#menu2">Documents</a></li>
                <li><a data-toggle="tab" href="#menu3">SEO</a></li>
                <!--<li><a data-toggle="tab" href="#menu4">category</a></li>-->
            </ul>

            <form action="{{ route('admin.vendor.save.details',$id) }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="tab-content content__box content__box--shadow">
                    <div id="home" class="tab-pane fade in active">
                            <legend>General <a data-toggle="tab" href="#menu1" class="btn btn-xs btn-warning pull-right" style="margin-top: 3px;">Next</a></legend>
                            <fieldset>
                            <div class="form-group @if($errors->has('name')) has-error @endif">
                                <label class="col-md-3 control-label">Shop Name *</label>
                                <div class="col-md-9 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                        <input type="text" name="name" class="form-control" placeholder="@Your Shop" value="{{ isset($vendor->name) ? $vendor->name : '' }}" />
                                    </div>
                                    @if($errors ->has('name'))
                                        <span class="help-block">
                                        {{$errors->first('name')}}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Shop Type</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="eg Fashion Store" name="type" value="{{ isset($vendor->type) ? $vendor->type : '' }}" >
                                </div>
                            </div>

                            <!-- text input -->

                            <div class="form-group @if($errors->has('address')) has-error @endif">
                                <label class="col-md-3 control-label">Shop Address *</label>
                                <div class="col-md-9 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                        <input type="text" name="address" class="form-control" placeholder="@Your Address" value="{{ isset($vendor) ? $vendor->address : old('address') }}" />
                                    </div>
                                    @if($errors ->has('address'))
                                        <span class="help-block">
                                        {{$errors->first('address')}}
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!-- text input -->

                            <div class="form-group @if($errors->has('primary_email')) has-error @endif">
                                <label class="col-md-3 control-label">Primary Email *</label>
                                <div class="col-md-9 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                        <input type="email" name="primary_email" class="form-control" placeholder="@Your Primary email" value="{{ isset($vendor) ? $vendor->primary_email : old('primary_email') }}" />
                                    </div>
                                    @if($errors ->has('primary_email'))
                                        <span class="help-block">
                                        {{$errors->first('primary_email')}}
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!-- text input -->

                            <div class="form-group @if($errors->has('secondary_email')) has-error @endif">
                                <label class="col-md-3 control-label">Secondary Email *</label>
                                <div class="col-md-9 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                        <input type="email" name="secondary_email" class="form-control" placeholder="@Your Secondary email" value="{{ isset($vendor) ? $vendor->secondary_email : old('secondary_email') }}" />
                                    </div>
                                    @if($errors ->has('secondary_email'))
                                        <span class="help-block">
                                        {{$errors->first('secondary_email')}}
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!-- text input -->

                            <div class="form-group @if($errors->has('primary_phone')) has-error @endif">
                                <label class="col-md-3 control-label">Primary Phone *</label>
                                <div class="col-md-9 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                        <input type="tel" name="primary_phone" class="form-control" placeholder="@Your Primary Phone Number" value="{{ isset($vendor) ? $vendor->primary_phone : old('primary_phone') }}" />
                                    </div>
                                    @if($errors ->has('primary_phone'))
                                        <span class="help-block">
                                        {{$errors->first('primary_phone')}}
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!-- text input -->

                            <div class="form-group @if($errors->has('secondary_phone')) has-error @endif">
                                <label class="col-md-3 control-label">Secondary Phone *</label>
                                <div class="col-md-9 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                        <input type="tel" name="secondary_phone" class="form-control" placeholder="@Your Secondary Phone Number" value="{{ isset($vendor) ? $vendor->secondary_phone : old('secondary_phone') }}" />
                                    </div>
                                    @if($errors ->has('secondary_phone'))
                                        <span class="help-block">
                                        {{$errors->first('secondary_phone')}}
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!-- text input -->

                            <div class="form-group @if($errors->has('description')) has-error @endif">
                                <label class="col-md-3 control-label">Shop Description *</label>
                                <div class="col-md-9 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-edit"></i></span>
                                        <textarea name="description" cols="30" rows="10" class="form-control" placeholder="@Type here...">{{ isset($vendor) ? $vendor->description : old('description') }}</textarea>
                                    </div>
                                    @if($errors ->has('description'))
                                        <span class="help-block">
                                        {{$errors->first('description')}}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">PAN Number</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputEmail3" name="pan_number" placeholder="PAN Number" value="{{ isset($vendor->pan_number) ? $vendor->pan_number : '' }}" >
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Tax Clearance No</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputEmail3" name="tax_clearance" placeholder="Tax Clerance No" value="{{ isset($vendor->tax_clearance) ? $vendor->tax_clearance : '' }}" >
                                </div>
                            </div>

                            <!-- text input -->

                        </fieldset>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <legend>Social Links <a data-toggle="tab" href="#menu2" class="btn btn-xs btn-warning pull-right" style="margin-top: 3px;">Next</a></legend>
                        <fieldset>

                        <div class="form-group @if($errors->has('facebook_url')) has-error @endif">
                            <label class="col-md-3 control-label">Facebook *</label>
                            <div class="col-md-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fab fa-facebook-f"></i></span>
                                    <input type="text" name="facebook_url" class="form-control" placeholder="@Your Facebook Page Link" value="{{ (isset($vendor) && $vendor->socials != null) ? $vendor->socials->facebook_url : '' }}" />
                                </div>
                                @if($errors ->has('facebook_url'))
                                    <span class="help-block">
                                    {{$errors->first('facebook_url')}}
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- text input -->

                        <div class="form-group @if($errors->has('google_url')) has-error @endif">
                            <label class="col-md-3 control-label">Google Plus Link*</label>
                            <div class="col-md-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fab fa-google-plus-g"></i></span>
                                    <input type="text" name="google_url" class="form-control" placeholder="@Your Google Plus Link" value="{{ (isset($vendor) && $vendor->socials != null) ? $vendor->socials->google_url : old('google_url') }}" />
                                </div>
                                @if($errors ->has('google_url'))
                                    <span class="help-block">
                                    {{$errors->first('google_url')}}
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- text input -->

                        <div class="form-group @if($errors->has('twitter_url')) has-error @endif">
                            <label class="col-md-3 control-label">Twitter Link*</label>
                            <div class="col-md-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fab fa-twitter"></i></span>
                                    <input type="text" name="twitter_url" class="form-control" placeholder="@Your Twitter Link" value="{{ (isset($vendor) && $vendor->socials != null) ? $vendor->socials->twitter_url : old('twitter_url') }}" />
                                </div>
                                @if($errors ->has('twitter_url'))
                                    <span class="help-block">
                                    {{$errors->first('twitter_url')}}
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- text input -->

                        <div class="form-group @if($errors->has('instagram_url')) has-error @endif">
                            <label class="col-md-3 control-label">Instagram Link *</label>
                            <div class="col-md-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fab fa-instagram"></i></span>
                                    <input type="text" name="instagram_url" class="form-control" placeholder="@Your Instagram Page Link" value="{{ (isset($vendor) && $vendor->socials != null) ? $vendor->socials->instagram_url : old('instagram_url') }}" />
                                </div>
                                @if($errors ->has('instagram_url'))
                                    <span class="help-block">
                                    {{$errors->first('instagram_url')}}
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- text input -->
                        </fieldset>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <legend>Document</legend>
                        <fieldset>

                        <div class="form-group @if($errors->has('title')) has-error @endif">
                            <label class="col-md-3 control-label">Pan Registration Image</label>
                            <div class="col-md-9 inputGroupContainer">
                                                                    <input type="file" name="pan_image" accept="image/*">

                                @if(isset($vendor) && \App\Model\VendorDocument::where('vendor_detail_id',$vendor->id)->where('title','pan_image')->first())
                                    <a href="{{url('').'/'.\App\Model\VendorDocument::where('vendor_detail_id',$vendor->id)->where('title','pan_image')->first()->image}}" class="product-img-zoom" title="Zoom">
                        
                               <img src={{url('').'/'.\App\Model\VendorDocument::where('vendor_detail_id',$vendor->id)->where('title','pan_image')->first()->image}} alt="pan_image" style="width:300px;"></a>
                               @endif
                            </div>
                        </div>

                        <!-- text input -->

                        <div class="form-group @if($errors->has('image')) has-error @endif">
                            <label class="col-md-3 control-label">Company Image </label>
                            <div class="col-md-9 inputGroupContainer">
                                                                    <input type="file" name="company_image" accept="image/*">

                                @if(isset($vendor) && \App\Model\VendorDocument::where('vendor_detail_id',$vendor->id)->where('title','company_image')->first())
                                   <a href="{{url('').'/'.\App\Model\VendorDocument::where('vendor_detail_id',$vendor->id)->where('title','company_image')->first()->image}}" class="product-img-zoom" title="Zoom">
                               <img src={{url('').'/'.\App\Model\VendorDocument::where('vendor_detail_id',$vendor->id)->where('title','company_image')->first()->image}} alt="pan_image" style="width:300px;"></a>
                               @endif
                            </div>
                        </div>
                        
                        <div class="form-group @if($errors->has('image')) has-error @endif">
                            <label class="col-md-3 control-label">Signature Image</label>
                            <div class="col-md-9 inputGroupContainer">
                                                                    <input type="file" name="signature_image" accept="image/*">

                                @if(isset($vendor) && \App\Model\VendorDocument::where('vendor_detail_id',$vendor->id)->where('title','signature_image')->first())
                                   <a href="{{url('').'/'.\App\Model\VendorDocument::where('vendor_detail_id',$vendor->id)->where('title','signature_image')->first()->image}}" class="product-img-zoom" title="Zoom">
                               <img src={{url('').'/'.\App\Model\VendorDocument::where('vendor_detail_id',$vendor->id)->where('title','signature_image')->first()->image}} alt="pan_image" style="width:300px;"></a>
                               @endif
                            </div>
                        </div>

                        <!-- text input -->
                    </fieldset>
                </div>
                <div id="menu3" class="tab-pane fade">
                    <legend>SEO</legend>
                    <fieldset>

                        <div class="form-group @if($errors->has('seo_keywords')) has-error @endif">
                            <label class="col-md-3 control-label">Keywords *</label>
                            <div class="col-md-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-key"></i></span>
                                    <input type="text" name="seo_keywords" class="form-control" placeholder="@page meta keywords" value="{{ (isset($vendor) && $vendor->seos != null) ? $vendor->seos->seo_keywords : old('seo_keywords') }}" />
                                </div>
                                @if($errors ->has('seo_keywords'))
                                    <span class="help-block">
                                    {{$errors->first('seo_keywords')}}
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- text input -->

                        <div class="form-group @if($errors->has('seo_description')) has-error @endif">
                            <label class="col-md-3 control-label">Description *</label>
                            <div class="col-md-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-keyboard"></i></span>
                                    <textarea name="seo_description" cols="30" rows="10" class="form-control" placeholder="@Meta description...">{{ (isset($vendor) && $vendor->seos != null) ? $vendor->seos->seo_description : old('seo_description') }}</textarea>
                                </div>
                                @if($errors ->has('seo_description'))
                                    <span class="help-block">
                                    {{$errors->first('seo_description')}}
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- text input -->

                    </fieldset>
                </div>
                 <div id="menu4" class="tab-pane fade">
                    <legend>Category</legend>
                    <fieldset>

                        <div class="form-group @if($errors->has('category')) has-error @endif">
                            <label class="col-md-3 control-label">Category *</label>
                            <div class="col-md-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-key"></i></span>
                                    <input type="text" name="category" class="form-control" placeholder="@Category" value="{{ (isset($vendor) && $vendor->category->first() != null) ? $vendor->category->first()->category : old('category') }}" />
                                </div>
                                @if($errors ->has('category'))
                                    <span class="help-block">
                                    {{$errors->first('category')}}
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- text input -->
                    </fieldset>

                </div>
                <input type="submit" name="Ok" class="btn btn-primary btn-sm pull-right" />
                    <div class="clearfix"></div>
            </div>
            </form>
        </div>
    </div>
@endsection

{{-- for_additional_scripts | only for this page --}}
@push('scripts')

@endpush