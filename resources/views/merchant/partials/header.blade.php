<nav class="navbar navbar-default navbar-static-top" role="navigation" style="background:#6C7A89;margin-bottom: 0;">

<div class="navbar-header">
    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="fa fa-bars bars"></span>
    </button>
    <span class="dashboard__name">
       <a class="navbar-brand" href="{{ route('vendor.dashboard') }}"><i class="fas fa-home"></i> Home</a>
    </span>
</div>
<!-- /.navbar-header-->
<ul class="nav navbar-top-links navbar-right" style="margin-top: 0">

    <!-- /.dropdown-->
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-user fa-fw"></i> {{ Auth::user()->user_name }} <i class="fa fa-caret-down"></i></a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="{{ route('vendor.profile', auth()->id()) }}"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
            <li><a href="{{ route('vendor.config') }}"><i class="fas fa-cogs fa-fw"></i> Settings</a></li>
            <li class="divider"></li>
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="post">
                    {{ csrf_field() }}
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt fa-fw"></i> Logout</a>
            </li>
        </ul>
        <!-- /.dropdown-user-->
    </li>
    <!-- /.dropdown-->
</ul>
<!-- /.navbar-top-links-->
</nav>
        
       
    