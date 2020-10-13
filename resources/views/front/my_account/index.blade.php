@extends('layouts.app')
@section('title',"My Account")
@section('extra_styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
@endsection
@section('content')
    @include('front.partials.models._edit_user_info')

    <section class="content-box-row ">
        <div class="container " style="margin:10px auto;padding:0;">
            @if(isset($verified))
                @if($verified==0)
                    <div class="notify">
                        <div id="notif-messages" class="alert alert-warning" style="display: block;">
                            <span class="icon-circle-check mr-2"></span>
                            <i class="fa fa-info-circle "></i> Your account has not been activated yet. Please check
                            your email and activate! <a href="{{ route('resend.mail', auth()->id()) }}">Click here</a> to resend email
                        </div>
                    </div>
                @endif
            @endif


            <div class="profile__section">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <div class="account--userInfo">
                            @if(isset($user_info->image))
                                <figure>
                                    <img src='{{ asset('').'/'.$user_info->image }}' alt=''>
                                </figure>
                            @else
                                <i class="fa fa-user-circle" style="font-size: 35px;"></i>
                            @endif
                            <a href="javascript:void(0)" class="display--block" style="padding-left:10px;">
                                <span class="userInfo--name bold">{{ Auth::User()->user_name }}</span></br>
                                <small class="userInfo--email data">{{ Auth::User()->email }}</small>
                            </a>
                        </div>
                        <div class="grouplist desktop-grouplist tab hidden-xs">
                            <ul class="liststyle--none">
                                <li>
                                    <a href="javascript:void(0)" class="tabslinks user-order"
                                       onclick="accountsettings(event, 'orders')" id="user-order">
                                        <i class="fas fa-book fa-2x mr-10"></i>&nbsp;&nbsp;My orders</a>
                                </li>
                                <li><a href="javascript:void(0)" class="tabslinks user-address"
                                       onclick="accountsettings(event, 'address')" id="user-address">
                                        <i class="fas fa-address-card fa-2x mr-10"></i>&nbsp;&nbsp;Shipping addresses</a>
                                </li>
                                <li><a href="javascript:void(0)" class="tabslinks user-wishlist"
                                       onclick="accountsettings(event, 'wishlist')" id="user-wishlist">
                                        <i class="fas fa-heart fa-2x mr-10"></i>&nbsp;&nbsp;wish lists</a>
                                </li>
                                <!--<li><a href="javascript:void(0)" class="tabslinks user-negotiable"-->
                                <!--       onclick="accountsettings(event, 'negotiable')" id="user-negotiable">-->
                                <!--        <i class="fas fa-handshake fa-2x mr-10"></i>&nbsp;&nbsp;Negotiable</a>-->
                                <!--</li>-->
                                <li><a href="javascript:void(0)" class="tabslinks user-account"
                                       onclick="accountsettings(event, 'account')" id="user-account">
                                        <i class="fas fa-edit fa-2x mr-10"></i>&nbsp;&nbsp;account settings</a>
                                </li>

                                <li>
                                    <form id="logout_form-md" action="{{ route('logout') }}" method="post">
                                        {{ csrf_field() }}
                                    </form>
                                    <a href="#"
                                       onclick="event.preventDefault(); document.getElementById('logout_form-md').submit();">
                                        <i class="fas fa-sign-out-alt fa-2x mr-10"></i>&nbsp;&nbsp;Logout</a>
                                </li>
                            </ul>
                        </div>

                        <div class="grouplist mobile-grouplist  tab visible-xs">
                            <ul class="liststyle--none">
                                <li><a href="javascript:void(0)" class="tabslinks user-order"
                                       onclick="accountsettings(event, 'orders')" title="orders"><i
                                                class="fas fa-book fa-2x mr-10"></i></a></li>
                                <li><a href="javascript:void(0)" class="tabslinks user-address"
                                       onclick="accountsettings(event, 'address')" title="address"><i
                                                class="fas fa-address-card fa-2x mr-10"></i></a></li>
                                <li><a href="javascript:void(0)" class="tabslinks user-wishlist"
                                       onclick="accountsettings(event, 'wishlist')" title="wishlist"><i
                                                class="fas fa-heart fa-2x mr-10"></i></a></li>
                                <li><a href="javascript:void(0)" class="tabslinks user-negotiable"
                                       onclick="accountsettings(event, 'negotiable')" title="negotiable"
                                       id="user-negotiable"><i
                                                class="fas fa-handshake fa-2x mr-10"></i></a></li>
                                <li><a href="javascript:void(0)" class="tabslinks user-account"
                                       onclick="accountsettings(event, 'account')" id="defaultopen" title="account"><i
                                                class="fas fa-edit fa-2x mr-10"></i></a></li>
                                <li>
                                    <form id="logout_form2" action="{{ route('logout') }}" method="post">
                                        {{ csrf_field() }}
                                    </form>
                                    <a href="#"
                                       onclick="event.preventDefault(); document.getElementById('logout_form2').submit();"
                                       title="logout"><i
                                                class="fas fa-sign-out-alt fa-2x mr-10"></i></a>
                                </li>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-12 hide--onpageload">
                        <div class="account-settings__container tabcontent" id="account" style="display:block">
                            <div class="row">
                                <!--<div class="col-lg-4 col-md-5 col-sm-6  offset-lg-4 offset-md-3 offset-sm-3">-->
                                <!--    <div class="waller--user" style="text-align: center;">-->
                                <!--        <div class="row">-->
                                <!--            <div class="col-md-4 col-sm-12">-->
                                <!--                <img src="https://d30y9cdsu7xlg0.cloudfront.net/png/3055-200.png">-->
                                <!--            </div>-->
                                <!--            <div class="col-md-8 col-sm-12 text-left">-->
                                <!--                <div style="font-weight: bold;font-size: 17px;">Wallets Details</div>-->
                                <!--                <div>-->
                                <!--                    Rs.<strong>{{ Auth::User()->wallets ?number_format(Auth::User()->wallets->amount,2): 0.00    }}</strong>(NRP)-->
                                <!--                </div>-->
                                <!--                <div>Your Wallet Balance</div>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="card">
                                    <div class="card-header">
                                        <strong class="titles">Account Information</strong>
                                        <a class="pull-right link" href="javascript:void(0)" data-toggle="modal"
                                           data-target="#edit_account_info">Edit</a>
                                    </div>
                                    <div class="card-body">
                                        <span class="para ">
                                            <ul class="liststyle--none">
                                                <li><span class="mr-10 bold">Name:</span>
                                                    <span class="userInfo--name">{{ Auth::User()->first_name.' '.Auth::User()->last_name }}</span>
                                                </li>
                                                <li><span class="mr-10 bold">Password:</span>
                                                    <span class="userInfo--password data">********</span>
                                                </li>
                                                <li><a class="link" href="javascript:void(0)" data-toggle="modal"
                                                       data-target="#change_password">Change Password</a>
                                                </li>
                                            </ul>
                                        </span>
                                    </div>
                                        
                                    </div>

                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                        <strong class="titles">Personal Information</strong>
                                        <a class="pull-right link" href="javascript:void(0)" data-toggle="modal"
                                           data-target="#edit_personal_info">Edit</a>
                                    </div>
                                    <div class="card-body">
                                        <span class="para ">
                                            <ul class="liststyle--none">
                                                <li><span class="mr-10 bold">Name:</span><span
                                                            class="userInfo--name"> {{ Auth::User()->first_name.' '.Auth::User()->last_name }}</span></li>
                                                <li><span class="mr-10 bold">Username:</span><span
                                                            class="userInfo--username data"> {{ Auth::User()->user_name }}</span></li>
                                                <li><span class="mr-10 bold">Gender:</span><span
                                                            class="userInfo--gender data"> {{ isset($user_info->gender)? $user_info->gender == 1 ? "Male":"Female":'' }}</span></li>
                                                <li><span class="mr-10 bold">Date of birth:</span><span
                                                            class="userInfo--dob data"> {{ isset($user_info->dob)?$user_info->dob:'' }}</span></li>
                                            </ul>
                                        </span>
                                    </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="container orders__container tabcontent" id="orders">
                            <h3>My orders</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed" id="usersOrderTable">
                                    <thead>
                                    <tr>
                                        <th>ORDERS#</th>
                                        <th>DATE</th>
                                        <th>ORDER TOTAL</th>
                                        <th>ORDER STATUS</th>
                                        <th>Live Tracking</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        @if(empty($order->prebookings) || (isset($order->prebookings) && $order->prebookings->status == 1))
                                        <tr>
                                            <td>{{$order->id}}</td>
                                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('F j, Y')}}</td>

                                            <td>
                                                @php
                                                    $priceTotal = 0.00;
                                                    $tax = 0.00;
                                                    $discount = 0.00;
                                                    foreach ($order->products as $product){
                                                        $actualPrice = $product->sale_price * $product->pivot->qty;
                                                        if($product->pivot->prebooking == 1) {
                                                            $priceTotal += ($actualPrice * 10) / 100;
                                                            $tax += 0;
                                                        }
                                                        else {
                                                            $priceTotal += $actualPrice;
                                                            $tax += ($actualPrice * $product->tax) / 100;
                                                        }
                                                        $discount += $product->pivot->discount;
                                                    }

                                                    $subTotal = $priceTotal;
                                                    $grandTotal = $subTotal + $tax + $order->shipping_amount - $discount;
                                                @endphp
                                                Rs. {{ number_format($grandTotal, 2) }} for
                                                <strong>{{ count($order->products) }}</strong> Products
                                            </td>
                                            <td>
                                                <span class="label label-{{ getOrderStatusClass($order->orderStatus->name) }}">{{$order->orderStatus->name}}</span>
                                            </td>
                                            <td>{{$order->code}}</td>
                                            <td>
                                                <a href="{{route('my-account.order-details', $order->id)}}"
                                                   class="btn btn-default btn-xs"><span
                                                            class="fa fa-eye text-warning"></span></a>
                                                @if($order->orderStatus->name == 'pending')
                                                    <a href="{{ route('my-account.order.cancel',$order->id)}}"
                                                       class="btn btn-xs btn-danger"
                                                       onclick="return confirm('Are you sure you want to cancel this order?');">Cancel</a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr>

                            @if(count($prebookingOrders) > 0)
                            <h3>My Prebookings</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed" id="usersPreOrderTable">
                                    <thead>
                                    <tr>
                                        <th>ORDERS#</th>
                                        <th>DATE</th>
                                        <th>ORDER TOTAL</th>
                                        <th>ORDER STATUS</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        @if(!empty($order->prebookings) && $order->prebookings->status == 0)
                                        <tr>
                                            <td>{{$order->id}}</td>
                                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('F j, Y')}}</td>

                                            <td>
                                                Rs. {{ number_format($order->prebookings->price, 2) }} for
                                                <strong>{{ count($order->products) }}</strong> Products
                                            </td>
                                            <td>
                                                <span class="label label-{{ getOrderStatusClass($order->orderStatus->name) }}">{{$order->orderStatus->name}}</span>
                                            </td>
                                            <td>
                                                <button class="btn btn-info btn-xs buyprebooking" data-product="{{ $order->prebookings->product_id }}" data-order="{{ $order->id }}" @if(App\Model\Product::where('id', $order->prebookings->product_id)->first()->prebooking == 1) disabled @endif>Buy Now</button>
                                                @if($order->orderStatus->name == 'pending')
                                                    <a href="{{ route('my-account.order.cancel',$order->id)}}"
                                                       class="btn btn-xs btn-danger"
                                                       onclick="return confirm('Are you sure you want to cancel this order?');">Cancel</a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            @endif

                            @if($order_returns->isNotEmpty())
                            <h3>Return Orders</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed" id="usersOrderReturnTable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Qty</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order_returns as $order_return)
                                        <tr>
                                            <td>{{ $order_return->orderReturnProducts->first()->order_product->order_id }}</td>
                                            <td>{{ $order_return->orderReturnProducts->first()->order_product->products->name }}</td>
                                            <td>{{ $order_return->orderReturnProducts->first()->qty }}</td>
                                            <td>
                                                <span class="label label-{{ getOrderReturnStatusClass($order_return->orderReturnStatus->name) }}">{{ $order_return->orderReturnStatus->name }}</span>
                                            </td>
                                            <td>{{ humanizeDate($order_return->created_at) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                        <div class="container wishlist__container tabcontent" id="wishlist">
                            <h3>My wishlist</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="wishlistTable">
                                    <thead>
                                    <tr>
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                        <th>Product Price</th>
                                        <th>Sale Price</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($wishlists as $wishlist)
                                        <tr>
                                            <td style="width:100px;">
                                                <div class="wishlist-product-img">
                                                    <a href="">
                                                        <img src="{{$wishlist->product->getImageAttribute()->mediumUrl}}"
                                                             alt="">
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="/product/{{ $wishlist->product->slug }}" class="link"
                                                   style="text-transform: capitalize;">{{$wishlist->product->name}}</a>
                                            </td>
                                            <td class="price__container">
                                                <span class="price">Rs. {{$wishlist->product->product_price}}</span>
                                            </td>
                                            <td>
                                                <span class="price">Rs. {{$wishlist->product->sale_price}}</span>
                                            </td>
                                            <td>
                                                <a class="btn btn-info button__buynow__link buynow" href="{{ route('product.show', $wishlist->product->slug) }}">
                                        <span>Buy Now</span></a>
                                                <a class="btn btn-danger btnMenu request"
                                                   href="{{ route('wishlist.delete',$wishlist->id) }}">Remove</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--<div class="container wishlist__container tabcontent" id="negotiable">-->
                        <!--    <h3>Negotiable</h3>-->
                        <!--    <div class="table-responsive">-->
                        <!--        <table class="table table-bordered" id="negotiableTable">-->
                        <!--            <thead>-->
                        <!--            <tr>-->
                        <!--                <th>Product Image</th>-->
                        <!--                <th>Name</th>-->
                        <!--                <th>Sales Price</th>-->
                        <!--                <th>Negotiable Price</th>-->
                        <!--                <th>Checkout</th>-->
                        <!--                <th>Action</th>-->
                        <!--            </tr>-->
                        <!--            </thead>-->
                        <!--            <tbody>-->

                        <!--            @foreach($nego_topic as $nego_product)-->
                        <!--                <tr>-->
                        <!--                    <td style="width:100px;">-->
                        <!--                        <div class="wishlist-product-img">-->
                        <!--                            <a href="">-->
                        <!--                                <img src="{{$nego_product->product->getImageAttribute()->mediumUrl}}"-->
                        <!--                                     alt="">-->
                        <!--                            </a>-->
                        <!--                        </div>-->
                        <!--                    </td>-->
                        <!--                    <td>-->
                        <!--                        <span class="price"><a-->
                        <!--                                    href="/product/{{ $nego_product->product->slug }}"-->
                        <!--                                    class="link">{{$nego_product->product->name}}</a></span>-->
                        <!--                    </td>-->
                        <!--                    <td>-->
                        <!--                        <span class="price">{{$nego_product->product->sale_price}}</span>-->
                        <!--                    </td>-->
                        <!--                    <td>-->
                        <!--                        @if($nego_product->fixed_price == null)-->
                        <!--                            <span class="price" style="color: #ccc">-->
                        <!--                        yet not fixed-->
                        <!--                    </span>-->
                        <!--                        @else-->
                        <!--                            <span>-->
                        <!--                          {{ $nego_product->fixed_price }}-->
                        <!--                        </span>-->
                        <!--                        @endif-->
                        <!--                    </td>-->
                        <!--                    <td>-->
                        <!--                        <a href="{{route('negoiate.checkout',$nego_product->id)}}"-->
                        <!--                           class="btn btn-default request"-->
                        <!--                           @if($nego_product->fixed_price ==null) disabled @endif>Checkout</a>-->
                        <!--                    </td>-->
                        <!--                    <td>-->
                        <!--                        <a class="btn btn-default btnMenu request"-->
                        <!--                           href="{{ route('negotiate.chat',$nego_product->id) }}">Negotiate</a>-->

                        <!--                        <a class="btn btn-default btnMenu request"-->
                        <!--                           href="{{ route('negotiate.delete',$nego_product->id) }}">Remove</a>-->
                        <!--                    </td>-->
                        <!--                </tr>-->
                        <!--            @endforeach-->
                        <!--            <div id="negotiable_chat" class="modal fade in" tabindex="-1" role="dialog"-->
                        <!--                 aria-labelledby="myModalLabel" style="display: none; padding-left: 0px;">-->
                        <!--                <div class="modal-dialog" role="document">-->
                        <!--                    <div class="modal-content">-->
                        <!--                        <div class="modal-header" style="display: block;">-->
                        <!--                            <button type="button" class="close" data-dismiss="modal"-->
                        <!--                                    aria-label="Close"><span aria-hidden="true">×</span>-->
                        <!--                            </button>-->
                        <!--                            <h4 class="modal-title" id="myModalLabel">Samsung Mobile</h4>-->
                        <!--                            <div class="content__box content__box--shadow" id="chatBox"-->
                        <!--                                 style="height:350px;overflow: auto;">-->
                        <!--                                <div id="reload-admin">-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!--                    </div>-->
                        <!--                </div>-->
                        <!--            </div>-->
                        <!--            </tbody>-->
                        <!--        </table>-->
                        <!--    </div>-->

                        <!--</div>-->
                        <div class="container address__container tabcontent" id="address">
                            <h3>Address settings</h3>
                            {{-- shipping_form --}}
                            @include('front.my_account.shipping_address')
                            <div id="edit_address_shipping" class="modal fade" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('extra_scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#usersOrderTable').DataTable();
        });

         $(document).ready(function () {
            $('#usersPreOrderTable').DataTable();
        });

        $(document).ready(function () {
            $('#usersOrderReturnTable').DataTable();
        });

        $(document).ready(function () {
            $('#wishlistTable').DataTable();
        });

        $(document).ready(function () {
            $('#negotiableTable').DataTable();
        });

        $(document).ready(function () {
            $('#referralTable').DataTable();
        });

        $(document).ready(function () {
            $('#account button').on('click', function () {

                var $this = $(this);

                var id = $this.attr('data-id');
                var row = $(this).parent().parent().parent().children('.panel');
                var parent = $(this).parent().parent();
                var len = row.length;
                if(parent.children('.panel-heading ').children('i').hasClass('lx')){
                    row.children('.panel-heading').children('.lx').remove();
                }
                else
                {
                    for (var i = 0; i < len; i++) {
                        row.children('.panel-heading').children('.lx').remove();
                    }
                    parent.children('.panel-heading').append('<i class="fas fa-star pull-left uk-margin-right lx fa-1x"  style="color:gold"></i>');  
                }

                var tempUseUrl = "{{ route('my-account.shipping.use') }}";

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: tempUseUrl,
                    data: {'id': id},
                    beforeSend: function (data) {
                    },
                    success: function (data) {
                    },
                    error: function (xhr, ajaxOptions, thrownError) {

                    },
                    complete: function () {
                    }
                });
            });
        });

        var $edit_shipping = $('#edit_address_shipping');

        $(document).on("click", ".btn-edit", function (e) {
            e.preventDefault();
            var $this = $(this);
            var id = $this.attr('data-edit-id');
            var tempEditUrl = "{{ route('my-account.shipping.edit', ':id') }}";
            tempEditUrl = tempEditUrl.replace(':id', id);

            $edit_shipping.load(tempEditUrl, function (response) {
                $edit_shipping.modal('show');
            });
        });

        $(document).on("click", ".modal-close", function (e) {
            e.preventDefault();
                $edit_shipping.hide();
        });

        $(document).on("click", ".buyprebooking", function (e) {
        e.preventDefault();
        var $this = $(this);
        var product = $this.attr('data-product');
        var order = $this.attr('data-order');
        var quantity = 1;
        // var select = document.getElementById("select_size");
        // if (document.querySelector('input[name="size"]:checked')) {
        //     var size = document.querySelector('input[name="size"]:checked').value;
        // }

        if (product) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('cart.prebooking')  }}",
                data: {
                    product: product,
                    order: order,
                    quantity: quantity
                    // size: size
                },
                beforeSend: function (data) {
                    $this.button('loading');
                },
                success: function (data) {
                    if (data.status) {
                        location.href="{{ route('checkout') }}";
                    }

                    UpdateMiniCart();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var err;
                    if (xhr.status === 401) {
                        err = eval("(" + xhr.responseText + ")");
                        sweetAlert('error', 'Oops...', err.message );
                        return false;
                    }

                    sweetAlert('error', 'Oops...', 'Something went wrong!');
                },
                complete: function () {
                    $this.button('reset');
                    //$("html, body").animate({scrollTop: 0}, "slow");
                }
            });
        }

    });
    </script>
<!--    <script>-->
<!--        document.getElementById("zone").onchange = function() {-->

<!--            var e = document.getElementById("zone");-->
<!--            var zone = e.options[e.selectedIndex].value;-->
<!--            $.ajaxSetup({-->
<!--                headers: {-->
<!--                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')-->
<!--                }-->
<!--            });-->
<!--            $.ajax({-->
<!--                type:'GET',-->
<!--                url: "{{ route('checkout.zone') }}",-->
<!--                data:{-->
<!--                    zone:zone-->
<!--                },-->
<!--                success: function(data) {-->
//                console.log(data);

<!--                    $('#district').html(data);-->
<!--                }-->

<!--            });-->
<!--        };-->

<!--        document.getElementById("district").onchange = function() {-->

<!--            var e = document.getElementById("district");-->
<!--            var zone = e.options[e.selectedIndex].value;-->
<!--            $.ajaxSetup({-->
<!--                headers: {-->
<!--                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')-->
<!--                }-->
<!--            });-->
<!--            $.ajax({-->
<!--                type:'GET',-->
<!--                url: "{{ route('checkout.zone') }}",-->
<!--                data:{-->
<!--                    zone:zone-->
<!--                },-->
<!--                success: function(data) {-->
<!--                    $('#area').html(data);-->

<!--                }-->

<!--            });-->
<!--        };-->


<!--    </script>-->

@endsection