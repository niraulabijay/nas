<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-title"><i class="fas fa-tachometer-alt"></i> Dashboard</li>
            <li><a href="{{ route('admin.index') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            @role(['admin','digital_marketing','content_writer'])
            <li><a href="javascript:void(0)"><i class="fas fa-list-alt fa-fw"></i> Menu<span class="fas fa-angle-down arrow"></span></a>
                <ul class="nav nav-second-level ">
                    <li><a href="{{ route('admin.menu.index') }}" class="addMenu"><i class="fa fa-eye"></i> Menu</a></li>
                    <li><a href="{{ route('admin.menu.show') }}" class="allMenu"><i class="fa fa-eye"></i> Menulist</a></li>
                </ul>
                <!-- /.nav-second-level-->
            </li>
            <li><a href="{{ route('admin.brands.index') }}"><i class="fa fa-bars"></i> Brands</a></li>
            <li><a href="javascript:void(0)"><i class="fas fa-object-group"></i> Categories<span class="fas fa-angle-down arrow"></span></a>
                <ul class="nav nav-second-level ">
                    <li><a href="{{ route('admin.category') }}" class="allCategories"><i class="fa fa-eye"></i> All Categories</a></li>
                    <li><a href="#" class="addCategory"><i class="fa fa-plus"></i> Add Category</a></li>
                </ul>
                <!-- /.nav-second-level-->
            </li>  
            <li><a href="javascript:void(0)"><i class="fas fa-images"></i> Slideshow<span class="fas fa-angle-down arrow"></span></a>
                <ul class="nav nav-second-level ">
                    <li><a href="{{ route('admin.slideshow.index') }}" class="allSlideshow"><i class="fa fa-eye"></i> All Slideshows</a></li>
                    <li><a href="{{ route('admin.slideshow.create') }}" class="addSlideshow"><i class="fa fa-plus"></i> Add Slideshow</a></li>
                </ul>
                <!-- /.nav-second-level-->
            </li>           
            <li><a href="#"><i class="fas fa-quote-left fa-fw"></i> Testimonials<span class="fas fa-angle-down arrow"></span></a>
                <ul class="nav nav-second-level ">
                    <li><a href="{{ route('admin.testimonials.index') }}"><i class="fa fa-eye"></i> All Testimonials</a></li>
                    <li><a href="{{ route('admin.testimonials.create') }}"><i class="fa fa-plus"></i> Add Testimonial</a></li>
                </ul>
                <!-- /.nav-second-level-->
            </li>
            <li><a href="javascript:void(0)"><i class="fab fa-adversal"></i> Advertisement<span class="fas fa-angle-down arrow"></span></a>
                <ul class="nav nav-second-level ">
                    <li><a href="{{ route('admin.front.ads.create') }}"><i class="fab fa-adversal"></i> Create Ads</a></li>
                    <li><a href="javascript:void(0)"><i class="fa fa-bars"></i> Type<span class="fas fa-angle-down arrow"></span></a>
                        <ul class="nav nav-third-level ">
                            <li><a href="{{ route('admin.type.index') }}" class="allProducts"><i class="fa fa-eye"></i> All Types</a></li>
                            <li><a href="{{ route('admin.type.create') }}" class="addProduct"><i class="fa fa-plus"></i> Add Type</a></li>
                        </ul>
                        <!-- /.nav-second-level-->
                    </li>
                    <li><a href="javascript:void(0)"><i class="fas fa-globe"></i> Area<span class="fas fa-angle-down arrow"></span></a>
                        <ul class="nav nav-third-level ">
                            <li><a href="{{ route('admin.area.index') }}" class="allProducts"><i class="fa fa-eye"></i> All Areas</a></li>
                            <li><a href="{{ route('admin.area.create') }}" class="addProduct"><i class="fa fa-plus"></i> Add Area</a></li>
                        </ul>
                        <!-- /.nav-second-level-->
                    </li>
                    <li><a href="javascript:void(0)"><i class="fas fa-cube"></i> Package<span class="fas fa-angle-down arrow"></span></a>
                        <ul class="nav nav-third-level ">
                            <li><a href="{{ route('admin.package.index') }}" class="allProducts"><i class="fa fa-eye"></i> All Packages</a></li>
                            <li><a href="{{ route('admin.package.create') }}" class="addProduct"><i class="fa fa-plus"></i> Add Package</a></li>
                        </ul>
                        <!-- /.nav-second-level-->
                    </li>
                     <li><a href="/admin/ads"><i class="fab fa-adversal"></i> Request Ads</a></li>
                 </ul>
             </li>
             <li><a href="{{ route('admin.sales-report') }}"><i class="fas fa-file"></i> Sales Report</a></li>
            <li><a href="{{ route('admin.home') }}"><i class="fas fa-cogs"></i> Home Setting</a></li>
            <li><a href="{{ route('admin.settings') }}"><i class="fas fa-cogs"></i> Settings</a></li>
             <li><a href="#"><i class="fas fa-quote-left fa-fw"></i> Seos<span class="fas fa-angle-down arrow"></span></a>
                <ul class="nav nav-second-level ">
                    <li><a href="{{ route('admin.seo.index') }}"><i class="fa fa-eye"></i> All Seos</a></li>
                    <li><a href="{{ route('admin.seo.create') }}"><i class="fa fa-plus"></i> Add Seo</a></li>
                </ul>
                <!-- /.nav-second-level-->
            </li>
                        @endrole
        @role(['admin','customer_care'])

            <li><a href="#"><i class="fas fa-money-bill-alt"></i> Manage Payments<span class="fas fa-angle-down arrow"></span></a>
                <ul class="nav nav-second-level ">
                    <li><a href="{{ route('admin.shipping_amount') }}"><i class="fas fa-truck"></i> Shipping Amount</a></li>
                    <li><a href="{{ route('admin.payment.index') }}"><i class="fas fa-credit-card"></i> Payment Method</a></li>
                    <!--<li><a href="{{ route('admin.delivery.index') }}"><i class="fas fa-truck"></i> Delivery Destination</a></li>-->
                </ul>
                <!-- /.nav-second-level-->
            </li>
            <!--<li><a href="{{ route('admin.negotiate') }}"><i class="fas fa-handshake"></i> Negotiable</a></li>-->
            <li><a href="{{ route('admin.request_product') }}"><i class="fas fa-handshake"></i> Request Products</a></li>           
           @endrole
           @role('admin')
            <li><a href="{{ route('admin.cs.report') }}"><i class="fa fa-bars"></i> CS Report</a></li>
            @endrole
        </ul>
    </div>
    <!-- /.sidebar-collapse-->
</div>
<!-- /.navbar-static-side-->
