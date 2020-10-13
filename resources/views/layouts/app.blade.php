<!doctype html>
<html lang="en" style="overflow-x:hidden">
<head>
    <meta name="google-site-verification" content="9zrAyNPP518GhixcY8EqdR1QB8RdxqK5RwvBpfqV4z4" />
    <meta charset="UTF-8">
    
    <meta name="theme-color" content="#345b9b">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
      <title>@yield('title',  getConfiguration('site_title') ? getConfiguration('site_title') : env('APP_NAME') )</title>
        <meta name="description" content="@yield('site_description', getConfiguration('site_description') )">

        <meta name="keywords" content="online shopping Nepal, clothing, electronics, beauty and personal care, pants, fans, guitars, musical
instruments, women dresses, shrugs, shoes for men, online shopping sites in Nepal, sneakers for men,
men’s trousers, sports shoes for men, online clothing store in Nepal, men’s jeans, casual shoes for men,
formal shoes for men, online stores in Nepal, men’s pants, online shoes Nepal, white shoes for men,
watch shop, casual shoes, shoe brands, best shoes for men, online shop Nepal, shoes online, men’s
joggers, jogger pants, shirts shop online">
      
	@if(getConfiguration('site_favicon'))
        <link rel="shortcut icon" href="{{ url('storage') . '/' . getConfiguration('site_favicon') }}"
              type="image/x-icon"/>
    @endif
    



    @include('partials.stylesheets')
    @yield('extra_styles')
    <style>
        .algolia-autocomplete {
            display: flex !important;
        }

        .aa-input {
            display: block;

        }

        .aa-input-container {
            display: inline-block;
            position: relative;
        }

        .aa-input-search {
            width: 300px;
            padding: 12px 28px 12px 12px;
            border: 1px solid #e4e4e4;
            box-sizing: border-box;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .aa-input-search::-webkit-search-decoration, .aa-input-search::-webkit-search-cancel-button,
        .aa-input-search::-webkit-search-results-button, .aa-input-search::-webkit-search-results-decoration {
            display: none;
        }

        .aa-input-icon {
            height: 16px;
            width: 16px;
            position: absolute;
            top: 50%;
            right: 16px;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            fill: #e4e4e4;
            pointer-events: none;
        }

        .aa-dropdown-menu {
            background-color: #fff;
            border: 1px solid rgba(168, 168, 168, 0.6);
            width: 100%;
            margin-top: 10px;
            box-sizing: border-box;
        }

        .aa-dropdown-menu .search-cat {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: #000;
            float: left;
            display: inline;
            width: 70%;
        }

        .aa-dropdown-menu .search-cat .searchTerm {
            font-weight: 700;
            color: #000;
            padding-right: 10px;
        }

        .aa-dropdown-menu .search-cat .in {
            padding-right: 10px;
        }

        .aa-dropdown-menu .search-cat .searchCategory {
            /*padding-left:10px;*/
        }

        .aa-dropdown-menu .total {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            width: 30%;
            float: right;
            display: inline;
            font-size: 14px;
            color: gray;
            text-align: right;
        }

        .aa-dropdown-menu span {
            display: inline;
        }

        .aa-dropdown-menu .total .count {
            color: #000;
            padding: 20px;
        }

        .search-product{
            display:table;
        }

        .aa-dropdown-menu .product-image {
            padding-right: 10px;
            width: 20%;
            display: table-cell;
            float:left;
        }

        .aa-dropdown-menu .product-image img {
            width: auto;
            max-width: 80px;
            max-height: 62px;
        }

        .aa-dropdown-menu .product-details {
            padding-top: 10px;
            display: table-cell;
            width: 80%;
            vertical-align: top;
        }

        .aa-dropdown-menu .product-details .product-title {
            display: block;
            color: gray;
            direction: ltr;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .aa-dropdown-menu .product-details .product-title .description {
            padding-left: 10px;
        }

        .aa-dropdown-menu .product-details .product-title > span:first-child {
            float: left;
            padding-right: 5px;
        }

        .aa-dropdown-menu .product-details .product-price {
            color: #da061c;
        }

        .aa-suggestion {
            padding: 6px 12px;
            cursor: pointer;
        }

        .aa-suggestions-category {
            border-bottom: 1px solid rgba(228, 228, 228, 0.6);
            border-top: 1px solid rgba(228, 228, 228, 0.6);
            padding: 6px 12px;
        }

        .aa-dropdown-menu > div {
            display: inline-block;
            width: 100%;
            vertical-align: top;
        }

        .aa-empty {
            padding: 6px 12px;
        }

        .aa-hint {
            width: 100%;
            height: 100%;
        }
        .alert-success.alert-dismissible {
            position: fixed;
            top: 10px;
            right: 0;
            transition: all 2000ms;
            z-index: 9999; 
            overflow: hidden;
        }
        .alert-danger.alert-dismissible {
            position: fixed;
            top: 10px;
            right: 0;
            transition: all 2000ms;
            z-index: 9999; 
            overflow: hidden;
        }
    </style>
    
    <link rel="manifest" href="/manifest.json" />
    <script>
        $('.product-image img').attr('data-src', true)
    </script>
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
      var OneSignal = window.OneSignal || [];
      OneSignal.push(function() {
        OneSignal.init({
          appId: "e07a73e5-4a92-4869-ba94-37742d81db71",
        });
      });
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-136400937-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-136400937-2');
</script>


<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '309242853363066');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=309242853363066&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->


<script type="application/ld+json">{   
  "@context": "http://schema.org",   
  "@type": "WebSite",   
  "url": "https://www.nepalallshop.com.np/",   
  "potentialAction": {     
    "@type": "SearchAction",     
    "target": "https://nepalallshop.com.np/search?query=sunglasses",
    "query-input": "required name=sunglasses"   
  } 
}</script>
</head>
<body >

<div class="uk-offcanvas-content">
   
        @include('partials.header')

        @include('partials.message-success')
        @include('partials.message-error')

        @yield('content')
        @include('partials.footer')
       
        <p class="totop" style="    position: fixed;
        right: 20px;
        bottom: 20px;
        background: #ed1b2f;
        color: white;
        z-index: 999;">
            <a href="javascript:void(0)" id="top" uk-icon="icon:arrow-up"></a>
        </p>

        <!-- Modal login form -->
<div class="modal fade" id="login__form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document" >
        <div class="modal-content">
            <div class="modal-body" id="cusloginsignup">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="position: absolute;right: 10px;color: white;top: 0;">
                    <span aria-hidden="true">×</span>
                </button>
                <div class="wrap">
                    <p class="form-title-in">
                        Sign In </p>
                    <p class="form-title-up" style="display: none">
                        Sign Up </p>
                    <form action="{{ route('login') }}" method="post" class="login" id="login-form">
                        {{ csrf_field() }}
                        <div class="{{ $errors->has('email') ? ' has-error' : '' }}">
                            <p>Your Email Address:</p>
                            <input class="uk-input" type="email" name="email" value="{{ old('email') }}" required="required" placeholder="Your Email Address">
                            @if ($errors->has('email'))
                                <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                            @endif
                        </div>
                        <div class="{{ $errors->has('password') ? ' has-error' : '' }}">
                            <p>Password:</p>
                            <input class="uk-input" type="password" name="password" required="required" placeholder="Your Password(******)">
                            @if ($errors->has('password'))
                                <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                            @endif
                        </div>
                        <div class="checkbox">
                                        <label>
                                            <input type="checkbox"/>
                                            Remember Me
                                        </label>
                                    </div>
                        <input type="submit" value="Sign In" class="btn btn-success btn-sm"/>
                        <div class="remember-forgot">
                            <div class="row">
                                <!--<div class="col-md-6">-->
                                    <!--<div class="checkbox">-->
                                    <!--    <label>-->
                                    <!--        <input type="checkbox"/>-->
                                    <!--        Remember Me-->
                                    <!--    </label>-->
                                    <!--</div>-->
                                <!--</div>-->
                                <div class="col-md-12 forgot-pass-content text-center">
                                    <a href="{{ url('/password/reset') }}" class="forgot-pass">Forgot Password??</a>
                                </div>
                            </div>
                        </div>
                        <div class="not_yet_member">
                            New at Nepal All Shop?
                            <a href="{{ route('register') }}" class="active" id="#"> Sign up Now!</a>
                        </div>
                         <div class="socialmedialogin">
                            <p>Sign in with your Social Media Account</p>
                            <div class="row">
                            <div class="col-md-6" id="fbwrap">
                                <a href="{{ url('/login/facebook') }}" class="btn">
                             <i class="fab fa-facebook-f"></i> Facebook</a>
                            </div>
                            <div class="col-md-6" id="googlewrap">
                                <a href="{{ url('/login/google') }}" class="btn">
                             <i class="fab fa-google"></i> Google</a>
                            </div>
                        </div>
                           
                        </div>
                        
                    </form>
                    <form class="login" id="register-form" action="{{ route('register') }}" method="post"
                        role="form" style="display: none;">
                        {{ csrf_field() }}

                        <div class="{{ $errors->has('user_name') ? 'has-error' : '' }}">
                            <input class="uk-input" name="user_name"  value="{{ old('user_name') }}" type="text" required="required" placeholder="Enter Username">
                            @if ($errors->has('user_name'))
                                <span class="help-block register-error">
                                    <strong>{{ $errors->first('user_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="{{ $errors->has('email') ? 'has-error' : '' }}">
                            <input class="uk-input" name="email" value="{{ old('email') }}" type="email" required="required" placeholder="Enter Email">
                            @if ($errors->has('email'))
                                <span class="help-block register-error">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="{{ $errors->has('phone') ? 'has-error' : '' }}">
                            <input class="uk-input" name="phone" type="text" value="{{ old('phone') }}" required="required" max="10" min="8" placeholder="Enter Phone Number">
                            @if ($errors->has('phone'))
                                <span class="help-block register-error">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="{{ $errors->has('password') ? 'has-error' : '' }}">
                            <input class="uk-input" name="password" type="password" required="required"
                                       placeholder="Enter password">
                            @if ($errors->has('password'))
                                <span class="help-block register-error">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="{{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                            <input class="uk-input" name="password_confirmation" type="password" required="required"
                                       placeholder="Confirm password">
                        </div>


                        <input type="submit" value="Sign Up" class="btn btn-success btn-sm"/>

                        <div class="not_yet_member">
                            <a href="javascript:void(0)" id="login-form-link"> Already a Member?</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- MODAL FOR THE CHANGE PASSWORD IN USER ACCOUNT -->
<div class="modal fade" id="modalChangeForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document"  >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="position: absolute;right: 10px;color: black;top: 0;">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body ">


                <div class="form-group ">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-user "></i></div>
                        </div>
                        <input type="text" id="Form-name" class="form-control validate" placeholder="Your Name">
                    </div>

                </div>
                <div class="form-group ">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-envelope "></i></div>
                        </div>
                        <input type="email" id="Form-email" class="form-control validate" placeholder="Email">

                    </div>
                </div>

                <div class="form-group ">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-lock "></i></div>
                        </div>
                        <input type="password" id="Form-pass" class="form-control validate" placeholder="Old Password">
                    </div>

                </div>
                <div class="form-group ">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-lock "></i></div>
                        </div>
                        <input type="password" id="Form-pass-new" class="form-control validate"
                               placeholder="New password">
                    </div>
                </div>

            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="uk-button btn-success">Change now</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for address in user account -->
<div class="modal fade" id="modalChangeAddress" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document"  >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="position: absolute;right: 10px;color: black;top: 0;">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body ">


                <div class="form-group "><select class="custom-select">
                        <option selected>Region</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="form-group ">
                    <select class="custom-select">
                        <option selected>City</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="form-group ">
                    <select class="custom-select">
                        <option selected>Area</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="form-group ">
                    <input type="text" id="Form-name" class="form-control validate" placeholder="Address">
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="uk-button btn-success">Change now</button>
            </div>
        </div>
    </div>
</div>

</div>


@include('partials.scripts')

<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<!-- Your customer chat code -->
<div class="fb-customerchat"
     attribution=setup_tool
     page_id="2028548230729769">
</div>

@yield('extra_scripts')

<script>

    $(document).ready(function(){
        $(".alert-success").delay(5000).slideUp(300);
    });
    $(document).ready(function(){
        $(".alert-danger").delay(5000).slideUp(300);
    });

    $(function () {
        autocomplete('#searchTextLg', {}, [{
            source: function (request, response) {
                $.ajax({
                    url: "{{ url('/autoCategory') }}",
                    data: {query: $("#searchTextLg").val(), category: $('#searchParaLg').val()},
                    dataType: "json",
                    type: "GET",
                    success: function (data) {
                        response($.map(data, function (obj) {
                            return {
                                count: obj.count,
                                productname: obj.productname,
                                catname: obj.catname,
                                catid: obj.catid,
                                slug: obj.catslug,
                                query: obj.query,
                            };
                        }));
                    }
                });
            },

            displayKey: 'name',
            templates: {
                header: '<div class="aa-suggestions-category"> <span class="title text-center"><i class="fa fa-table"></i> CATEGORIES </span> </div>',
                suggestion: function (suggestion) {
                    var a = suggestion.count, result = 'result';
                    if (a > 1) {
                        result = 'results';
                    }
                    return '<a href="{{ url('/') }}/search?cat=' + suggestion.catid + '&query=' + suggestion.query + '">' +
                        '<span class="search-cat">' +
                        '<span class="searchTerm">' + suggestion.query + '</span> ' +
                        '<span class="searchCategory"><span class="in"> in</span><em>' + suggestion.catname + '</em></span>' +
                        '</span>' +
                        ' <span class="total">' +
                        '<span class="count">(' + suggestion.count + ')</span>' +
                        '<span class="result">' + result + '</span>' +
                        '</span>' +
                        '</a>';
                }
            }
        },
            {
                source: function (request, response) {
                    $.ajax({
                        url: "{{ url('/autoComplete') }}",
                        data: {query: $("#searchTextLg").val(), category: $('#searchParaLg').val()},
                        dataType: "json",
                        type: "GET",
                        success: function (data) {
                            response($.map(data, function (obj) {
                                return {
                                    name: obj.name,
                                    slug: obj.slug,
                                    path: obj.path,
                                    id: obj.id,
                                    price: obj.product_price,
                                    // description: obj.short_description,
                                };
                            }));
                        }
                    });
                },
                displayKey: 'name',
                templates: {
                    header: '<div class="aa-suggestions-category"><span class="title text-center"><i class="fa fa-shopping-bag"></i> PRODUCTS</span></div>',
                    suggestion: function (suggestion) {
                        return '<div>' + '<a href="{{ url('/') }}/product/' + suggestion.slug + '">' + '' +
                            '<span class="product-image">' +
                            '       <img class="suggest-image" src="' + suggestion.path + '"  data-placeholder="" alt="' + suggestion.name + '">' +
                            '</span>' +
                            '<span class="product-details">' +
                            '<span class="product-title">' +
                            '<span><em>' + suggestion.name + '</em></span>' +
                            // '<span>' + suggestion.description + '</span>' +
                            '</span>' +
                            '<span class="product-price"> Rs: ' + suggestion.price.toLocaleString() + '</span>' +
                            '</span>' +
                            '</a>' +
                            '</div>';
                    }
                }
            }
        ]);

        autocomplete('#searchTextSm', {}, [{
            source: function (request, response) {
                $.ajax({
                    url: "{{ url('/autoCategory') }}",
                    data: {query: $("#searchTextSm").val(), category: $('#searchParaSm').val()},
                    dataType: "json",
                    type: "GET",
                    success: function (data) {
                        response($.map(data, function (obj) {
                            return {
                                count: obj.count,
                                productname: obj.productname,
                                catname: obj.catname,
                                catid: obj.catid,
                                slug: obj.catslug,
                                query: obj.query,
                            };
                        }));
                    }
                });
            },

            displayKey: 'name',
            templates: {
                header: '<div class="aa-suggestions-category"> <span class="title text-center"><i class="fa fa-table"></i> CATEGORIES </span> </div>',
                suggestion: function (suggestion) {
                    var a = suggestion.count, result = 'result';
                    if (a > 1) {
                        result = 'results';
                    }
                    return '<a href="{{ url('/') }}/search?cat=' + suggestion.catid + '&query=' + suggestion.query + '">' +
                        '<span class="search-cat">' +
                        '<span class="searchTerm">' + suggestion.query + '</span> ' +
                        '<span class="searchCategory"><span class="in"> in</span><em>' + suggestion.catname + '</em></span>' +
                        '</span>' +
                        ' <span class="total">' +
                        '<span class="count">(' + suggestion.count + ')</span>' +
                        '<span class="result">' + result + '</span>' +
                        '</span>' +
                        '</a>';
                }
            }
        },
            {
                source: function (request, response) {
                    $.ajax({
                        url: "{{ url('/autoComplete') }}",
                        data: {query: $("#searchTextSm").val(), category: $('#searchParaSm').val()},
                        dataType: "json",
                        type: "GET",
                        success: function (data) {
                            response($.map(data, function (obj) {
                                return {
                                    name: obj.name,
                                    slug: obj.slug,
                                    path: obj.path,
                                    id: obj.id,
                                    price: obj.product_price,
                                    description: obj.short_description,
                                };
                            }));
                        }
                    });
                },
                displayKey: 'name',
                templates: {
                    header: '<div class="aa-suggestions-category"><span class="title text-center"><i class="fa fa-shopping-bag"></i> PRODUCTS</span></div>',
                    suggestion: function (suggestion) {
                        return '<div>' + '<a href="{{ url('/') }}/product/' + suggestion.slug + '">' + '' +
                            '<span class="product-image">' +
                            '       <img class="suggest-image" src="' + suggestion.path + '"  data-placeholder="" alt="' + suggestion.name + '">' +
                            '</span>' +
                            '<span class="product-details">' +
                            '<span class="product-title">' +
                            '<span><em>' + suggestion.name + '</em></span>' +
                            '<span>' + suggestion.description + '</span>' +
                            '</span>' +
                            '<span class="product-price"> Rs: ' + suggestion.price.toLocaleString() + '</span>' +
                            '</span>' +
                            '</a>' +
                            '</div>';
                    }
                }
            }
        ]);

    });

</script>

<script>
    var $modal = $('#quickview-modal');

    $(document).on("click", ".btn-quickview", function (e) {
        e.preventDefault();
        var $this = $(this);
        var id = $this.attr('data-product-id');
        var tempEditUrl = "{{ route('quick.view', ':id') }}";
        tempEditUrl = tempEditUrl.replace(':id', id);
        $modal.load(tempEditUrl, function (response) {
        });
    });

    $(document).on("click", ".add_to_wishlist", function (e) {
        e.preventDefault();
        var $this = $(this);
        var product = $this.attr('data-product');

        if (product) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('wishlist.store')  }}",
                data: {
                    product: product
                },
                beforeSend: function (data) {
                    $this.prop('disabled', true);
                },
                success: function (data) {
                    if (data.status) {
                        UpdateWishlist();
                        $('.alert-message.alert-danger').fadeOut();
                        var message = '<div><span><strong><i class="fa fa-thumbs-o-up"></i>Success!</strong> ';
                        message += data.message;
                        message += '</span><a href="{{ route('home') }}" class="btn btn-xs btn-primary pull-right">View wishlist</a></div>';

                        $('.alert-message.alert-success').html(message).fadeIn().delay(3000).fadeOut('slow');

                        sweetAlert('success', 'Success', data.message + '<a href="{{ route('home') }}"> View Wishlist</a>');
                    }

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var err;
                    if (xhr.status === 401) {
                        err = eval("(" + xhr.responseText + ")");
                        sweetAlert('error', 'Oops...', err.message + '<a href="{{ route('login') }}"> Login</a>');
                        return false;
                    }
                    sweetAlert('error', 'Oops...', 'Something went wrong!');
                },
                complete: function () {
                    $this.prop('disabled', false);
                }
            });
        }

    });

    $(document).on("click", ".remove_from_wishlist", function (e) {
        e.preventDefault();
        var $this = $(this);
        var product = $this.attr('data-product');

        if (product) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('wishlist.remove')  }}",
                data: {
                    product: product
                },
                beforeSend: function (data) {
                    $this.prop('disabled', true);
                },
                success: function (data) {
                    if (data.status) {
                        UpdateWishlist();

                        $('.alert-message.alert-danger').fadeOut();
                        var message = '<div><span><strong><i class="fa fa-thumbs-o-up"></i>Success!</strong> ';
                        $('.alert-message.alert-error').html(message).fadeIn().delay(3000).fadeOut('slow');
                        sweetAlert('error', 'Success', data.message);
                    }
                },
                complete: function () {
                    $this.prop('disabled', false);
                }
            });
        }

    });

    function UpdateWishlist() {
        $.ajax({
            type: "GET",
            url: "{{ route('wishlist.mini')  }}",
            beforeSend: function (data) {
            },
            success: function (data) {
                $('#update-wishlist').html(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
            },
            complete: function () {
            }
        });
    }

    // function UpdateMiniCart() {
    //     $.ajax({
    //         type: "GET",
    //         url: "{{ route('cart.mini')  }}",
    //         beforeSend: function (data) {
    //             //
    //         },
    //         success: function (data) {
    //             $('#update-cart').html(data);
    //         },
    //         error: function (xhr, ajaxOptions, thrownError) {
    //             //
    //         },
    //         complete: function () {
    //             //
    //         }
    //     });
    // }

    // function updateMobileCart() {
    //     $.ajax({
    //         type: "GET",
    //         url: "{{ route('cart.mobile')  }}",
    //         beforeSend: function (data) {
    //             //
    //         },
    //         success: function (data) {
    //             $('#mobile-cart').html(data);
    //         },
    //         error: function (xhr, ajaxOptions, thrownError) {
    //             //
    //         },
    //         complete: function () {
    //             //
    //         }
    //     });
    // }

    function sweetAlert(type, title, message) {
        swal({
            title: title,
            html: message,
            type: type,
            confirmButtonColor: '#ee3d43',
            timer: 3000
        }).catch(swal.noop);
    }

    $(document).on("click", ".ajax_add_to_cart", function (e) {
        e.preventDefault();
        var $this = $(this);
        var product = $this.attr('data-product');
        var quantity = $('#quantity').val();
        quantity = quantity ? quantity : 1;
        var select = document.getElementById("select_size");
        var text = $('#coupon_code_text').val();
        if (select) {
            var size = select.options[select.selectedIndex].value;
        }
        if (document.querySelector('input[name="colour"]:checked')) {
            var colour = document.querySelector('input[name="colour"]:checked').value;
        }
        size = size ? size : 1;
        if (product) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('cart.store')  }}",
                data: {
                    product: product,
                    quantity: quantity,
                    size: size,
                    colour: colour,
                    text: text
                },
                beforeSend: function (data) {
                    //$this.button('loading');
                },
                success: function (data) {
                    if (data.status) {
                        sweetAlert('success', 'Success', data.message + '<a href="{{ url('/cart')}}"> View Cart</a>');
                    }
                    UpdateMiniCart();
                    updateMobileCart()
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var err;
                    if (xhr.status === 401) {
                        err = eval("(" + xhr.responseText + ")");
                        sweetAlert('error', '', err.message);
                        return false;
                    }
                    sweetAlert('error', 'Oops...', 'Something went wrong!');
                },
                complete: function () {
                }
            });
        }
    });

    $(document).on("click", ".btn-remove-row", function (e) {
        e.preventDefault();
        var $this = $(this);

        var rowId = $this.attr('data-row');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ url('cart/destroy')  }}" + '/' + rowId,
            data: {
                rowId: rowId
            },
            beforeSend: function () {
                $this.prop('disabled', true);
            },
            success: function (data) {
                UpdateMiniCart();
                updateMobileCart();

            },
            error: function (xhr, ajaxOptions, thrownError) {
            },
            complete: function () {
                // UpdateMiniCart();
            }
        });
    });

</script>

<script>
    OneSignal.push(function() {
      /* These examples are all valid */
      var isPushSupported = OneSignal.isPushNotificationsSupported();
      if (isPushSupported) {
        // Push notifications are supported
        console.log('supported');
        OneSignal.isPushNotificationsEnabled(function(isEnabled) {
            if (isEnabled) {
              console.log("Push notifications are enabled!");
              if(Auth::check()) {
                  OneSignal.sendTags({
                    user_id: auth()->id(),
                    logged_in_status: true,
                  }, function(tagsSent) {
                    console.log('tags: ' + JSON.stringify(tagsSent.user_id));   
                  });
                  console.log('tag sent');
              }
            }
            else {
              console.log("Push notifications are not enabled yet.");  
                OneSignal.push(function() {
                  OneSignal.showSlidedownPrompt();
                });  
            }
          });
      } else {
        // Push notifications are not supported
      }
    });
</script>
<script>
    $(document).on('submit', '#vendorRegistrationForm', function (e) {
        e.preventDefault();
//        $(this).attr('disabled');
        var form = new FormData($('#vendorRegistrationForm')[0]);
           
            if($('input[name="shop_category[]"]:checked').length <= 0) {
                $('#shop_category_error').css("display", "block");
            }else{
                $('#shop_category_error').css("display", "none");
            }
        
        // console.log(.val());
        
        var params = $('#vendorRegistrationForm').serializeArray();

        var myUrl = "{{route('sell.post')}}";

        $.each(params, function (i, val) {
            form.append(val.name, val.value)
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: myUrl,
            contentType: false,
            processData: false,
            data: form,
            beforeSend: function (data) {
                $('#vendorRegistrationSubmit').html('Loading... <img style="width: 30px;" src="https://loading.io/spinners/spin/lg.ajax-spinner-gif.gif">');
                $("#vendorRegistrationSubmit").attr("disabled", true);
                $("#v-register").delay(1000).fadeIn("slow");

            },
            success: function (data) {

                sweetAlert(data.status, '', data.message);

                $("#vendorRegistrationSubmit").attr("disabled", false);
                $('#vendorRegistrationSubmit').html('Submit');
                $('#vendorRegistrationForm')[0].reset();
                window.location.href = 'https://nepalallshop.com.np/vendors';


//                $('#quickView').modal('hide');

                $("#v-register").delay(1000).fadeOut("slow");
            },
            error: function (err) {
                $("#vendorRegistrationSubmit").attr("disabled", false);
                $('#vendorRegistrationSubmit').html('Submit');
                if (err.status == 422) {
                    $.each(err.responseJSON.errors, function (i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        el.after($('<span style="color: red;">' + error[0] + '</span>').fadeOut(15000));
                    });
                }
            }
        });
    });
</script>

</body>
</html>
