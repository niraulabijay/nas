@extends('merchant.layouts.app')

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
        <div class="col-lg-8 col-md-8 col-sm-10">
            <h2>Setting</h2>
            <ul class="nav nav-tabs tab-custom-style">
                <li class="active"><a data-toggle="tab" href="#home">General</a></li>
                <li><a data-toggle="tab" href="#menu2">Documents</a></li>
                <li><a data-toggle="tab" href="#menu3">Banking Details</a></li>
                <li><a data-toggle="tab" href="#menu4">category</a></li>
            </ul>

            <form action="{{ route('vendor.vendors_details.store') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" value="{{ $vendor->id }}" name="vendor_id">
                <div class="tab-content content__box content__box--shadow">
                    <div id="home" class="tab-pane fade in active">
                            <legend>General <a data-toggle="tab" href="#menu1" class="btn btn-xs btn-warning pull-right" style="margin-top: 3px; display:none;">Next</a></legend>
                            <fieldset>
                            <div class="form-group @if($errors->has('name')) has-error @endif">
                                <label class="col-md-3 control-label">Shop Name *</label>
                                <div class="col-md-9 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                        <input type="text" name="name" class="form-control" placeholder="@Your Shop" value="{{ isset($vendor->name) ? $vendor->name : '' }}" disabled/>
                                    </div>
                                    @if($errors ->has('name'))
                                        <span class="help-block">
                                        {{$errors->first('name')}}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            {{--<div class="form-group">--}}
                                {{--<label for="inputEmail3" class="col-sm-3 control-label">Shop Type</label>--}}
                                {{--<div class="col-sm-9">--}}
                                    {{--<input type="text" class="form-control" id="inputEmail3" placeholder="eg Fashion Store" name="type" value="{{ isset($vendor->type) ? $vendor->type : '' }}" disabled>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <!-- text input -->

                            <div class="form-group @if($errors->has('address')) has-error @endif">
                                <label class="col-md-3 control-label">Shop Address *</label>
                                <div class="col-md-9 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                        <input type="text" name="address" class="form-control" placeholder="@Your Address" value="{{ isset($vendor) ? $vendor->address : old('address') }}" disabled/>
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
                                        <input type="email" name="primary_email" class="form-control" placeholder="@Your Primary email" value="{{ isset($vendor) ? $vendor->primary_email : old('primary_email') }}" disabled/>
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
                                        <input readonly type="tel" name="primary_phone" class="form-control" placeholder="@Your Primary Phone Number" value="{{ isset($vendor) ? $vendor->primary_phone : old('primary_phone') }}" />
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

                            <div style="display:none;"class="form-group @if($errors->has('description')) has-error @endif">
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
                                    
                                    <input type="text" class="form-control" id="inputEmail3"  min="1" name="pan_number" placeholder="PAN Number" value="{{ isset($vendor->pan_number) ? $vendor->pan_number : '' }}" disabled>
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Company Registration</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputEmail3" min="1" name="tax_clearance" placeholder="Tax Clerance No" value="{{ isset($vendor->tax_clearance) ? $vendor->tax_clearance : '' }}" disabled>
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
                                <div class="col-md-9">
                               <input style="display:none;" type="file" class="form-control" name="panregisterimage" id="panregisterimage"  onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                @if(isset($vendor) && \App\Model\VendorDocument::where('vendor_detail_id',$vendor->id)->where('title','pan_image')->first())
                                    <a href="{{url('').'/'.\App\Model\VendorDocument::where('vendor_detail_id',$vendor->id)->where('title','pan_image')->first()->image}}" class="product-img-zoom" title="Zoom">
                        
                               <img src={{url('').'/'.\App\Model\VendorDocument::where('vendor_detail_id',$vendor->id)->where('title','pan_image')->first()->image}} alt="pan_image" style="width:300px;"></a>
                               @endif
                               </div>
                               <div class="col-md-3"> 
                               <img id="blah" alt="your image" width="200" height="200" style="display:none;">
                              <p id="error1" style="display:none; color:#FF0000;">
                                Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF.
                            </p>
                            <p id="error2" style="display:none; color:#FF0000;">
                                Maximum File Size Limit is 2MB.
                            </p>
                               </div>
                            </div>
                        </div>

                        <!-- text input -->

                        <div class="form-group @if($errors->has('image')) has-error @endif">
                            <label class="col-md-3 control-label">Company Registration Image </label>
                            <div class="col-md-9 inputGroupContainer">
                                 <div class="col-md-9">
                               <input type="file" class="form-control" name="coregsiterimage" id="coregsiterimage"  onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])" style="display:none;">                                @if(isset($vendor) && \App\Model\VendorDocument::where('vendor_detail_id',$vendor->id)->where('title','company_image')->first())
                                   <a href="{{url('').'/'.\App\Model\VendorDocument::where('vendor_detail_id',$vendor->id)->where('title','company_image')->first()->image}}" class="product-img-zoom" title="Zoom">
                               <img src={{url('').'/'.\App\Model\VendorDocument::where('vendor_detail_id',$vendor->id)->where('title','company_image')->first()->image}} alt="pan_image" style="width:300px;"></a>
                               @endif
                               </div>
                               <div class="col-md-3">
                                    <img id="blah2" alt="your image" width="200" height="200" style="display:none;">
                              <p id="error1" style="display:none; color:#FF0000;">
                                Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF.
                            </p>
                            <p id="error2" style="display:none; color:#FF0000;">
                                Maximum File Size Limit is 2MB.
                            </p>
                               </div>
                            </div>
                        </div>
                        
                        <div class="form-group @if($errors->has('image')) has-error @endif">
                            <label class="col-md-3 control-label">PP SIze Photo</label>
                            <div class="col-md-9 inputGroupContainer">
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
                    <legend>Banking Details</legend>
                    <fieldset>

                        <div class="form-group @if($errors->has('bank_name')) has-error @endif">
                            <label class="col-md-3 control-label">Bank Name *</label>
                            <div class="col-md-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-key"></i></span>
                                    <input type="text" name="bank_name" class="form-control" placeholder="@Bank Name" value="{{ (isset($vendor) && $vendor->bank_name != null) ? $vendor->bank_name : old('bank_name') }}" />
                                </div>
                                @if($errors ->has('bank_name'))
                                    <span class="help-block">
                                    {{$errors->first('bank_name')}}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group @if($errors->has('bank_branch')) has-error @endif">
                            <label class="col-md-3 control-label">Bank Branch *</label>
                            <div class="col-md-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-key"></i></span>
                                    <input type="text" name="bank_branch" class="form-control" placeholder="@Bank Branch" value="{{ (isset($vendor) && $vendor->bank_branch != null) ? $vendor->bank_branch : old('bank_branch') }}" />
                                </div>
                                @if($errors ->has('bank_branch'))
                                    <span class="help-block">
                                    {{$errors->first('bank_branch')}}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group @if($errors->has('bank_account_name')) has-error @endif">
                            <label class="col-md-3 control-label">Bank Aaccount Name *</label>
                            <div class="col-md-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-key"></i></span>
                                    <input type="text" name="bank_account_name" class="form-control" placeholder="@Bank Account Name" value="{{ (isset($vendor) && $vendor->bank_account_name != null) ? $vendor->bank_account_name : old('bank_account_name') }}" />
                                </div>
                                @if($errors ->has('bank_account_name'))
                                    <span class="help-block">
                                    {{$errors->first('bank_account_name')}}
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- text input -->
                         <div class="form-group @if($errors->has('bank_account_number')) has-error @endif">
                            <label class="col-md-3 control-label">Bank Aaccount Number *</label>
                            <div class="col-md-9 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-key"></i></span>
                                    <input type="text" name="bank_account_number" class="form-control" placeholder="@Bank Account Number" value="{{ (isset($vendor) && $vendor->bank_account_number != null) ? $vendor->bank_account_number : old('bank_account_number') }}" />
                                </div>
                                @if($errors ->has('bank_account_number'))
                                    <span class="help-block">
                                    {{$errors->first('bank_account_number')}}
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
                                @foreach($categories as $category)

                                    <label>

                                        <input type="checkbox"
                                               @isset($vendorCategory)
                                               @foreach($vendorCategory as $vcategory)
                                               @if($vcategory == $category->slug) checked  @endif
                                               @endforeach
                                                @endisset
                                               name="category[]" value="{{ $category->slug }}"> {{ $category->name }}

                                    </label>
                                @endforeach
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
                <input type="submit" name="Ok" class="btn btn-primary btn-sm pull-right" enabled />
                    <div class="clearfix"></div>
            </div>
            </form>
        </div>
    </div>
     <script>
//     $('input[type="submit"]').prop("disabled", true);
//     var a=0;
//     //binds to onchange event of your input field
//     $('#panregisterimage').bind('change', function() {
//         if ($('input:submit').attr('disabled',false)){
//             $('input:submit').attr('disabled',true);
//         }
//         var ext = $('#picture').val().split('.').pop().toLowerCase();
//         if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
//             $('#error1').slideDown("slow");
//             $('#error2').slideUp("slow");
//             a=0;
//         }else{
//             var picsize = (this.files[0].size);
//             if (picsize > 2048000){
//                 $('#error2').slideDown("slow");
//                 a=0;
//             }else{
//                 a=1;
//                 $('#error2').slideUp("slow");
//             }
//             $('#error1').slideUp("slow");
//             if (a==1){
//                 $('input:submit').attr('disabled',false);
//             }
//         }
//     });
// </script>
     <script>
//     $('input[type="submit"]').prop("disabled", true);
//     var a=0;
//     //binds to onchange event of your input field
//     $('#coregsiterimage').bind('change', function() {
//         if ($('input:submit').attr('disabled',false)){
//             $('input:submit').attr('disabled',true);
//         }
//         var ext = $('#picture').val().split('.').pop().toLowerCase();
//         if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
//             $('#error1').slideDown("slow");
//             $('#error2').slideUp("slow");
//             a=0;
//         }else{
//             var picsize = (this.files[0].size);
//             if (picsize > 2048000){
//                 $('#error2').slideDown("slow");
//                 a=0;
//             }else{
//                 a=1;
//                 $('#error2').slideUp("slow");
//             }
//             $('#error1').slideUp("slow");
//             if (a==1){
//                 $('input:submit').attr('disabled',false);
//             }
//         }
//     });
// </script>
@endsection

{{-- for_additional_scripts | only for this page --}}
@push('scripts')

@endpush