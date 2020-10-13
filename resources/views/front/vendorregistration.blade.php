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
</style>
<div class="seller-header" style="background-color:#003470  !important;">
    <nav class="navbar navbar-light">
        <a class="navbar-brand" href="https://nepalallshop.com.np/sell-with-us">
            <img src="../img/seller/seller2.png" width="30" height="30" class="d-inline-block align-top" alt="NSC" style="max-width: 20%;">

        </a>
    </nav>
</div>
<h3 id="customloginhead">Welcome! Just one more step to become a seller </h3>

<section class="registerpage-container  vendor-registerpage-container">
    <div class="container mb mt-3">

        <div class="row ">
            <div class="col-md-2"></div>
            <div class="input-cart col-md-8 ">
      <!--signup form for vendor-->
                <form id="vendorRegistrationForm" name="signup" method="post" autocomplete="off" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class=" signup vendorsignup">
                        <div class="sign-up-form">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="title_register" style="color:#000;">
                                        <h3>Register Your Store</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="vendorrowwrap">
                                <div class="col-sm-12" style="padding-bottom:10px;">
                                    <p style="padding-bottom:10px;">Buisness Type:</p>
                                    
                                  <input type="radio" name="buisness" value="Personal" id="Personal">
                                  <label for="Personal">Personal</label>
                                  
                                  <input type="radio" name="buisness" value="Wholesale" id="Wholesale">
                                  <label for="Wholesale">Wholesale</label>
                                  
                                   <input type="radio" name="buisness" value="Manufacture" id="Manufacture">
                                  <label for="Manufacture">Manufacture</label>
                                  
                                  <input type="radio" name="buisness" value="Retailer" id="Retailer">
                                  <label for="Retailer">Retailer</label>
                                  
                                  <input type="radio" name="buisness" value="Importer" id="Importer">
                                  <label for="Importer">Importer</label>
                                  
                                <div class="col-sm-12">
                                    <div class="uk-margin {{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label>Shop Name:</label>
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                            <input class="uk-input" name="name" type="text" required="required"
                                                   placeholder="Store name" value="{{ old('name') }}">
                                        </div>
                                        @if ($errors->has('name'))
                                        <span class="help-block"><strong style="color:red;">{{ $errors->first('name') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                     
                                    <div class="uk-margin {{ $errors->has('shop_category') ? ' has-error' : '' }}">
                                        <label>Shop Category:</label>
                                        <div class="uk-inline uk-width-1-1">
                                            {{--<span class="uk-form-icon" uk-icon="icon: lock"></span>--}}
                                            {{--<input class="uk-input" name="type" type="text" required="required"--}}
                                                       {{--placeholder="Store Type (eg. Fashion Store)">--}}
                                            @foreach($categories as $category)
                                            <label><input type="checkbox" name="shop_category[]" value="{{ $category->slug }}"> {{ $category->name }}</label>
                                            @endforeach
                                        </div>
                                        <div id="shop_category_error" style="display:none;">
                                             <span class="help-block"><strong style="color:red;">Shop Category Feild is Required!!</strong></span>
                                        </div>
                                    </div>
                                    
                                       
                                        
                                </div>
                                
                                 @if ($errors->has('shop_category'))
                                        <span class="help-block"><strong style="color:red;">testtsan sngjhsatxznmbsmabz</strong></span>
                                        @endif
                                <div class="col-sm-12">
                                    <div class="uk-margin">
                                        <label>Shop Location:</label>
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: location"></span>
                                            <input class="uk-input"  value="{{ old('name') }}" name="address" type="text" required="required"
                                                   placeholder="Address">
                                        </div>
                                    </div>
                                    @if ($errors->has('address'))
                                    <span class="help-block"><strong style="color:red;">{{ $errors->first('address') }}</strong></span>
                                    @endif
                                </div>
                                @if(!Auth::User())
                                <div class="col-sm-12">
                                    <div class="uk-margin {{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label>Email Address:</label>
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: mail"></span>
                                            <input class="uk-input" name="email" type="email" required="required"
                                                   placeholder="Enter email"  value="{{ old('name') }}">
                                        </div>
                                        @if ($errors->has('email'))
                                        <span class="help-block"><strong style="color:red;">{{ $errors->first('email') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="uk-margin {{ $errors->has('phone') ? ' has-error' : '' }}">
                                        <label>Phone Number:</label>
                                        {{-- <label class="uk-form-label" for="form-stacked-select">Phone number</label> --}}
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: phone"></span>
                                            <input class="uk-input" name="phone" min="1" value="{{ old('name') }}" type="text" placeholder="Enter Phone Number" required="required" required="required">
                                        </div>
                                        @if ($errors->has('phone'))
                                        <span class="help-block"><strong style="color:red;">{{ $errors->first('phone') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="uk-margin {{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label>Password:</label>
                                        <div class="uk-inline uk-width-1-1 pass_show">
                                            <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                            <input class="uk-input" name="password" type="password" id="password" required="required"
                                                   placeholder="Enter password" required data-toggle="popover" title="Password Strength" data-content="Enter Password...">
                                                    
                                        </div>
                                        @if ($errors->has('password'))
                                        <span class="help-block register-error">
                                                    <strong style="color:red;">{{ $errors->first('password') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="uk-margin">
                                        <label>Confirm Password:</label>
                                        <div class="uk-inline uk-width-1-1 pass_show">
                                            <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                            <input class="uk-input" name="password_confirmation" type="password" required="required"
                                                   placeholder="Confirm password">
                                        </div>
                                    </div>

                                </div>
                                @endif


                                <div class="col-sm-12">

                                    <button type="submit" id="vendorRegistrationSubmit" class="uk-button btn-success"style="background:#c64732;color: #fff;padding: 5px 10px;cursor: pointer;width:100%;box-shadow:0 2px 4px 0 rgba(0,0,0,.23);border-radius: 2px;">Submit</button>
                                    <div class="clearfix"></div>
                                </div>

                            </div>
                        </div>
                    </div>


                </form>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</section>
<!--vendor regiter page footer open-->
<section class="vendor-footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4 text-center">
                <p>Nepal All Shop 2109. All Right Reserved</p>
            </div>
            <div class="col-sm-4 text-center">
                <p><a href="#">Nepal All Shop, Guide Center</a></p>
            </div>
            <div class="col-sm-4 text-center">
                <p><a href="#">Nepal All Shop, Support</a></p>
            </div>
        </div>
    </div>
</section>
<!--Vendor register page footer close-->

<style>
    .popover.primary {
    border-color:#337ab7;
}
.popover.primary>.arrow {
    border-top-color:#337ab7;
}
.popover.primary>.popover-title {
    color:#fff;
    background-color:#337ab7;
    border-color:#337ab7;
}
.popover.success {
    border-color:#d6e9c6;
}
.popover.success>.arrow {
    border-top-color:#d6e9c6;
}
.popover.success>.popover-title {
    color:#3c763d;
    background-color:#dff0d8;
    border-color:#d6e9c6;
}
.popover.info {
    border-color:#bce8f1;
}
.popover.info>.arrow {
    border-top-color:#bce8f1;
}
.popover.info>.popover-title {
    color:#31708f;
    background-color:#d9edf7;
    border-color:#bce8f1;
}
.popover.warning {
    border-color:#faebcc;
}
.popover.warning>.arrow {
    border-top-color:#faebcc;
}
.popover.warning>.popover-title {
    color:#8a6d3b;
    background-color:#fcf8e3;
    border-color:#faebcc;
}
.popover.danger {
    border-color:#ebccd1;
}
.popover.danger>.arrow {
    border-top-color:#ebccd1;
}
.popover.danger>.popover-title {
    color:#a94442;
    background-color:#f2dede;
    border-color:#ebccd1;
}
</style>
<style>
    .pass_show{position: relative} 

.pass_show .ptxt { 

position: absolute; 

top: 50%; 

right: 10px; 

z-index: 1; 

color: #f36c01; 

margin-top: -10px; 

cursor: pointer; 

transition: .3s ease all; 

} 

.pass_show .ptxt:hover{color: #333333;} 
</style>
<script>
    $(document).ready(function(){

//minimum 8 characters
var bad = /(?=.{8,}).*/;
//Alpha Numeric plus minimum 8
var good = /^(?=\S*?[a-z])(?=\S*?[0-9])\S{8,}$/;
//Must contain at least one upper case letter, one lower case letter and (one number OR one special char).
var better = /^(?=\S*?[A-Z])(?=\S*?[a-z])((?=\S*?[0-9])|(?=\S*?[^\w\*]))\S{8,}$/;
//Must contain at least one upper case letter, one lower case letter and (one number AND one special char).
var best = /^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])(?=\S*?[^\w\*])\S{8,}$/;

$('#password').on('keyup', function () {
    var password = $(this);
    var pass = password.val();
    var passLabel = $('[for="password"]');
    var stength = 'Weak';
    var pclass = 'danger';
    if (best.test(pass) == true) {
        stength = 'Very Strong';
        pclass = 'success';
    } else if (better.test(pass) == true) {
        stength = 'Strong';
        pclass = 'warning';
    } else if (good.test(pass) == true) {
        stength = 'Almost Strong';
        pclass = 'warning';
    } else if (bad.test(pass) == true) {
        stength = 'Weak';
    } else {
        stength = 'Very Weak';
    }

    var popover = password.attr('data-content', stength).data('bs.popover');
    popover.setContent();
    popover.$tip.addClass(popover.options.placement).removeClass('danger success info warning primary').addClass(pclass);

});

$('input[data-toggle="popover"]').popover({
    placement: 'top',
    trigger: 'focus'
});

})
</script>
<script>
    $(document).ready(function(){
$('.pass_show').append('<span class="ptxt">Show</span>');  
});
  

$(document).on('click','.pass_show .ptxt', function(){ 

$(this).text($(this).text() == "Show" ? "Hide" : "Show"); 

$(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; }); 

});  
</script>
@endsection


