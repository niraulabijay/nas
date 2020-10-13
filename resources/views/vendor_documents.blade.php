@extends('layouts.app')
@section('title', 'Sell With Us')

@section('content')

<style>
    h3#customloginhead {
        text-align: center;
        padding: 24px 0px;
        margin-bottom: -34px;
        text-transform: capitalize;
        color: #636060;
    }
    .vendor-footer p{
        color: #636060;
    }
    .vendor-footer a{
        color: #636060;
    }
    .vendor-footer a:hover{
        text-decoration: underline;
    }
    footer{
        display:none;
    }
    header{
        display:none;
    }
    #mini-footer{
        display:none;
    }
    #comppleteformvendor{
            background: #fff;
    padding: 20px;
    margin-top: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px 0 rgba(0,0,0,.23);
    border-radius: 3px;
    }
</style>
<div class="seller-header" style="background-color:#003470  !important;">
    <nav class="navbar navbar-light">
        <a class="navbar-brand" href="#">
          <img src="../img/seller/seller.png" width="30" height="30" class="d-inline-block align-top" alt="NSC" style="max-width: 15%;">
        </a>
    </nav>
</div>
            <div class="row ">
                <div class="col-md-2"></div>
                <div class="input-cart col-md-8" id="comppleteformvendor">
                    <h3 style="
                        padding: 10px;
                        font-weight: 500 !important;
                        letter-spacing: .5px;
                        border-bottom: 1px solid;
                        text-align: center;
                    ">Complete your store by fulfilling below required documents</h3>
                    <!--signup form for vendor-->
                    <form action="{{route('complete.post')}}" name="signup" method="post" autocomplete="off" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class=" signup vendorsignup">
                            <div class="sign-up-form">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="title_register">
                                            <h3>Complete Your Store</h3>
                                        </div>
                                    </div>
                                </div>

                                    <div class="row">
                                    <div class="col-sm-12">
                                    <div class="uk-margin {{ $errors->has('tax_clearance') ? ' has-error' : '' }}">
                                    <label class="uk-form-label" for="form-stacked-select">Company Registration No:</label>

                                    <div class="uk-inline uk-width-1-1">
                                    <input class="uk-input" name="tax_clearance"  min="1" type="text" required="required" placeholder="Company Registration number">
                                    </div>
                                        @if ($errors->has('tax_clearance'))
                                            <span class="help-block"><strong>{{ $errors->first('tax_clearance') }}</strong></span>
                                        @endif
                                    </div>
                                    </div>
                                    <div class="col-sm-12">
                                    <div class="uk-margin {{ $errors->has('pan_number') ? ' has-error' : '' }}">
                                    <label class="uk-form-label" for="form-stacked-select">Pan Number:</label>

                                    <div class="uk-inline uk-width-1-1">
                                    <input class="uk-input" name="pan_number"  min="1" type="text" required="required" placeholder="Pan Number">
                                    </div>
                                        @if ($errors->has('pan_number'))
                                            <span class="help-block"><strong>{{ $errors->first('pan_number') }}</strong></span>
                                        @endif
                                    </div>
                                    </div>
                                    <div class="col-sm-12">
                                    <div class="uk-margin {{ $errors->has('company_image') ? ' has-error' : '' }}">
                                    <label class="uk-form-label" for="form-stacked-select"> Company Registration Image (Optional)</label>
                                    <div class="uk-inline uk-width-1-1" uk-form-custom>
                                    <input type="file" name="company_image" accept="image/*" id="vendorcoimage" required onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                    <button class="uk-button uk-button-default button-select" type="button" tabindex="-1">Select
                                    </button>
                                      <img id="blah" alt="your image" width="200" height="200" style="width:200px; height:130px;" />
                                    
                                        <p id="error1" style="display:none; color:#FF0000;">
                                            Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF.
                                        </p>
                                        <p id="error2" style="display:none; color:#FF0000;">
                                            Maximum File Size Limit is 2MB.
                                        </p>
                                    </div>
                                    </div>
                                        @if ($errors->has('company_image'))
                                            <span class="help-block"><strong>{{ $errors->first('company_image') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="col-sm-12">
                                    <div class="uk-margin {{ $errors->has('pan_image') ? ' has-error' : '' }} ">
                                    <label class="uk-form-label" for="form-stacked-select"> Pan Registration Image *</label>
                                    <div class="uk-inline uk-width-1-1" uk-form-custom>
                                    <input type="file" name="pan_image" accept="image/*" id="vendorsignimage" required onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])">
                                    <button class="uk-button uk-button-default button-select" type="button" tabindex="-1">Select
                                    </button>
                                      <img id="blah2" alt="your image" width="200" height="200" style="width:200px; height:130px;" />
                                    
                                        <p id="error1" style="display:none; color:#FF0000;">
                                            Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF.
                                        </p>
                                        <p id="error2" style="display:none; color:#FF0000;">
                                            Maximum File Size Limit is 2MB.
                                        </p>
                                    </div>
                                        @if ($errors->has('pan_image'))
                                            <span class="help-block"><strong>{{ $errors->first('pan_image') }}</strong></span>
                                        @endif
                                    </div>
                                    </div>
                                    <div class="col-sm-12">
                                    <div class="uk-margin {{ $errors->has('signature_image') ? ' has-error' : '' }}">
                                    <label class="uk-form-label" for="form-stacked-select"> PP SIze Photo(Optional)</label>
                                    <div class="uk-inline uk-width-1-1" uk-form-custom>
                                    <input type="file"  name="signature_image" accept="image/*" id="vendorsignimage" required onchange="document.getElementById('blah3').src = window.URL.createObjectURL(this.files[0])">
                                    <button class="uk-button uk-button-default button-select" type="button" tabindex="-1">Select
                                    </button>
                                       <img id="blah3" alt="your image" width="200" height="200" style="width:200px; height:130px;" />
                                    
                                        <p id="error1" style="display:none; color:#FF0000;">
                                            Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF.
                                        </p>
                                        <p id="error2" style="display:none; color:#FF0000;">
                                            Maximum File Size Limit is 2MB.
                                        </p>
                                                                        </div>
                                        @if ($errors->has('signature_image'))
                                            <span class="help-block"><strong>{{ $errors->first('signature_image') }}</strong></span>
                                        @endif
                                    </div>
                                    </div>
                                    <div class="legal">
                                    <p class="grey-text policy" style="color:#4e4444;"> <input class="uk-checkbox" type="checkbox" checked> I agree on our <a href="#!">Privacy
                                    Policy</a> and
                                    <a href="#!">Terms of Use</a> including <a href="#!">Cookie Use</a>.</p>
                                    </div>


                                    </div>
                                    </div>
                                    <div class="col-sm-12" style="margin-bottom:10px;">

                                        <button type="submit" class="uk-button btn-success" style="width:100%;">Submit</button>
                                        <div class="clearfix"></div>
                                    </div>

                                </div>

                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
    <script>
    $('input[type="submit"]').prop("disabled", true);
    var a=0;
    //binds to onchange event of your input field
    $('#vendorsignimage').bind('change', function() {
        if ($('input:submit').attr('disabled',false)){
            $('input:submit').attr('disabled',true);
        }
        var ext = $('#vendorsignimage').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
            $('#error1').slideDown("slow");
            $('#error2').slideUp("slow");
            a=0;
        }else{
            var picsize = (this.files[0].size);
            if (picsize > 2048000){
                $('#error2').slideDown("slow");
                a=0;
            }else{
                a=1;
                $('#error2').slideUp("slow");
            }
            $('#error1').slideUp("slow");
            if (a==1){
                $('input:submit').attr('disabled',false);
            }
        }
    });
</script>
    <script>
    $('input[type="submit"]').prop("disabled", true);
    var a=0;
    //binds to onchange event of your input field
    $('#vendorcoimage').bind('change', function() {
        if ($('input:submit').attr('disabled',false)){
            $('input:submit').attr('disabled',true);
        }
        var ext = $('#vendorcoimage').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
            $('#error1').slideDown("slow");
            $('#error2').slideUp("slow");
            a=0;
        }else{
            var picsize = (this.files[0].size);
            if (picsize > 2048000){
                $('#error2').slideDown("slow");
                a=0;
            }else{
                a=1;
                $('#error2').slideUp("slow");
            }
            $('#error1').slideUp("slow");
            if (a==1){
                $('input:submit').attr('disabled',false);
            }
        }
    });
</script>
@endsection