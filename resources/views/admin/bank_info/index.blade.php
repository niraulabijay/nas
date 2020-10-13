@extends('admin.layouts.app')
@section('title',"Bank Info")
@section('content')
	<section>
        <div class="content__box content__box--shadow">
            <div class="row">
                <h3>Bank Information</h3>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Total Sales Balance</div>
                            <div class="huge">lllllllllllllll</div>
                        </div>
                        <a href="{{ route('vendor.dashboard.index','all' ) }}">
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
                            <div class="huge">lllllllllllllllll</div>
                        </div>
                        <a href="{{ route('vendor.dashboard.index','approved' ) }}">
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
                            <div class="huge">lllllllllllllllllll</div>
                        </div>
                        <a href="{{ route('vendor.dashboard.index','pending' ) }}">
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
                            <div class="huge">llllllllllllllllllllll</div>
                        </div>
                        <a href="{{ route('vendor.dashboard.index','reviews' ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Last Withdraw</div>
                            <div class="huge">llllllllllllllllllllll</div>
                        </div>
                        <a href="{{ route('vendor.dashboard.index','reviews' ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Last Withdraw</div>
                            <div class="huge">llllllllllllllllllllll</div>
                        </div>
                        <a href="{{ route('vendor.dashboard.index','reviews' ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Last Withdraw</div>
                            <div class="huge">llllllllllllllllllllll</div>
                        </div>
                        <a href="{{ route('vendor.dashboard.index','reviews' ) }}">
                            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel content__box content__box--shadow">
                        <div class="text-center">
                            <div>Last Withdraw</div>
                            <div class="huge">llllllllllllllllllllll</div>
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
@endsection