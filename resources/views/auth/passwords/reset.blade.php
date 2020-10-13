@extends('layouts.app')
@section('title', 'Reset Password')

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
            <!--</div>-->
            <div class="col-md-2"></div>
            <div class="col-md-8 input-cart">
                <div class="login login-form py-5">
                    <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="uk-inline uk-width-1-1">
                                <span class="uk-form-icon" uk-icon="icon: mail"></span>
                                <input id="email" type="email" class="uk-input" name="email" value="{{ $email or old('email') }}" placeholder="Email" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="uk-inline uk-width-1-1">
                                <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                <input id="password" type="password" class="uk-input" name="password" placeholder="Password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <div class="uk-inline uk-width-1-1">
                                <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                <input id="password_confirmation" type="password" class="uk-input" name="password_confirmation" placeholder="Confirm Password" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-">
                                <button style="background:#c64732;" type="submit"  class="uk-button btn-success float-right ">Reset Password</button>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
