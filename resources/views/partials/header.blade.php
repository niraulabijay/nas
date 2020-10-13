<header class="header">
    <div class="container">
<div class="min-header" style="background:#f7f7f7; padding:5px;">
    <div class="row">
        <div class="col-sm-6">
        <!--       <ul>-->
        <!--<li><i class="fas fa-mobile-alt"></i> <a href="tel:01-4441272">01-4441272</a></li>-->
        <!--<li><i class="far fa-envelope-open"></i> <a href="mailto:nepalallshop@gmail.com">nepalallshop@gmail.com</a></li>-->
        <!--</ul>-->
        </div>
        <div class="col-sm-6">
    <ul style="float:right;">
        <li>Customer Care</li>
        <li><a href="{{ route('sell.index') }}">Become a Seller</a></li>
        <li><a href="{{ route('track.order') }}"> Track my order</a></li>
        
        <!--<li><a href="{{ route('request.product.create') }}"><i class="fas fa-bolt"></i> Request Product</a></li>-->
        <!--<li><a href="https://play.google.com/store/apps/details?id=com.nextnepal.nas"><i class="fas fa-mobile-alt"></i> Download app</a></li>-->
    </ul>
    </div>
    </div>
    
</div>
</div>
    <div class="top-header " style="z-index: 1000;" uk-sticky="top: 100;  animation: uk-animation-slide-top">
        <div class="container">
            <!-- TOP HEAD SECTION    -->
            <div class="row">

                <div class="col-md-3 col-sm-12 ">
                    <div class="logo__and__user ">

                        <div class="logo">
                            <a href="#offcanvas-usage" uk-toggle class="bars float-left" style="display: none;">
                                <i class="fas fa-bars"></i>
                            </a>
                            <a class="logo-link pull-right" href="{{ route('home.index') }}">
                               
                                <img src="{{ url('storage') . '/' . getConfiguration('site_logo') }}" class="" alt="{{ getConfiguration('site_title') }}">
                            </a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="mobile_screen" style="display: none">
                            <div class="users">
                                <div class="user-login">
                                    <ul class="user_login_ul" style="display:inline-flex;">
                                         <li class="user_login_li active relative" style="">
                                            <a href="{{ route('sell.index') }}" class="user-login-link">
                                             
                                                
                                                <i class="fab fa-sellsy" style="display: none"></i>
                                            </a>
                                            </li>
                                        @if(Auth::check())
                                        @if(Auth::user()->hasRole('vendor'))
                                         <li class="user_login_li active relative">
                                            <a href="{{ url('/') }}/vendors" class="user-login-link">
                                                <span>{{ Auth::user()->user_name }}</span>
                                                <i class="far fa-user" style="display: none"></i>
                                            </a>
                                            </li>
                                        @esle
                                        <li class="user_login_li active relative">
                                            <a href="#" class="user-login-link">
                                                <span>{{ Auth::user()->user_name }}</span>
                                                <i class="far fa-user" style="display: none"></i>
                                            </a>
                                            <ul class="user_login_ul sub_ul">
                                                <li class="sub_li"><a href="{{ route('user.account') }}">Account</a></li>
                                                <li class="sub_li"><a href="{{ route('wishlist.mywishlist') }}">Wishlist</a></li>
                                                <li class="sub_li"><a href="{{ route('user.account') }}">Order</a></li>
                                                <li class="sub_li">
                                                    <form id="logout_form-md" action="{{ route('logout') }}" method="post">
                                                        {{ csrf_field() }}
                                                    </form>
                                                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout_form-md').submit();">Logout</a>
                                                </li>
                                            </ul>
                                        </li>
                                        @endif
                                        @else
                                        <li class="user_login_li relative">
                                            <a href="#" class="user-login-link " data-toggle="modal"
                                               data-target="#login__form">
                                                <span>Login & SignUp</span>
                                                <i class="far fa-user" style="display: none"></i>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>


                                </div>
                                <div class="more_dd"style="display: none">
                                    <a href="" style="display:none !important;">  <span>More</span></a>
                                    <ul class="more__dd_ul sub_ul">
                                        <li class="sub_li"><a href="{{ route('request.product.create') }}" class="checkout btn-danger text-white float-none">Request Product</a></li>
                                        <li class="sub_li"><a href="{{ route('sell.index') }}">Become a Seller</a></li>
                                        <li class="sub_li"><a href="{{ route('track.order') }}">Track my Order</a></li>
                                        <li class="sub_li"><a href="#">Download App</a></li>
                                    </ul>
                                </div>
                                <div class="user-cart" id="update-cart">
                                    <a href="{{ route('cart') }}" class="user-cart-link">
                                        <span>Cart</span>
                                        <img src="{{ asset('image/cart.png') }}" alt="Cart" height="40" width="40" style="height:30px !important; width:30px !important; max-width:none;">
                                    </a>
                                    <div class="user_cart_dd">
                                        @if(Cart::instance('default')->count())
                                        <ul class="user_cart_ul">
                                            @foreach(Cart::content() as $cartContent)
                                            <li>
                                                <figure style="float: left; margin-right: 10px; width: 50px;"><img
                                                            src="{{ asset(getProductImage($cartContent->id, 'small')) }}"
                                                            alt="{{ $cartContent->name }}"></figure>
                                                <p class="text-left">
                                                    <span> {{ $cartContent->name }}</span><br>
                                                    <span>{{ $cartContent->qty }}</span> <span>*</span> <span>{{ $cartContent->price }}</span>

                                                </p>
                                                <div class="clearfix"></div>
                                                <hr>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="cart_subtotal">
                                            <div class="float-left">Subtotal</div>
                                            <div class="float-right"><span class=""><span class="">Rs.</span>{{ Cart::instance('default')->total() }}</span>
                                            </div>
                                            <div class="clearfix"></div>
                                            <hr>
                                        </div>
                                        <a href="{{ route('cart') }}" class="btn  btn-default view-cart float-left">View Cart</a>
                                        <a href="{{ route('checkout') }}" class="btn btn-danger checkout float-right">Checkout</a>
                                        <div class="clearfix"></div>
                                        @else
                                            <div class="cart-empty">
                                                <p class="mb-none">No products in cart.</p>
                                            </div>
                                        @endif
                                    </div>

                                </div>


                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class="search-box">
                        <div class="uk-margin">
                            <form action="{{route('search')}}" method="get" class="uk-search uk-search-default ">
                                <span class="uk-search-icon-flip" uk-search-icon></span>
                                <input class="uk-search-input" type="search" name="query" id="searchTextLg" placeholder="Search for products, brands & Many More....">
                                <input type="submit" style="display: none;">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="users big-screen">
                        <div class="user-login">
                            <ul class="user_login_ul">
                                @if(Auth::check())
                               @if(Auth::user()->hasRole('vendor'))
                                <li class="user_login_li">
                                    <a href="{{ url('/') }}/vendors" class="user-login-link ">
                                        <span><i class="far fa-user"></i> {{ Auth::user()->user_name }}</span>
                                    </a></li>
                               @else
                                <li class="user_login_li active relative">
                                    <a href="#" class="user-login-link ">
                                        <span><i class="far fa-user"></i> {{ Auth::user()->user_name }}</span>
                                    </a>
                                    <ul class="user_login_ul sub_ul">
                                        <li class="sub_li"><a href="{{ route('user.account') }}">Account</a></li>
                                        <li class="sub_li"><a href="{{ route('wishlist.mywishlist') }}">Wishlist</a></li>
                                        <li class="sub_li"><a href="{{ route('user.account') }}">Order</a></li>
                                        <li class="sub_li">
                                            <form id="logout_form-md" action="{{ route('logout') }}" method="post">
                                                {{ csrf_field() }}
                                            </form>
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout_form-md').submit();">Logout</a>
                                        </li>
                                    </ul>
                                </li>
                                @endif
                                @else
                                <li class="user_login_li relative">
                                    <a href="#" class="user-login-link" data-toggle="modal"
                                               data-target="#login__form">
                                        <span>Login & SignUp</span>
                                    </a>
                                </li>
                                @endif
                            </ul>


                        </div>
                        <div class="more_dd">
                          <a href="">  <span>More</span> </a>
                            <ul class="more__dd_ul sub_ul">
                                <li class="sub_li"><a href="{{ route('request.product.create') }}" class="checkout  text-white float-none rahulbtntxt">Request Product</a></li>
                                <li class="sub_li"><a href="{{ route('sell.index') }}">  Become a Seller</a></li>
                                <li class="sub_li"><a href="{{ route('track.order') }}">Track my Order</a></li>
                                <li class="sub_li"><a href="#"> Download App</a></li>
                            </ul>
                        </div>
                        <div class="user-cart" id="update-minicart">
                            <a href="" class="user-cart-link">
                               <i class="fas fa-shopping-cart"></i> 
                                 <span>Cart</span>
                                <!--<img src="{{ asset('image/cart.png') }}" alt="Cart">-->
                            </a>
                            <div class="user_cart_dd">
                                @if(Cart::instance('default')->count())
                                <ul class="user_cart_ul">
                                    @foreach(Cart::content() as $cartContent)
                                    <li>
                                        <figure style="float: left; margin-right: 10px; width: 50px;"><img
                                                    src="{{ asset(getProductImage($cartContent->id, 'small')) }}"
                                                    alt="{{ $cartContent->name }}"></figure>
                                        <p class="text-left">
                                            <span> {{ $cartContent->name }}</span><br>
                                            <span>{{ $cartContent->qty }}</span> <span>*</span> <span>{{ $cartContent->price }}</span>

                                        </p>
                                        <div class="clearfix"></div>
                                        <hr>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="cart_subtotal">
                                    <div class="float-left">Subtotal</div>
                                    <div class="float-right"><span class=""><span class="">Rs.</span>{{ Cart::instance('default')->total() }}</span>
                                    </div>
                                    <div class="clearfix"></div>
                                    <hr>
                                </div>
                                <a href="{{ route('cart') }}" class="btn  btn-default view-cart float-left">View Cart</a>
                                <a href="{{ route('checkout') }}" class="btn btn-danger checkout float-right">Checkout</a>
                                <div class="clearfix"></div>
                                @else
                                    <div class="cart-empty">
                                        <p class="mb-none">No products in cart.</p>
                                    </div>
                                @endif
                            </div>

                        </div>


                    </div>
                </div>
            </div>

        </div>
        <div class="clearfix"></div>
    </div>
    <div class="header-nav">
        <div class="container">
            <div class="boundary-align">
                <nav class="primary-menu">
                    <ul class="nav-category">
                        @foreach($productCategories->slice(0, 10) as $menu)
                        <li class="nav-item">
                            <a class="d-flex main--menu" href="{{ url('/') . '/category/' . $menu->slug }}" target="_self">{{ $menu->name }}
                                @if($menu->subCategory->isNotEmpty())
                                    <span class="hover_none" uk-icon="icon: chevron-down"></span>
                                    <span class="hover_block" uk-icon="icon: chevron-up"></span>
                                @endif
                            </a>
                            @if($menu->subCategory->isNotEmpty())
                            <div  uk-dropdown="mode: click; pos: bottom-justify; boundary: .boundary-align; boundary-align: true; delay-hide:0; duration:0;"
                                 style="margin-top: 0; padding: 0px; box-shadow: none; border-top:1px solid #3333;" class="hide--onpageload">
                                <div class="d-flex justify-content-between flex-wrap dropdown_mega_menu">
                                    @foreach($menu->subCategory as $child)
                                    <ul class="uk-nav uk-dropdown-nav">
                                        <li class="uk-nav-header uk-active"><a href="{{ url('/') . '/category/' . $child->slug }}">{{ $child->name }}</a></li>
                                        @if($child->subCategory->isNotEmpty())
                                            @foreach($child->subCategory as $subchild)
                                                <li class=""><a href="{{ url('/') . '/category/' . $subchild->slug }}">{{ $subchild->name }}</a></li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    @endforeach

                                </div>
                            </div>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>

    <div id="offcanvas-usage" uk-offcanvas>
        
        <div class="uk-offcanvas-bar">

            <button class="uk-offcanvas-close" type="button" uk-close></button>
<div class="mbnavvvv"> <a  href="{{ route('home') }}" aria-expanded="true"> <i class="fas fa-home"></i>  Home</a></div>
            <section class="mobile-nav" >

                <ul class="metismenu" id="menu">
                    <!--<li class="mhomerhul"> -->
                    <!--    <a  href="{{ route('home') }}" aria-expanded="true"> <i class="fas fa-home"></i>  Home</a>-->
                    <!--</li>-->
                    @foreach($productCategories->slice(0, 10) as $menu)
                    <li>
                        <a  href="{{ url('/') . '/category/' . $menu->slug }}" aria-expanded="false">
                            {{ $menu->name }} @if($menu->subCategory->isNotEmpty()) <span class="fa arrow"></span> @endif
                        </a>
                        @if($menu->subCategory->isNotEmpty())
                        
                        <ul aria-expanded="false" class="list-levels">
                            @foreach($menu->subCategory as $child)
                            <li><a href="{{ url('/') . '/category/' . $child->slug }}">{{ $child->name }} @if($child->subCategory->isNotEmpty()) <span class="fa plus-times"></span> @endif</a>
                                @if($child->subCategory->isNotEmpty())
                                <ul aria-expanded="false" class="list-levels">
                                    @foreach($child->subCategory as $subchild)
                                    <li><a href="{{ url('/') . '/category/' . $subchild->slug }}">{{ $subchild->name }}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @endforeach
                    <ul class="metismenu" id="menu contactnavbuttom" style="border-top: 1px solid #eee;">
                    <li>
                        <a  href="{{ route('sell.index') }}" aria-expanded="false" style="padding:10px 0;">Become a Seller</a>
                    </li>
                    <li>
                        <a  href="{{ route('track.order') }}" aria-expanded="false" style="padding:10px 0;">Track my order</a>
                    </li>
                                                    <ul class="metismenu" id="menu contactnavbuttom" style="border-top: 1px solid #eee;">
                    <li>
                        <a  href="{{ route('aboutus') }}" aria-expanded="false" style="padding:10px 0;">About us</a>
                    </li>
                    <li>
                        <a  href="{{ route('contact.create') }}" aria-expanded="false" style="padding:10px 0;">Contact us</a>
                    </li>
                                        <li>
                        <a  href="#" aria-expanded="false" style="padding:10px 0;">Payments</a>
                        </li>
                                            <li>
                        <a  href="#" aria-expanded="false" style="padding:10px 0;">Shipping</a>
                        </li>
                                            <li>
                        <a  href="#" aria-expanded="false" style="padding:10px 0;">Policy</a>
                        </li>
                    <!--                        <li>-->
                    <!--    <a  href="#" aria-expanded="false" style="padding:10px 0;">Privacy</a>-->
                    <!--</li>-->
                    
                          <ul class="metismenu" id="menu contactnavbuttom" style="border-top: 1px solid #eee;">
                              <li><a href="{{ route('request.product.create') }}" class="checkout  text-white float-none" id="rqstmoblenav">Request Product</a></li>
                    
                    
                    
                    
                </ul>
                    
                </ul>
                </ul>
                              
                     
                </ul>

                
            </section>
        </div>
    </div>
