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
    @media screen and (max-width: 425px){
  .sellerslidercontent a{
        font-size: 12px !important;
    }
    .sellerlogin {
    top: 75% !important;
    font-size: 16px !important;
}
</style>
<div class="seller-header" style="background-color:#003470  !important;">
    <nav class="navbar navbar-light">
        <a class="navbar-brand" href="#">
          <img src="../img/seller/seller2.png" width="30" height="30" class="d-inline-block align-top" alt="NSC" style="max-width: 20%;">

        </a>
    </nav>
</div>
<style>
    .sellerlogin{
        top: 80%;
        font-size: 22px;
        display: flex;
        position: absolute;
        color: #fff;
        text-align: center;
        justify-content: center;
        align-items: center;
        align-content: center;
        left: 0;
        right: 0;
    }
    .sellerslidercontent a{
        top: 55%;
        display: flex;
        background: #c64732 !important;
        border: none;
        position: absolute;
        color: #fff;
        padding: 10px 20px 10px 20px;
        text-align: center;
        justify-content: center;
        align-items: center;
        align-content: center;
        left: 40%;
        right: 40%;
        font-size: 35px;
    }
      #vendorregisterprocess{
            padding: 20px;
            line-height: 28px;
            background-color: #fff !important;
        }
        #vendorregisterprocess ol{
            list-style-type: decimal;
            line-height: 32px;
            font-size: 18px;
        }
        .vendorhead h3{
            font-size: 30px;
            color:#003470;
            border-bottom: 2px solid #424f5f;
        }
        .vendorlistprocess ul{
            line-height: 35px;
            padding: 10px;
            font-size: 18px;
            color: black;
            font-family: roboto;
            font-weight: 500;
        }
        #featuresbenfits {
            padding: 20px;
        }
        #featuresbenfits h2{
            text-align: center;
            line-height: 50px;
            font-family: roboto;
            color: #003470;
            font-weight: 600;
        }
        .benihead h3{
            font-size: 22px;
            font-family: roboto;
            line-height: 50px;
            font-weight: 500;
            border-bottom: 1px solid #ccc;
            margin-bottom: 10px;
        }
        .benihead ul li{
            list-style-type: square;
            font-size: 15px;
            font-family: roboto;
            letter-spacing: .5px;
            line-height: 30px;
        }

</style>
<!--    benefits with nas-->
<section style="background: #fff; border-top:1px solid #ccc;">
    <div id="slide-banner">
        <div id="sliding_banner" class="carousel slide" data-ride="carousel">

            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <a href="#">
                         <img src="{{ asset('img/seller/seller3.jpg') }}" alt="vendornas" >
                         </a>

                </div>
                <div class="sellerslidercontent">
                    <a href="{{ route('sell.registration') }}" class="btn btn-success">Start Selling</a>

                </div>
                <div class="sellerlogin"><p> Already a seller?
                        <a href="{{ route('seller.login') }}" style="color: #ff9800; font-style: italic;" >Login Now</a></p>
                </div>

            </div>

            <div>

            </div>


        </div>
    </div>

</section>

<!--vendor register and feature and benefits-->

    <section id="vendorregisterprocess">
        <div class="container">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                <div class="vendorhead">
                    <h3>3 Easy steps to growing your business via Nepal All Shop</h3>
                </div>
                <div class="vendorlistprocess">
                        <ul>
                        <li>1. Register – Sign up and upload your product <a href="#">(Follow Vendor Manual)</a>
                         </li>
                        <li>2. Sell – (Handle orders)
                        </li>
                        <li>3. Get Paid- (Deposit into your account)
                        </li>
                        </ul>
                </div>
                </div>
            </div>
        </div>
    </section>

    <section id="featuresbenfits">
        <div class="container">
            <h2>FEATURES & BENEFITS</h2>
            <div class="row">
                <div class="col-sm-6">
                    <div class="benihead">
                        <h3>What Nepal All Shop offers you?</h3>
                        <ul>
                            <li>Thousands of Genuine customers</li>
                            <li>No hidden charges, all inclusive</li>
                            <li>Professionals to guide you
                            </li>
                            <li>Sell at your price, No bargain
                            </li>
                            <li>Fastest shipping all over Nepal</li>
                            <li>Easy & Timely payments</li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="benihead">
                        <h3>What Nepal All Shop expects from you?</h3>
<!--                        <p>Nepal All Shop is here to hold your hand and make sure that you are not left behind. But we do expect:</p>-->
                        <ul>
                            <li>Quality – Quality Products, Quality Relationship</li>
                            <li>Open Communication – So we don’t miss anything out</li>
                            <li>Mutual Respect – That’s what it takes to be friends.</li>
                            <li>Trust – Flows both ways</li>
                            <li>Consistency – To avoid uncertainty and distrust.
                            </li>
                            <li>Accountability – Maintaining time, costs, and stock
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


<!--    need more help-->
<section style="background: #fff; padding: 20px" id="sellerhelpbtnwrap">
    <div class="container">
        <h1 class="text-center" style="color:#003470d6; font-size: 32px; font-weight: 500;letter-spacing: 0.5px">
            Need more help?
        </h1>
        <p class="text-center" style="font-size: 26px;"> <i class="fas fa-mobile-alt" style="color: #003470d6;"></i> 01-4441272</p>
        <p class="text-center" style="font-size: 16px;">Or</p>
        <p class="text-center" style="font-size: 26px;"> <i class="far fa-envelope-open" style="color: #003470d6;"></i> sellerhelp@nepalallshop.com.np</p>
    </div>
</section>

<!--nas help center-->
<section style="background: #2e5799; border-bottom: 1px solid #fff; padding: 20px;" id="guidesellerwrptxt">
    <h1 class="text-center" style="font-size: 50px;color: #fff;letter-spacing: .5px;
    text-decoration: underline;">Nepal All Shop Help Center</h1>
    <p class="text-center" style="color: #ffff;font-size: 18px;letter-spacing: 0.8px;   line-height: 50px;">
        Are you confuse about selling product on Nepal All Shop and many other things that you want to know about
    </p>
    <a href="{{ route('vendorhelp') }}" class="text center btn btn-success" style="padding: 10px 30px 10px 30px;font-size: 30px;
    background: #c64732;border:none;"> Visit Now</a>
</section>
<!--vendor regiter page footer open-->
<section class="vendor-footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4 text-center">
                <p>Nepal All Shop 2109. All Right Reserved</p>
            </div>
            <div class="col-sm-4 text-center">
                <p><a href="{{ route('vendorhelp') }}">Nepal All Shop, Guide Center</a></p>
            </div>
            <div class="col-sm-4 text-center">
                <p><a href="#">Nepal All Shop, Support</a></p>
            </div>
        </div>
    </div>
</section>
<!--Vendor register page footer close-->
@endsection


