@extends('layouts.app')
@section('title')
    Register
@endsection

@section('content')
    <section class="registerpage-container  vendor-registerpage-container">
        <div class="container">
            <section class="row breadcrumbs max-inner">
                <div class="columns col-12">
                    <ul class="breadcrumb-list">

                    </ul>
                </div>
            </section>

            <div class="row">
                <!--<div class="col-md-6">-->
                <!--    <div class="register-benefits">-->
                <!--        <h3>Sign up today and you will be able to :</h3>-->
                <!--        <p style="padding: 10px 0;">{{ getConfiguration('site_title') }} Protection has you covered from click to delivery. Sign up or sign in and you will-->
                <!--            be able to:</p>-->
                <!--        <ul class="liststyle--none">-->
                <!--            <li><span class="uk-margin-small-right" uk-icon="check"></span>Speed your way through-->
                <!--                checkout-->
                <!--            </li>-->
                <!--            <li><span class="uk-margin-small-right" uk-icon="check"></span>Track your orders easily</li>-->
                <!--            <li><span class="uk-margin-small-right" uk-icon="check"></span>Keep a record of all your-->
                <!--                purchases-->
                <!--            </li>-->
                <!--        </ul>-->
                <!--    </div>-->
                <!--    <div class="text-center">-->
                <!--        <h4 class="center">Already Have Account ? <a href="{{ route('login') }}" style="color: #ed1b2f;">Sign In</a></h4>-->
                <!--</div>-->
                <!--</div>-->
                <div class="col-md-2"></div>
                <div class="input-cart col-md-9 ">
                     <div class="regsternew" style="float:right;">
                        <p style="color: #777;">Already a Member? <a href="{{ route('login') }}">Login Here</a></p>
                    </div>
                    <!--forgotpassowrd form-->
                    <!--<div class=" forgotpassowrd-form">-->
                    <!--    <form action="" method="post" autocomplete="off">-->
                    <!--        <div class="uk-margin">-->
                    <!--            <div class="uk-inline uk-width-1-1">-->
                    <!--                <span class="uk-form-icon" uk-icon="icon: mail"></span>-->
                    <!--                <input class="uk-input" type="email" required="required"-->
                    <!--                       placeholder="Enter your email address">-->
                    <!--            </div>-->
                    <!--        </div>-->
                            <!--<button type="submit" class="uk-button pull-right">submit</button>-->
                    <!--    </form>-->
                    <!--    <div class="clearfix"></div>-->
                        <!--<a href="javascript:void(0)" class="returning-customer"><span class="uk-margin-small-right"-->
                        <!--                                                              uk-icon="arrow-left"></span>back-->
                        <!--    to sign in</a>-->
                    <!--</div>-->

                    <!--signup form-->
                    <div class=" signup">
                        <div class="py-5">
                            <h2 id="customloginhead">Welcome to Nepal All Shop! Register Here </h2>
                            <form action="{{route('register')}}" name="signup" method="post" autocomplete="off">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6">
                               
                                 <div class="col-sm-12">
                                        <div class="uk-margin">
                                            <label>Phone Number:</label>
                                            <div class="uk-inline uk-width-1-1">
                                                <span class="uk-form-icon" uk-icon="icon: phone"></span>
                                                <input class="uk-input" name="phone" type="text" value="{{ old('phone') }}" required="required" max="10" min="8"
                                                       placeholder="Enter Phone Number">
                                            </div>
                                            @if ($errors->has('phone'))
                                                <span class="help-block register-error">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                               
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="uk-margin">
                                            <label>Password:</label>
                                            <div class="uk-inline uk-width-1-1">
                                                <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                                <input class="uk-input" name="password" type="password" required="required"
                                                       placeholder="Enter password">
                                            </div>
                                            @if ($errors->has('password'))
                                                <span class="help-block register-error">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="uk-margin">
                                            <label>Confirm Password:</label>
                                            <div class="uk-inline uk-width-1-1">
                                                <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                                <input class="uk-input" name="password_confirmation" type="password" required="required"
                                                       placeholder="Confirm password">
                                            </div>
                                        </div>

                                    </div>
                                   </div>
                                   <div class="row">
                                    <div class="col-sm-12">
                                        <div class="uk-margin">
                                            <label>Date of birth:</label>
                                            <div class="uk-inline uk-width-1-1">
                                                <!--<span class="uk-form-icon" uk-icon="icon: lock"></span>-->
                                               <input type="date" id="#" name="trip-start"
      style="    width: 100%;
    padding: 10px;
    border: none;
    background: #e8f0fe;">
                                            </div>
                                          
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="uk-margin">
                                            <label>Gender:</label>
                                            <div class="uk-inline uk-width-1-1">
                                                <!--<span class="uk-form-icon" uk-icon="icon: lock"></span>-->
                                               <select style="width: 100%;padding: 10px;background: #e8f0fe;    border: none;">
    <option value="0">Select Gender:</option>
    <option value="1">Male</option>
    <option value="2">Female</option>
    <option value="3">None of above</option>
      </select>
                                            </div>
                                        </div>

                                    </div>
                                   </div>
                                   </div>
                                   <div class="col-md-6">
                                        <div class="row">
                                    <div class="col-sm-12">
                                        <div class="uk-margin">
                                            <label>Full Name:</label>
                                            <div class="uk-inline uk-width-1-1">
                                                <span class="uk-form-icon" uk-icon="icon: user"></span>
                                                <input class="uk-input" name="user_name"  value="{{ old('user_name') }}" type="text" required="required"
                                                       placeholder="Enter Username">
                                            </div>
                                            @if ($errors->has('user_name'))
                                                <span class="help-block register-error">
                                                    <strong>{{ $errors->first('user_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                 <div class="row">
                                    <div class="col-sm-12">
                                        <div class="uk-margin">
                                            <label>Email Address:</label>
                                            <div class="uk-inline uk-width-1-1">
                                                <span class="uk-form-icon"  uk-icon="icon: mail"></span>
                                                <input class="uk-input" name="email" value="{{ old('email') }}" type="email" required="required"
                                                       placeholder="Enter Email">
                                            </div>
                                            @if ($errors->has('email'))
                                                <span class="help-block register-error">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                 <div class="row">
                                    <div class="col-sm-12">
                                        <input type="checkbox" name="vehicle1" value="Bike"> I agree to <a href="#" style="color:blue"> Privacy Policy</a> of NAS<br>
                                    </div>
                                </div>
                                 
                                    <div class="col-sm-12">
                                        <button type="submit" class="uk-button btn-success float-right" style="color: #fff;padding: 5px 10px;cursor: pointer;width:100%;box-shadow:0 2px 4px 0 rgba(0,0,0,.23);border-radius: 2px; background:#c64732;">Sign Up</button>
                                    </div>
                                

                            </form>
                   
 <div class="social-login center ">
                        <p class="log-or  center py-3">OR <small>login with</small> </p>
                        <div class="social-login-buttons  d-flex flex-wrap justify-content-center">
                            <a class="facebook" href="{{ url('/login/facebook') }}" style="color: #fff;padding: 10px 15px;background: #4267b2;margin: 10px;cursor: pointer; box-shadow:0 2px 4px 0 rgba(0,0,0,.23);border-radius: 2px;width:100%;text-align:center;">
                                <i class="fab fa-facebook-f"></i> Login with Facebook
                            </a>

                            <a class="google-plus" href="{{ url('/login/google') }}" style="background: #d34836;color: #fff;padding: 10px 15px;margin: 10px;cursor: pointer;box-shadow:0 2px 4px 0 rgba(0,0,0,.23);border-radius: 2px;width:100%;text-align:center;">
                                <i class="fab fa-google-plus-g"></i> Login with Google+
                            </a>
                        </div>
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
