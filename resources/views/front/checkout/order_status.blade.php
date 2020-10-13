@extends('layouts.app')

@section('content')
    <fieldset>
        <section class="content-box-row" style="margin-bottom:0;background:none;">
            <div class="content-box" style="padding:0;">
                <div class="row">
                    <div class="col-sm-3">
                        <!--<i class="far fa-thumbs-up"></i>-->
                    </div>
                    <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 thank-you-border text-center" style="padding:20px;">
                        <div class="thankyou--border-box" style="border: 16px solid transparent;
	border-image: 16 repeating-linear-gradient(-45deg, red 0, red 1em, transparent 0, transparent 2em,
	              #58a 0, #58a 3em, transparent 0, transparent 4em); padding:35px; background:#fff;box-shadow:0 2px 4px 0 rgba(0, 0, 0, 0.27);">
            	            <span>
            	                
            	                <h1 style="font-size:40px;font-family:roboto;">Thank You</h1></br>
            	                          	            </span>
                            <div class="content" style="margin-bottom:20px;font-family:roboto;">
                                Thank You for your purchase! Your Order has been received.
                                Your order will be shipped to your address very soon.</br>
                                Your Order Track Number is: <strong style="font-weight:500;font-size:25px;">{{$code}}</strong>
                            </div>
                            <a href="{{route('user.account')}}" style="border-radius:2px;color:#fff;padding:12px;background:#c64732;font-family:roboto;font-size:15px;box-shadow:0 2px 4px 0 rgba(0, 0, 0, 0.27);"><i class="far fa-eye"></i> View Order Details</a>
                            <a href="{{route('home')}}" id="orderdetailspagebtn" style="border-radius:2px;color:#fff;padding:10px;background:#2e5799;font-family:roboto;font-size:15px;box-shadow:0 2px 4px 0 rgba(0, 0, 0, 0.27);"><i class="fas fa-undo-alt"></i> Back to Homepage</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </fieldset>
@endsection