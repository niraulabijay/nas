@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')

    <h3>Dashboard</h3>

    <section>
        <div class="row">
            <div class="col-lg-3 col-md-6" style="margin-bottom:10px;">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3"><i class="fab fa-product-hunt fa-5x"></i></div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ $count_products }}</div>
                                <div>Total Product!</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.products.index', 'status=all') }}">
                        <div class="panel-footer"><span class="pull-left">View Details</span><span
                                    class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" style="margin-bottom:10px;">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3"><i class="fas fa-users fa-5x"></i></div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ $count_users }}</div>
                                <div>Total Users</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.users.main') }}">
                        <div class="panel-footer"><span class="pull-left">View Details</span><span
                                    class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" style="margin-bottom:10px;">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3"><i class="fa fa-shopping-cart fa-5x"></i></div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ $count_orders }}</div>
                                <div>Total Orders</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('/admin/order/list?status=pending') }}">
                        <div class="panel-footer"><span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" style="margin-bottom:10px;">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3"><i class="fab fa-facebook-messenger fa-5x"></i></div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ $messages }}</div>
                                <div>New Messages</div>
                            </div>
                        </div>
                    </div>
                    <a href="/contact-us">
                        <div class="panel-footer"><span class="pull-left">View Details</span><span
                                    class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" style="margin-bottom:10px;">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3"><i class="fas fa-users fa-5x"></i></div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ $vendorsCount }}</div>
                                <div>Total Vendors</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('/admin/users?role=vendor') }}">
                        <div class="panel-footer"><span class="pull-left">View Details</span><span
                                    class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" style="margin-bottom:10px;">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3"><i class="fas fa-thumbs-down fa-5x"></i></div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ $disputes }}</div>
                                <div>Total Dispute</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('/admin/disputes') }}">
                        <div class="panel-footer"><span class="pull-left">View Details</span><span
                                    class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" style="margin-bottom:10px;">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3"><i class="fas fa-bars fa-5x"></i></div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ $brands }}</div>
                                <div>Total Brands</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('/admin/brands') }}">
                        <div class="panel-footer"><span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" style="margin-bottom:10px;">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3"><i class="fas fa-users fa-5x"></i></div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ $clients }}</div>
                                <div>Total Client</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('/admin/users?role=client') }}">
                        <div class="panel-footer"><span class="pull-left">View Details</span><span
                                    class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="box">
            <div class="row">
                <div class="col-sm-12">
                    <div class="tabs_nav_container content__box content__box--shadow">

                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tabs_01"><i class="fa fa-chart-line"></i>
                                    Statistics</a></li>
                            <li><a data-toggle="tab" href="#tabs_02"><i class="fa fa-shopping-bag"></i> Products</a>
                            </li>
                            <li><a data-toggle="tab" href="#tabs_03"><i class="fa fa-shopping-cart"></i>
                                    Shops</a></li>
                            <li><a data-toggle="tab" href="#tabs_04"><i class="fa fa-user"></i> Buyer Signups</a></li>
                            <li><a data-toggle="tab" href="#tabs_05"><i class="fa fa-user"></i> Latest Orders</a></li>
                            <li><a data-toggle="tab" href="#tabs_06"><i class="fa fa-user"></i> Latest Messages</a></li>
                            <li><a data-toggle="tab" href="#tabs_07"><i class="fa fa-user"></i> Latest Negotiables</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="tabs_01" class="tab-pane fade in active">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th width="2%"></th>
                                        <th>Today</th>
                                        <th>This Week</th>
                                        <th>This Month</th>
                                        <th>Last 3 Months</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th width="20%">Buyer Registered</th>
                                        <td>{{ $customer_today }}</td>
                                        <td>{{ $customer_week }}</td>
                                        <td>{{ $customer_month }}</td>
                                        <td>{{ $customer_three_month }}</td>
                                        <td>{{ $customers }}</td>
                                    </tr>
                                    <tr>
                                        <th>Products Published</th>
                                        <td>{{ $product_today }}</td>
                                        <td>{{ $product_week }}</td>
                                        <td>{{ $product_month }}</td>
                                        <td>{{ $product_three_month }}</td>
                                        <td>{{ $products_count }}</td>
                                    </tr>
                                    <tr>
                                        <th>Number of Shops</th>
                                        <td>{{ $vendor_today }}</td>
                                        <td>{{ $vendor_week }}</td>
                                        <td>{{ $vendor_month }}</td>
                                        <td>{{ $vendor_three_month }}</td>
                                        <td>{{ $vendor_count }}</td>
                                    </tr>
                                    <tr>
                                        <th>Orders Placed Count</th>
                                        <td>{{ $order_today }}</td>
                                        <td>{{ $order_week }}</td>
                                        <td>{{ $order_month }}</td>
                                        <td>{{ $order_three_month }}</td>
                                        <td>{{ $order_count }}</td>
                                    </tr>
                                    <tr>
                                        <th>Orders Placed Value</th>
                                        <td>Rs. {{ number_format($totalordervalue_today, 2) }}</td>
                                        <td>Rs. {{ number_format($totalordervalue_week, 2) }}</td>
                                        <td>Rs. {{ number_format($totalordervalue_month, 2) }}</td>
                                        <td>Rs. {{ number_format($totalordervalue_three_month, 2) }}</td>
                                        <td>Rs. {{ number_format($totalordervalue, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sales</th>
                                        <td>{{ $sale_today }}</td>
                                        <td>{{ $sale_week }}</td>
                                        <td>{{ $sale_month }}</td>
                                        <td>{{ $sale_three_month }}</td>
                                        <td>{{ $sale_count }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sales Earnings (Excl. taxes)</th>
                                        <td>Rs. {{ $totalsalevalue_today }}</td>
                                        <td>Rs. {{ $totalsalevalue_week }}</td>
                                        <td>Rs. {{ $totalsalevalue_month }}</td>
                                        <td>Rs. {{ $totalsalevalue_three_month }}</td>
                                        <td>Rs. {{ $totalsalevalue }}</td>
                                    </tr>
                                    <tr>
                                        <th>Withdrawal Requests</th>
                                        <td>{{ $withdraw_request_today }}</td>
                                        <td>{{ $withdraw_request_week }}</td>
                                        <td>{{ $withdraw_request_month }}</td>
                                        <td>{{ $withdraw_request_three_month }}</td>
                                        <td>{{ $withdraw_request }}</td>
                                    </tr>
                                    <tr>
                                        <th>Product Reviews</th>
                                        <td>{{ $product_review_today }}</td>
                                        <td>{{ $product_review_week }}</td>
                                        <td>{{ $product_review_month }}</td>
                                        <td>{{ $product_review_three_month }}</td>
                                        <td>{{ $product_review }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="tabs_02" class="tab-pane fade">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th width="2%">#</th>
                                        <th width="25%">Name</th>
                                        <th width="15%">Brand</th>
                                        <th width="15%">Shop</th>
                                        <th width="10">Available</th>
                                        <th width="20%">Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><a href="">{{ $product->name }}</a></td>
                                            <td>{{ $product->brand->name }}</td>
                                            <td>{{ isset(\App\Model\Vendor::where('user_id',$product->user_id)->first()->name) ? \App\Model\Vendor::where('user_id',$product->user_id)->first()->name : 'N/A' }}</td>
                                            <td>{{ $product->stock_quantity }}</td>
                                            <td nowrap="nowrap">${{ number_format($product->sale_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div id="tabs_03" class="tab-pane fade">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th width="12%">Shop Owner</th>
                                        <th width="12%">Name</th>
                                        <th width="15%">Created On</th>
                                        <th width="15%">Verified</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($vendors as $vendor)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $vendor->user_name }}</td>
                                            <td>{{ isset(\App\Model\Vendor::where('user_id',$vendor->user_id)->first()->name) ? \App\Model\Vendor::where('user_id',$vendor->user_id)->first()->name : 'N/A' }}</td>
                                            <td>{{ $vendor->created_at }}</td>
                                            <td>@if($vendor->verified == 1) <span
                                                        class="label label-success"> Verified</span> @else <span
                                                        class="label label-danger"> Not Verified</span> @endif </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div id="tabs_04" class="tab-pane fade">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th width="12%">Username</th>
                                        <th width="15%">Email</th>
                                        <th width="15%">Phone</th>
                                        <th width="15%">Added On</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($users))
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->user_name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ $user->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            <div id="tabs_05" class="tab-pane fade">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th width="10%">Status</th>
                                        <th width="15%">Order</th>
                                        <th width="15%">Product Name</th>
                                        <th width="10%">Price</th>
                                        <th width="5%">Qty</th>
                                        <th width="15%">Address</th>
                                        <th width="15%">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($latest_orders))
                                        @foreach($latest_orders as $order)
                                        @if(isset($order->user))
                                        @if(isset($order->orderProduct->first()->products->name))
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <span class="label label-{{ getOrderStatusClass($order->orderStatus->name) }}">{{ $order->orderStatus->name }}</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.order.edit', $order->id) }}">#{{ $order->id }}</a>
                                                    by <a href="">{{ $order->user->first }}</a><br> <a
                                                            href="">{{ $order->user->email }}</a></td>
                                                <td><a href="">{{ $order->orderProduct->first()->products->name }}</a></td>
                                                <td>{{ $order->orderProduct->first()->price }}</td>
                                                <td>{{ $order->orderProduct->first()->qty }}</td>
                                                <td>
                                                    <a href="">{{ $order->user->addresses->first()->first_name . ' ' . $order->user->addresses->first()->last_name }}
                                                        <br>{{ $order->user->addresses->first()->landmark }}
                                                        <br> {{ $order->user->addresses->first()->street_name }}
                                                        <br> {{ $order->user->addresses->first()->city }}</a></td>
                                                <td>{{ $order->orderProduct->first()->price * $order->orderProduct->first()->qty }}</td>
                                            </tr>
                                            @endif
                                            @endisset
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            <div id="tabs_06" class="tab-pane fade">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th width="12%">Name</th>
                                        <th width="15%">Email</th>
                                        <th width="15%">Phone</th>
                                        <th width="15%">Subject</th>
                                        <th width="5%">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($latest_messages))
                                        @foreach($latest_messages as $message)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $message->name }}</td>
                                                <td>{{ $message->email }}</td>
                                                <td>{{ $message->phone }}</td>
                                                <td>{{ $message->subject }}</td>
                                                <td>
                                                    @if($message->status == 1)
                                                        <span class="label label-warning">Seen</span>
                                                    @else
                                                        <span class="label label-danger">Unseen</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            <div id="tabs_07" class="tab-pane fade">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th width="15%">Product Name</th>
                                        <th width="10%">Buyer</th>
                                        <th width="10%">Seller</th>
                                        <th width="10%">Sale Price</th>
                                        <th width="10%">Negotiable Price</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($latest_negotiables))
                                        @foreach($latest_negotiables as $negotiable)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $negotiable->product->name }}</td>
                                                <td>{{ $negotiable->user->user_name }}</td>
                                                <td>{{ $negotiable->product->users->user_name }}</td>
                                                <td>{{ $negotiable->product->sale_price }}</td>
                                                <td>
                                                    @if($negotiable->fixed_price == null)
                                                        <span class="price" style="color: #ccc">
												yet not fixed
											</span>
                                                    @else
                                                        <span>
                                                {{ $negotiable->fixed_price }}
                                            </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-default btnMenu request"
                                                       href="{{ route('admin.negotiable.details',$negotiable->id) }}">Negotiate</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        google.load("visualization", "1", {packages: ["corechart"]});
        google.setOnLoadCallback(drawCharts);

        function drawCharts() {

            // BEGIN BAR CHART
            /*
             // create zero data so the bars will 'grow'
             var barZeroData = google.visualization.arrayToDataTable([
             ['Day', 'Page Views', 'Unique Views'],
             ['Sun',  0,      0],
             ['Mon',  0,      0],
             ['Tue',  0,      0],
             ['Wed',  0,      0],
             ['Thu',  0,      0],
             ['Fri',  0,      0],
             ['Sat',  0,      0]
             ]);
             */
            // actual bar chart data

                <?php


                //                $product1 =   \App\Model\Product::whereBetween('created_at',[date("Y")."-01-01"." 00:00:00",date("Y")."-02-01."." 00:00:00"])->count();
                //                $product2 =   \App\Model\Product::whereBetween('created_at',[date("Y")."-02-01"." 00:00:00",date("Y")."-03-01."." 00:00:00"])->count();
                //                $product3 =   \App\Model\Product::whereBetween('created_at',[date("Y")."-03-01"." 00:00:00",date("Y")."-04-01."." 00:00:00"])->count();
                //                $product4 =   \App\Model\Product::whereBetween('created_at',[date("Y")."-04-01"." 00:00:00",date("Y")."-05-01."." 00:00:00"])->count();
                //                $product5 =   \App\Model\Product::whereBetween('created_at',[date("Y")."-05-01"." 00:00:00",date("Y")."-06-01."." 00:00:00"])->count();
                //                $product6 =   \App\Model\Product::whereBetween('created_at',[date("Y")."-06-01"." 00:00:00",date("Y")."-07-01."." 00:00:00"])->count();
                //                $product7 =   \App\Model\Product::whereBetween('created_at',[date("Y")."-07-01"." 00:00:00",date("Y")."-08-01."." 00:00:00"])->count();
                //                $product8 =   \App\Model\Product::whereBetween('created_at',[date("Y")."-08-01"." 00:00:00",date("Y")."-09-01."." 00:00:00"])->count();
                //                $product9 =   \App\Model\Product::whereBetween('created_at',[date("Y")."-09-01"." 00:00:00",date("Y")."-010-01."." 00:00:00"])->count();
                //                $product10 =   \App\Model\Product::whereBetween('created_at',[date("Y")."-010-01"." 00:00:00",date("Y")."-11-01."." 00:00:00"])->count();
                //                $product11 =   \App\Model\Product::whereBetween('created_at',[date("Y")."-011-01"." 00:00:00",date("Y")."-12-01."." 00:00:00"])->count();
                //                $product12 =   \App\Model\Product::whereBetween('created_at',[date("Y")."-012-01"." 00:00:00",date("Y")."-12-31."." 23:59:59"])->count();



                //vendor by month
                $vendors1 = \App\User::whereHas('roles', function ($q) {
                    $q->where('name', 'vendor')->whereBetween('created_at', [date("Y") . "-01-01" . " 00:00:00", date("Y") . "-02-01." . " 00:00:00"]);
                })->get()->count();

                $vendors2 = \App\User::whereHas('roles', function ($q) {
                    $q->where('name', 'vendor')->whereBetween('created_at', [date("Y") . "-02-01" . " 00:00:00", date("Y") . "-03-01." . " 00:00:00"]);
                })->get()->count();

                $vendors3 = \App\User::whereHas('roles', function ($q) {
                    $q->where('name', 'vendor')->whereBetween('created_at', [date("Y") . "-03-01" . " 00:00:00", date("Y") . "-4-01." . " 00:00:00"]);
                })->get()->count();

                $vendors4 = \App\User::whereHas('roles', function ($q) {
                    $q->where('name', 'vendor')->whereBetween('created_at', [date("Y") . "-04-01" . " 00:00:00", date("Y") . "-05-01." . " 00:00:00"]);
                })->get()->count();

                $vendors5 = \App\User::whereHas('roles', function ($q) {
                    $q->where('name', 'vendor')->whereBetween('created_at', [date("Y") . "-05-01" . " 00:00:00", date("Y") . "-06-01." . " 00:00:00"]);
                })->get()->count();

                $vendors6 = \App\User::whereHas('roles', function ($q) {
                    $q->where('name', 'vendor')->whereBetween('created_at', [date("Y") . "-06-01" . " 00:00:00", date("Y") . "-07-01." . " 00:00:00"]);
                })->get()->count();

                $vendors7 = \App\User::whereHas('roles', function ($q) {
                    $q->where('name', 'vendor')->whereBetween('created_at', [date("Y") . "-07-01" . " 00:00:00", date("Y") . "-08-01." . " 00:00:00"]);
                })->get()->count();

                $vendors8 = \App\User::whereHas('roles', function ($q) {
                    $q->where('name', 'vendor')->whereBetween('created_at', [date("Y") . "-08-01" . " 00:00:00", date("Y") . "-09-01." . " 00:00:00"]);
                })->get()->count();

                $vendors9 = \App\User::whereHas('roles', function ($q) {
                    $q->where('name', 'vendor')->whereBetween('created_at', [date("Y") . "-09-01" . " 00:00:00", date("Y") . "-10-01." . " 00:00:00"]);
                })->get()->count();

                $vendors10 = \App\User::whereHas('roles', function ($q) {
                    $q->where('name', 'vendor')->whereBetween('created_at', [date("Y") . "-010-01" . " 00:00:00", date("Y") . "-11-01." . " 00:00:00"]);
                })->get()->count();

                $vendors11 = \App\User::whereHas('roles', function ($q) {
                    $q->where('name', 'vendor')->whereBetween('created_at', [date("Y") . "-011-01" . " 00:00:00", date("Y") . "-12-01." . " 00:00:00"]);
                })->get()->count();

                $vendors12 = \App\User::whereHas('roles', function ($q) {
                    $q->where('name', 'vendor')->whereBetween('created_at', [date("Y") . "-12-01" . " 00:00:00", date("Y") . "-12-01." . " 00:00:00"]);
                })->get()->count();

                //User count By Month
                $alluser1 = \App\User::whereBetween('created_at', [date("Y") . "-01-01" . " 00:00:00", date("Y") . "-02-01." . " 00:00:00"])->count();
                $alluser2 = \App\User::whereBetween('created_at', [date("Y") . "-02-01" . " 00:00:00", date("Y") . "-03-01." . " 00:00:00"])->count();
                $alluser3 = \App\User::whereBetween('created_at', [date("Y") . "-03-01" . " 00:00:00", date("Y") . "-04-01." . " 00:00:00"])->count();
                $alluser4 = \App\User::whereBetween('created_at', [date("Y") . "-04-01" . " 00:00:00", date("Y") . "-05-01." . " 00:00:00"])->count();
                $alluser5 = \App\User::whereBetween('created_at', [date("Y") . "-05-01" . " 00:00:00", date("Y") . "-06-01." . " 00:00:00"])->count();
                $alluser6 = \App\User::whereBetween('created_at', [date("Y") . "-06-01" . " 00:00:00", date("Y") . "-07-01." . " 00:00:00"])->count();
                $alluser7 = \App\User::whereBetween('created_at', [date("Y") . "-07-01" . " 00:00:00", date("Y") . "-08-01." . " 00:00:00"])->count();
                $alluser8 = \App\User::whereBetween('created_at', [date("Y") . "-08-01" . " 00:00:00", date("Y") . "-09-01." . " 00:00:00"])->count();
                $alluser9 = \App\User::whereBetween('created_at', [date("Y") . "-09-01" . " 00:00:00", date("Y") . "-010-01." . " 00:00:00"])->count();
                $alluser10 = \App\User::whereBetween('created_at', [date("Y") . "-010-01" . " 00:00:00", date("Y") . "-11-01." . " 00:00:00"])->count();
                $alluser11 = \App\User::whereBetween('created_at', [date("Y") . "-011-01" . " 00:00:00", date("Y") . "-12-01." . " 00:00:00"])->count();
                $alluser12 = \App\User::whereBetween('created_at', [date("Y") . "-012-01" . " 00:00:00", date("Y") . "-12-31." . " 23:59:59"])->count();


                //Order count By Month
                $allorder1 = \App\User::whereBetween('created_at', [date("Y") . "-01-01" . " 00:00:00", date("Y") . "-02-01." . " 00:00:00"])->count();
                $allorder2 = \App\User::whereBetween('created_at', [date("Y") . "-02-01" . " 00:00:00", date("Y") . "-03-01." . " 00:00:00"])->count();
                $allorder3 = \App\User::whereBetween('created_at', [date("Y") . "-03-01" . " 00:00:00", date("Y") . "-04-01." . " 00:00:00"])->count();
                $allorder4 = \App\User::whereBetween('created_at', [date("Y") . "-04-01" . " 00:00:00", date("Y") . "-05-01." . " 00:00:00"])->count();
                $allorder5 = \App\User::whereBetween('created_at', [date("Y") . "-05-01" . " 00:00:00", date("Y") . "-06-01." . " 00:00:00"])->count();
                $allorder6 = \App\User::whereBetween('created_at', [date("Y") . "-06-01" . " 00:00:00", date("Y") . "-07-01." . " 00:00:00"])->count();
                $allorder7 = \App\User::whereBetween('created_at', [date("Y") . "-07-01" . " 00:00:00", date("Y") . "-08-01." . " 00:00:00"])->count();
                $allorder8 = \App\User::whereBetween('created_at', [date("Y") . "-08-01" . " 00:00:00", date("Y") . "-09-01." . " 00:00:00"])->count();
                $allorder9 = \App\User::whereBetween('created_at', [date("Y") . "-09-01" . " 00:00:00", date("Y") . "-010-01." . " 00:00:00"])->count();
                $allorder10 = \App\User::whereBetween('created_at', [date("Y") . "-010-01" . " 00:00:00", date("Y") . "-11-01." . " 00:00:00"])->count();
                $allorder11 = \App\User::whereBetween('created_at', [date("Y") . "-011-01" . " 00:00:00", date("Y") . "-12-01." . " 00:00:00"])->count();
                $allorder12 = \App\User::whereBetween('created_at', [date("Y") . "-012-01" . " 00:00:00", date("Y") . "-12-31." . " 23:59:59"])->count();


                ?>
            var barData = google.visualization.arrayToDataTable([
                    ['Month', 'Total User', 'Total Vendor', 'Total Order'],
                    ['January',  <?php echo $alluser1; ?>,      <?php echo $vendors1; ?>,       <?php echo $allorder1; ?>],
                    ['Febuary',  <?php echo $alluser2; ?>,      <?php echo $vendors2; ?>,       <?php echo $allorder2; ?>],
                    ['March',  <?php echo $alluser3; ?>,      <?php echo $vendors3; ?>,       <?php echo $allorder4; ?>],
                    ['April',  <?php echo $alluser4; ?>,      <?php echo $vendors4; ?>,       <?php echo $allorder4; ?>],
                    ['May',  <?php echo $alluser5; ?>,      <?php echo $vendors5; ?>,       <?php echo $allorder5; ?>],
                    ['June',  <?php echo $alluser6; ?>,      <?php echo $vendors6; ?>,     <?php echo $allorder6; ?>],
                    ['July',  <?php echo $alluser7; ?>,      <?php echo $vendors7; ?>,       <?php echo $allorder7; ?>],
                    ['August',  <?php echo $alluser8; ?>,      <?php echo $vendors8; ?>,       <?php echo $allorder8; ?>],
                    ['September',  <?php echo $alluser9; ?>,      <?php echo $vendors9; ?>,       <?php echo $allorder9; ?>],
                    ['October',  <?php echo $alluser10; ?>,      <?php echo $vendors10; ?>,     <?php echo $allorder10; ?>],
                    ['November',  <?php echo $alluser11; ?>,      <?php echo $vendors11; ?>,        <?php echo $allorder11; ?>],
                    ['December',  <?php echo $alluser12; ?>,      <?php echo $vendors12; ?>,        <?php echo $allorder12; ?>],
                ]);
            // set bar chart options
            var barOptions = {
                focusTarget: 'category',
                backgroundColor: 'transparent',
                colors: ['cornflowerblue', 'tomato', 'orange'],
                fontName: 'Open Sans',
                chartArea: {
                    left: 50,
                    top: 10,
                    width: '100%',
                    height: '70%'
                },
                bar: {
                    groupWidth: '80%'
                },
                hAxis: {
                    textStyle: {
                        fontSize: 11
                    }
                },
                vAxis: {
                    minValue: 10,
                    maxValue: 10,
                    baselineColor: '#DDD',
                    gridlines: {
                        color: '#DDD',
                        count: 4
                    },
                    textStyle: {
                        fontSize: 11
                    }
                },
                legend: {
                    position: 'bottom',
                    textStyle: {
                        fontSize: 12
                    }
                },
                animation: {
                    duration: 1200,
                    easing: 'out',
                    startup: true
                }
            };
            // draw bar chart twice so it animates
            var barChart = new google.visualization.ColumnChart(document.getElementById('bar-chart'));
            //barChart.draw(barZeroData, barOptions);
            barChart.draw(barData, barOptions);


            // pie chart data
            var pieData = google.visualization.arrayToDataTable([
                ['Order', 'Status'],
                ['Pending',     <?php echo $pendingCount; ?>],
                ['Approve',   <?php echo $approvedCount; ?>],
                ['Received',    <?php echo $receivedCount; ?>],
                ['Canceled',  <?php echo $cancelledCount; ?>]
            ]);
            // pie chart options
            var pieOptions = {
                backgroundColor: 'transparent',
                pieHole: 0.4,
                colors: ["cornflowerblue",
                    "olivedrab",
                    "orange",
                    "tomato"],
                pieSliceText: 'value',
                tooltip: {
                    text: 'percentage'
                },
                fontName: 'Open Sans',
                chartArea: {
                    width: '100%',
                    height: '94%'
                },
                legend: {
                    textStyle: {
                        fontSize: 13
                    }
                }
            };
            // draw pie chart
            var pieChart = new google.visualization.PieChart(document.getElementById('pie-chart'));
            pieChart.draw(pieData, pieOptions);


        }


        $(function () {

            Morris.Line({
                element: 'morris-area-chart',
                data: [{
                    period: "<?php echo date("Y"); ?>-1",
                    TotalOrder: "<?php echo \App\Model\Order::whereBetween('created_at', [date("Y") . "-01-01" . " 00:00:00", date("Y") . "-02-01." . " 00:00:00"])->count() ?>",
                    DeliveredOrder: "<?php echo \App\Model\Order::where('order_status_id', 4)->whereBetween('created_at', [date("Y") . "-01-01" . " 00:00:00", date("Y") . "-02-01." . " 00:00:00"])->count() ?>",

                }, {
                    period: "<?php echo date("Y"); ?>-2",
                    TotalOrder: "<?php echo \App\Model\Order::whereBetween('created_at', [date("Y") . "-02-01" . " 00:00:00", date("Y") . "-03-01." . " 00:00:00"])->count() ?>",
                    DeliveredOrder: "<?php echo \App\Model\Order::where('order_status_id', 4)->whereBetween('created_at', [date("Y") . "-02-01" . " 00:00:00", date("Y") . "-03-01." . " 00:00:00"])->count() ?>",

                }, {
                    period: "<?php echo date("Y"); ?>-3",
                    TotalOrder: "<?php echo \App\Model\Order::whereBetween('created_at', [date("Y") . "-03-01" . " 00:00:00", date("Y") . "-04-01." . " 00:00:00"])->count() ?>",
                    DeliveredOrder: "<?php echo \App\Model\Order::where('order_status_id', 4)->whereBetween('created_at', [date("Y") . "-03-01" . " 00:00:00", date("Y") . "-04-01." . " 00:00:00"])->count() ?>",

                }, {
                    period: "<?php echo date("Y"); ?>-4",
                    TotalOrder: "<?php echo \App\Model\Order::whereBetween('created_at', [date("Y") . "-04-01" . " 00:00:00", date("Y") . "-05-01." . " 00:00:00"])->count() ?>",
                    DeliveredOrder: "<?php echo \App\Model\Order::where('order_status_id', 4)->whereBetween('created_at', [date("Y") . "-04-01" . " 00:00:00", date("Y") . "-05-01." . " 00:00:00"])->count() ?>",

                }, {
                    period: "<?php echo date("Y"); ?>-5",
                    TotalOrder: "<?php echo \App\Model\Order::whereBetween('created_at', [date("Y") . "-05-01" . " 00:00:00", date("Y") . "-06-01." . " 00:00:00"])->count() ?>",
                    DeliveredOrder: "<?php echo \App\Model\Order::where('order_status_id', 4)->whereBetween('created_at', [date("Y") . "-05-01" . " 00:00:00", date("Y") . "-06-01." . " 00:00:00"])->count() ?>",

                }, {
                    period: "<?php echo date("Y"); ?>-6",
                    TotalOrder: "<?php echo \App\Model\Order::whereBetween('created_at', [date("Y") . "-06-01" . " 00:00:00", date("Y") . "-07-01." . " 00:00:00"])->count() ?>",
                    DeliveredOrder: "<?php echo \App\Model\Order::where('order_status_id', 4)->whereBetween('created_at', [date("Y") . "-06-01" . " 00:00:00", date("Y") . "-07-01." . " 00:00:00"])->count() ?>",

                }, {
                    period: "<?php echo date("Y"); ?>-7",
                    TotalOrder: "<?php echo \App\Model\Order::whereBetween('created_at', [date("Y") . "-07-01" . " 00:00:00", date("Y") . "-08-01." . " 00:00:00"])->count() ?>",
                    DeliveredOrder: "<?php echo \App\Model\Order::where('order_status_id', 4)->whereBetween('created_at', [date("Y") . "-07-01" . " 00:00:00", date("Y") . "-08-01." . " 00:00:00"])->count() ?>",

                }, {
                    period: "<?php echo date("Y"); ?>-8",
                    TotalOrder: "<?php echo \App\Model\Order::whereBetween('created_at', [date("Y") . "-08-01" . " 00:00:00", date("Y") . "-09-01." . " 00:00:00"])->count() ?>",
                    DeliveredOrder: "<?php echo \App\Model\Order::where('order_status_id', 4)->whereBetween('created_at', [date("Y") . "-08-01" . " 00:00:00", date("Y") . "-09-01." . " 00:00:00"])->count() ?>",

                }, {
                    period: "<?php echo date("Y"); ?>-9",
                    TotalOrder: "<?php echo \App\Model\Order::whereBetween('created_at', [date("Y") . "-09-01" . " 00:00:00", date("Y") . "-10-01." . " 00:00:00"])->count() ?>",
                    DeliveredOrder: "<?php echo \App\Model\Order::where('order_status_id', 4)->whereBetween('created_at', [date("Y") . "-09-01" . " 00:00:00", date("Y") . "-10-01." . " 00:00:00"])->count() ?>",

                }, {
                    period: "<?php echo date("Y"); ?>-10",
                    TotalOrder: "<?php echo \App\Model\Order::whereBetween('created_at', [date("Y") . "-10-01" . " 00:00:00", date("Y") . "-11-01." . " 00:00:00"])->count() ?>",
                    DeliveredOrder: "<?php echo \App\Model\Order::where('order_status_id', 4)->whereBetween('created_at', [date("Y") . "-10-01" . " 00:00:00", date("Y") . "-11-01." . " 00:00:00"])->count() ?>",

                }, {
                    period: "<?php echo date("Y"); ?>-11",
                    TotalOrder: "<?php echo \App\Model\Order::whereBetween('created_at', [date("Y") . "-11-01" . " 00:00:00", date("Y") . "-12-01." . " 00:00:00"])->count() ?>",
                    DeliveredOrder: "<?php echo \App\Model\Order::where('order_status_id', 4)->whereBetween('created_at', [date("Y") . "-11-01" . " 00:00:00", date("Y") . "-12-01." . " 00:00:00"])->count() ?>",

                }, {
                    period: "<?php echo date("Y"); ?>-12",
                    TotalOrder: "<?php echo \App\Model\Order::whereBetween('created_at', [date("Y") . "-12-01" . " 00:00:00", date("Y") . "-12-31." . " 23:59:59"])->count() ?>",
                    DeliveredOrder: "<?php echo \App\Model\Order::where('order_status_id', 4)->whereBetween('created_at', [date("Y") . "-12-01" . " 00:00:00", date("Y") . "-12-31." . " 23:59:59"])->count() ?>",

                }],
                xkey: 'period',
                ykeys: ['TotalProduct', 'DeliveredOrder'],
                labels: ['Total Product', 'DeliveredOrder'],
                pointSize: 2,
                hideHover: 'auto',
                resize: true,
                xLabelAngle: 70,
                lineColors: ['#6b8e23', '#6495ed'],
                events: ['<?php echo date("Y"); ?>'],
                xLabelFormat: function (x) {
                    var IndexToMonth = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    var month = IndexToMonth[x.getMonth()];
                    var year = x.getFullYear();
                    return year + ' ' + month;
                },
                dateFormat: function (x) {
                    var IndexToMonth = ["January", "Febuary", "March", "April", "May", "June", "Juli", "August", "September", "October", "November", "December"];
                    var month = IndexToMonth[new Date(x).getMonth()];
                    var year = new Date(x).getFullYear();
                    return month + ' ' + year;
                },

            });


        });
    </script>
@endpush