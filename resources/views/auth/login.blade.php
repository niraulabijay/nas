@extends('layouts.app')
@section('title', 'Login')

@section('content')
<section class="registerpage-container  vendor-registerpage-container">
    <div class="container">
        

        <div class="row">
            <div class="col-md-2"></div>
            <div class="input-cart col-md-8 ">
                <div class="regsternew" style="float:right;">
                        <p style="color: #777;">New at Nepal ALl Shop? <a href="{{ route('register') }}"> Register Now</a></p>
                    </div> 
                
             
                               
                <!--login form-->
                <div class=" login login-form py-5">
                    
                    <h2 id="customloginhead">Welcome to Nepal All Shop! Please Login</h2>
                    <form  action="{{route('login')}}" method="post" autocomplete="off">
                        {{csrf_field()}}
                        <div class="row">
                        <div class="col-md-8">
                        <div class="uk-margin {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label>Your Email Address:</label>
                            <div class="uk-inline uk-width-1-1">
                                
                                <span class="uk-form-icon" uk-icon="icon: mail"></span>
                                <input class="uk-input" type="email" name="email" value="{{ old('email') }}" required="required" placeholder="Email">
                            </div>
                            @if ($errors->has('email'))
                                <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                            @endif
                        </div>
                        <div class="uk-margin {{ $errors->has('password') ? ' has-error' : '' }}">
                             <label>Password:</label>
                            <div class="uk-inline uk-width-1-1">
                               
                                <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                <input class="uk-input" type="password" name="password" required="required" placeholder="Password">
                            </div>
                            @if ($errors->has('password'))
                                <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                            @endif
                        </div>
                        <div class="row justify-content-between align-items-center">
                            <div class="">
                                <label class="remember-checkbox">
                                    <input class="uk-checkbox " type="checkbox" name="remember">Remember me
                                </label>
                                <a href="{{ url('/password/reset') }}" class="forgotpassword  uk-margin-top" style="margin-left:200px;color:#1e87f0;">Forgot
                        Password?</a>
                            </div>
                            </div>
                            
                            
                        <!--    <a href="{{ url('/password/reset') }}" class="forgotpassword center uk-margin-top">forgot-->
                        <!--password?</a>-->
                     
                        </div>
                        <div class="col-md-4">
                        <button type="submit" name="login" class="uk-button btn-success " style="color: #fff;padding: 5px 10px;cursor: pointer;width:100%;box-shadow:0 2px 4px 0 rgba(0,0,0,.23);border-radius: 2px;background:#c64732;">Log in</button>
                      
                    </form>
                      
                    <div class="social-login center ">
                        <p class="log-or  center py-3">Or <small style="color:#777;">login with</small></p>
                        <div class="social-login-buttons  d-flex flex-wrap justify-content-center">
                            <a class="facebook" href="{{ url('/login/facebook') }}" style="color: #fff;padding: 10px 15px;background: #4267b2;margin: 10px;cursor: pointer;width:100%;box-shadow:0 2px 4px 0 rgba(0,0,0,.23);border-radius: 2px;">
                                <i class="fab fa-facebook-f">   </i> Login with Facebook
                            </a>

                            <a class="google-plus" href="{{ url('/login/google') }}" style="background: #d34836;color: #fff;padding: 10px 15px;margin: 10px;cursor: pointer;width:100%;box-shadow:0 2px 4px 0 rgba(0,0,0,.23);border-radius: 2px;">
                                <i class="fab fa-google-plus-g"></i> Login with Google+
                            </a>
                        </div>
                    </div>
                      </div>
                        </div>
                </div>



            </div>
            <div class="clearfix"></div>
            
        </div>
    </div>
</section>
@endsection
