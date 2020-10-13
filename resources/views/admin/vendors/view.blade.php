@extends('admin.layouts.app')
@section('title', 'Vendor Stat')

@section('content')
	<section>
		<h3>Vendor({{ $vendor->user_name }}) Stat</h3>
		<div class="content__box content__box--shadow">
            <div class="row">
            	<h5>Products</h5>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>All Products</div>
                            <div class="huge">{{ $products }}</div>
                        </div>
                        <a href="{{ route('admin.vendor.product_stat.index',['vendor', $vendor->id] ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Approved Products</div>
                            <div class="huge">{{ $approved }}</div>
                        </div>
                        <a href="{{ route('admin.vendor.product_stat.index',['approved', $vendor->id] ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Pending Products</div>
                            <div class="huge">{{ $pending }}</div>
                        </div>
                        <a href="{{ route('admin.vendor.product_stat.index',['pending', $vendor->id] ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Reviews</div>
                            <div class="huge">{{ $reviews }}</div>
                        </div>
                        <a href="{{ route('admin.vendor.product_stat.index',['reviews', $vendor->id] ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
	</section>

	<section>
		<div class="content__box content__box--shadow">
            <div class="row">
            	<h5>Orders</h5>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Total Orders</div>
                            <div class="huge">{{ $orders }}</div>
                        </div>
                        <a href="{{ route('admin.vendor.order_stat',['all', $vendor->id] ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Pending Orders</div>
                            <div class="huge">{{ $ordersPending }}</div>
                        </div>
                        <a href="{{ route('admin.vendor.order_stat',['pending', $vendor->id] ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Approved Orders</div>
                            <div class="huge">{{ $ordersApproved }}</div>
                        </div>
                        <a href="{{ route('admin.vendor.order_stat',['approved', $vendor->id] ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Received Orders</div>
                            <div class="huge">{{ $ordersReceived }}</div>
                        </div>
                        <a href="{{ route('admin.vendor.order_stat',['received', $vendor->id] ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Delivered Orders</div>
                            <div class="huge">{{ $ordersDelivered }}</div>
                        </div>
                        <a href="{{ route('admin.vendor.order_stat',['delivered', $vendor->id] ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Cancelled Orders</div>
                            <div class="huge">{{ $ordersCancelled}}</div>
                        </div>
                        <a href="{{ route('admin.vendor.order_stat',['cancelled', $vendor->id] ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Review Orders</div>
                            <div class="huge">{{ $ordersReview}}</div>
                        </div>
                        <a href="{{ route('admin.vendor.order_stat',['review', $vendor->id] ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
	</section>

    <section>
        <div class="content__box content__box--shadow">
            <div class="row">
                <h5>Order Returns</h5>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Total Order Returns</div>
                            <div class="huge">{{ $orderReturns }}</div>
                        </div>
                        <a href="{{ route('admin.vendor.order_return_stat',['all', $vendor->id] ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Pending Order Returns</div>
                            <div class="huge">{{ $orderReturnsPending }}</div>
                        </div>
                        <a href="{{ route('admin.vendor.order_return_stat',['pending', $vendor->id] ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Approved Order Returns </div>
                            <div class="huge">{{ $orderReturnsApproved }}</div>
                        </div>
                        <a href="{{ route('admin.vendor.order_return_stat',['approved', $vendor->id] ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--<section>-->
    <!--    <div class="content__box content__box--shadow">-->
    <!--        <div class="row">-->
    <!--            <h5>Commission</h5>-->
    <!--            <div class="col-lg-3 col-md-6">-->
    <!--                <div class="panel content__box content__box--shadow">-->
    <!--                    <div class="text-center">-->
    <!--                        <div>Vendor Commission</div>-->
    <!--                        <div class="huge">{{ isset($commission)?$commission->commission: 0 }}%</div>-->
    <!--                    </div>-->
    <!--                    <a href="{{ route('admin.commission.edit', $vendor->id ) }}">-->
    <!--                        <div class="panel-footer"><span class="pull-left">{{ isset($commission) ? 'Edit' : 'Add' }}</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>-->
    <!--                            <div class="clearfix"></div>-->
    <!--                        </div>-->
    <!--                    </a>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</section>-->
    
    <section>
        <div class="content__box content__box--shadow">
            <div class="row">
                <h5>Balance Information</h5>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Total Sales Balance</div>
                            <div class="huge">Rs. {{ $total_balance }}</div>
                        </div>
                        <a href="{{ route('admin.order.index' ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Current Balance</div>
                            <div class="huge">Rs. {{ $total_balance - $total_withdraw }}</div>
                        </div>
                        <a href="{{ route('admin.order.index' ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Total Withdraw</div>
                            <div class="huge">Rs. {{ $total_withdraw }}</div>
                        </div>
                        <a href="{{ route('admin.withdraw' ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Last Withdraw</div>
                            <div class="huge">Rs. {{ $last_withdraw ? $last_withdraw->amount : 0 }}</div>
                        </div>
                        <a href="{{ route('admin.withdraw' ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Total Commission</div>
                            <div class="huge">Rs. {{ $total_commission ? $total_commission : 0 }}</div>
                        </div>
                        <a href="{{ route('admin.order.index', 'status='.'all' ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>VAT</div>
                            <div class="huge">Rs. {{ $tax ? $tax : 0 }}</div>
                        </div>
                        <a href="{{ route('admin.order.index', 'status='.'all' ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection