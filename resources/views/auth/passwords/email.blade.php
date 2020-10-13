@extends('layouts.app')
@section('title', 'Forgot Password')

@section('content')
    <section class="registerpage-container vendor-registerpage-container">
        <div class="container">
            <div class="row">
                <!--<div class="col-md-6">-->
                <!--    <div class="register-benefits">-->
                <!--        <h3>Sign up today and you will be able to :</h3>-->
                <!--        <p class="pt-3">{{ getConfiguration('site_title') }} Protection has you covered from click to delivery. Sign up or sign in and you will-->
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
                <!--      <div class="text-center">-->
                <!--    <h4 class="center"> <a href="{{ route('login') }}" class="uk-button btn-success">Back To Login</a></h4>-->
                <!--</div>-->
                <!--</div>-->
                <div class="col-md-2"></div>
                <div class="input-cart col-md-8 ">
                    <h2 id="customloginhead">Please provide your existing email address </h2>
                    <!--login form-->
                    <div class=" login login-form py-5">
                        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <!--<label for="email" class="col-md-4 control-label text-white">E-Mail Address</label>-->

                                 <div class="uk-inline uk-width-1-1">
                                <span class="uk-form-icon" uk-icon="icon: mail"></span>
                                    <input id="email" type="email" class="uk-input" name="email" value="{{ old('email') }}" placeholder="Email" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-">
                                    <button type="submit" style="background:#c64732"  class="uk-button btn-success float-right ">Send Password reset link</button>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="text-center">
                    <h4 class="center"> <a style="background:#003470;" href="{{ route('login') }}" class="uk-button btn-warning text-white">Back To Login</a></h4>
                </div>
                        </form>
                    </div>

                </div>
                <div class="clearfix"></div>
              
            </div>
        </div>
    </section>
@endsection

