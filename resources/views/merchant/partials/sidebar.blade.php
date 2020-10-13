<div class="navbar-default sidebar"  id="vendor-sidebar-wrap" role="navigation" style="margin-top: 0;">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-title"><i class="fas fa-tachometer-alt fa-fw"></i> Dashboard</li>


            <li><a href="javascript:void(0)"><i class="fab fa-product-hunt fa-fw"></i> Products<span class="fas fa-angle-down arrow"></span></a>
                <ul class="nav nav-second-level ">
                    <li><a href="{{ route('vendor.products.table', 'status='.'all') }}" class="allProducts"><i class="fa fa-eye"></i> All Products</a></li>
                    <li><a href="{{ route('vendor.products.create') }}" class="addProduct"><i class="fa fa-plus"></i> Add Product</a></li>
                </ul>
                <!-- /.nav-second-level-->
            </li>
            <!--<li><a href="{{ route('vendor.brands.index') }}"><i class="fa fa-bars fa-fw"></i> Brands</a>-->
            <!--</li>-->
            <li><a href="javascript:void(0)"><i class="fab fa-first-order fa-fw"></i> Orders<span class="fas fa-angle-down arrow"></span></a>
                <ul class="nav nav-second-level ">
                    <li><a href="{{ route('vendor.order.index',  'status='.'all') }}" class="allOrders"><i class="fa fa-eye"></i> All Orders</a></li>
                    <li><a href="{{ route('vendor.order.index', 'status='.'return') }}" class="orderReturn"><i class="fa fa-eye"></i> Order Returns</a></li>
                </ul>
            </li>
            <li><a href="{{ route('vendor.withdraw') }}"><i class="fas fa-money-check"></i> Balance</a>
            </li>         
            <li><a href="{{route('vendor.config')}}"><i class="fas fa-cogs"></i> Settings</a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse-->
</div>
<!-- /.navbar-static-side-->
