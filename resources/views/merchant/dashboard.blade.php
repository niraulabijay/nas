@extends('merchant.layouts.app')

@section('title',"Dashboard")

@section('content')
    <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Dashboard</h3>
            </div>
            <!-- /.col-lg-12-->
        </div>
        <!-- /.row-->
        <div class="content__box content__box--shadow">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3"><i class="fab fa-product-hunt fa-3x"></i></div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ $products }}</div>
                                    <div>Total Products</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('vendor.products.table', 'status='.'all') }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3"><i class="fas fa-money-bill-alt fa-3x"></i></div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ $total_balance }}</div>
                                    <div>Balances</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('vendor.withdraw') }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3"><i class="fas fa-cart-plus fa-3x"></i></div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ $order24->count() }}</div>
                                    <div>Order Last 24 Hour</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('vendor.order.index',  'status='.'all') }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3"><i class="fas fa-cart-plus fa-3x"></i></div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ $order12->count() }}</div>
                                    <div>Order in Last 12 Hour</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('vendor.order.index',  'status='.'all') }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    <section>
        <div class="content__box content__box--shadow">
            <div class="row">
                <h5>Products</h5>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>All Products</div>
                            <div class="huge">{{ $products }}</div>
                        </div>
                        <a href="{{ route('vendor.products.table', 'status='.'all') }}}">
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
                        <a href="{{ route('vendor.products.table', 'status='.'approved') }}">
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
                        <a href="{{ route('vendor.products.table', 'status='.'pending') }}">
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
                        <a href="{{ route('vendor.dashboard.index','reviews' ) }}">
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
                        <a href="{{ route('vendor.order_stat','all' ) }}">
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
                        <a href="{{ route('vendor.order_stat','pending' ) }}">
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
                        <a href="{{ route('vendor.order_stat','approved' ) }}">
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
                        <a href="{{ route('vendor.order_stat','received' ) }}">
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
                        <a href="{{ route('vendor.order_stat','delivered' ) }}">
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
                        <a href="{{ route('vendor.order_stat','cancelled' ) }}">
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
                        <a href="{{ route('vendor.order_stat','review' ) }}">
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
                        <a href="{{ route('vendor.order_return_stat','all' ) }}">
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
                        <a href="{{ route('vendor.order_return_stat','pending' ) }}">
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
                        <a href="{{ route('vendor.order_return_stat','approved' ) }}">
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
        <!-- /#page-wrapper-->
@endsection

@push('scripts')

@endpush