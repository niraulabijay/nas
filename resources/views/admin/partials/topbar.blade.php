<section class="category-menu">
    @php($route = Route::currentRouteName())
    <ul class="liststyle--none category-menu__menu-block">
        <li>
            <a href="{{ route('admin.index') }}">DASHBOARD</a>
        </li>
         @role('graphic')
        <li>
            <a href="">PRODUCTS</a>
            <ul class="liststyle--none category-menu__sub-menu-block ">
                <a href="{{ route('admin.products.index', 'status='.'all') }}" class="allProducts"><li> All Products</li></a>
                <a href="{{ route('admin.products.create') }}" class="addProduct"><li> Add Product</li></a>
              
            </ul>
        </li>
       @endrole
                @role(['admin','digital_marketing','content_writer'])
                
      
        <li>
            <a href="">PRODUCTS</a>
            <ul class="liststyle--none category-menu__sub-menu-block ">
                <a href="{{ route('admin.products.index', 'status='.'all') }}" class="allProducts"><li> All Products</li></a>
                <a href="{{ route('admin.products.create') }}" class="addProduct"><li> Add Product</li></a>
              
            </ul>
        </li>
       
        <li>
            <a href="{{ route('admin.category') }}">CATEGORIES</a>
        </li>
        <li><a href="{{ route('admin.brands.index') }}">BRANDS</a></li>
             <li>
            <a href="javascript:void(0)">SETTING</a>
            <ul class="liststyle--none category-menu__sub-menu-block ">
                <a href="{{ route('admin.coupon.index') }}"><li>Coupons</li></a>
                
                @role('admin')
                                <a href="{{ route('admin.commissions.index') }}" class="commissionSettings"><li> Commission Settings</li></a>

                @endrole
            </ul>
        </li>
        <li>
            <a href="javascript:void(0)">Home Products</a>
            <ul class="liststyle--none category-menu__sub-menu-block ">
                <a href="{{ route('admin.deals.index') }}" class="allDeals"><li> All Home Products</li></a>
                <a href="{{ route('admin.deals.create') }}" class="addDeal"><li> Add New Home Product</li></a>
            </ul>
      
             <li>
            <a href="">PAGES</a>
            <ul class="liststyle--none category-menu__sub-menu-block ">
                <a href="{{ route('admin.page.index') }}" class="allDeals"><li> All Pages</li></a>
                <a href="{{ route('admin.page.create') }}" class="addDeal"><li> Add New Page</li></a>
            </ul>
        
        </li>
        <li>
            <a href="javascript:void(0)">TEAM</a>
            <ul class="liststyle--none category-menu__sub-menu-block ">
                <a href="{{ route('admin.teams.index') }}" class="allTeams"><li> All Team Members</li></a>
                <a href="{{ route('admin.teams.create') }}" class="addTeam"><li> Add New Member</li></a>
            </ul>
        </li>

       
        
        <li><a href="{{ route('admin.withdraw') }}">WITHDRAWALS </a></li>
            @endrole
                    @role(['admin','logistics','customer_care'])

            <li>
                <a href="">ORDERS LIST</a>
                <ul class="liststyle--none category-menu__sub-menu-block ">
                <a href="{{ route('admin.order.list', 'status='.'pending') }}" class="allOrders"><li> All Orders</li></a>
                <a href="{{ route('admin.order.return') }}" class="orderReturn"><li> Order Returns</li></a>
            </ul>
            </li>
        <!--<li>-->
        <!--    <a href="">ORDERS</a>-->
        <!--    <ul class="liststyle--none category-menu__sub-menu-block ">-->
        <!--        <a href="{{ route('admin.order.index', 'status='.'all') }}" class="allOrders"><li> All Orders</li></a>-->
        <!--        <a href="{{ route('admin.order.return') }}" class="orderReturn"><li> Order Returns</li></a>-->
        <!--    </ul>-->
        <!--</li>-->
           <li><a href="javascript:void(0)">VENDORS</a>
            <ul class="liststyle--none category-menu__sub-menu-block ">
                <a href="{{ route('admin.vendor.index') }}"><li>Vendor Details</li></a>
               <a href="{{ route('admin.vendor.request') }}"><li>Vendor Request</li></a>
                <a href="{{ route('admin.vendor.reviews.index') }}"><li>Vendor Rating</li></a>
            </ul>
        </li>
        @endrole
        @role('admin')
        <li class="{{ request()->has('role') || $route == 'admin.users.main' || $route == 'admin.users.create' || $route == 'admin.users.edit' ? 'active': null }}">
            <a href="javascript:void(0)">USERS</a>
            <ul class="liststyle--none category-menu__sub-menu-block ">
                <a href="{{ route('admin.users.main', 'role=' . 'admin') }}" class="allAdmins"><li class="{{ request()->has('role') && request('role') === 'admin' ? 'active': null }}"> Administrators</li></a>
                <a href="{{ route('admin.users.main', 'role=' . 'manager') }}" class="allManagers"><li class="{{ request()->has('role') && request('role') === 'manager' ? 'active': null }}"> Managers</li></a>
                <a href="{{ route('admin.users.main', 'role=' . 'vendor') }}" class="allVendors"><li class="{{ request()->has('role') && request('role') === 'vendor' ? 'active': null }}"> Vendors</li></a>
                <a href="{{ route('admin.users.main', 'role=' . 'client') }}" class="allClients"><li class="{{ request()->has('role') && request('role') === 'client' ? 'active': null }}"> Clients</li></a>
                <a href="{{ route('admin.users.main', 'role=' . '') }}" class="allUsers"><li> All Users</li></a>
                <a href="{{ route('admin.users.create') }}" class="addUser"><li> Add New User</li></a>
            </ul>
        </li>
        @endrole
     

        

        <!--<li><a href="{{ route('admin.disputes') }}">DISPUTES</a></li>-->
   
    </ul>
</section>
