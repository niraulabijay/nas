@extends('admin.layouts.app')
@section('title', 'User Details')

@section('content')

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <h3>User Profile</h3>
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="content__box content__box--shadow">
                        <img class="img-responsive img-circle"
                             src="{{ null !== $user->getImage() ? optional($user->getImage())->smallUrl : url('/uploads/avatar.jpg') }}"
                             alt="User profile picture">

                        <h3 class="profile-username text-center">{{ $user->user_name }}</h3>

                        <p class="text-muted text-center">
                            {{ optional($user->roles->first())->display_name }}
                        </p>
                </div>
                <!-- /.box -->
                <h5>Total Orders of {{ $user->user_name }}: {{ $user->orders->count() }}</h5>
                <h5>Pending Orders: {{ App\Model\Order::where('user_id', $user->id)->where('order_status_id', 1)->count() }}</h5>
                <h5>Review Orders: {{ App\Model\Order::where('user_id', $user->id)->where('order_status_id', 6)->count() }}</h5>
                <h5>Approved Orders: {{ App\Model\Order::where('user_id', $user->id)->where('order_status_id', 2)->count() }}</h5>
                <h5>Received Orders: {{ App\Model\Order::where('user_id', $user->id)->where('order_status_id', 3)->count() }}</h5>
                <h5>Delivered Orders: {{ App\Model\Order::where('user_id', $user->id)->where('order_status_id', 4)->count() }}</h5>
                <h5>Cancelled Orders: {{ App\Model\Order::where('user_id', $user->id)->where('order_status_id', 5)->count() }}</h5>

            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="content__box content__box--shadow">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#settings" data-toggle="tab">Info</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="settings">
                            <ul class="list-group">
                                <li class="list-group-item"><strong>User Name: </strong>{{ $user->user_name }}</li>
                                <li class="list-group-item"><strong>Email: </strong>{{ $user->email }}</li>
                                <li class="list-group-item"><strong>Phone: </strong>{{ $user->phone }}</li>
                            </ul>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->

@endsection