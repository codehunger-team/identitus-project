<nav id="sidebar" class="p-4">
    @if(auth()->user()->admin == 1)
    <ul class="list-unstyled components">
        <li class="text-white">ADMIN MENU</li>
        <li @if(isset($active) AND ($active=='dashboard' )) class="active" @endif>
            <a href="{{route('admin.dashboard')}}" class="nav-link text-white"><i class="fa fa-columns font-icon"></i>
                <span class="side-text">Dashboard</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='add-commission' )) class="active" @endif>
            <a href="{{route('admin.add.commission')}}" class="nav-link text-white"><i class="fa fa-calculator"></i>
                <span class="side-text">Add Commission</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='domains' )) class="active" @endif>
            <a href="{{route('admin.domain')}}" class="nav-link text-white"><i class="fa fa-globe"></i>
                <span class="side-text">Domains</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='active-lease' )) class="active" @endif>
            <a href="{{route('admin.active.lease')}}" class="nav-link text-white"><i class="fas fa-rocket"></i>
                <span class="side-text">Active Lease</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='inactive-lease' )) class="active" @endif>
            <a href="{{route('admin.inactive.lease')}}" class="nav-link text-white"><i class="fas fa-meteor"></i>
                <span class="side-text">Inactive Lease</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='categories' )) class="active" @endif>
            <a href="{{route('admin.category')}}" class="nav-link text-white"><i class="fa fa-list"
                    aria-hidden="true"></i>
                <span class="side-text">Categories</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='period' )) class="active" @endif>
            <a href="{{route('admin.period')}}" class="nav-link text-white">
                <i class="fas fa-clock"></i>
                <span class="side-text">Period Types</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='option' )) class="active" @endif>
            <a href="{{route('admin.option')}}" class="nav-link text-white">
                <i class="fas fa-calendar-day"></i>
                <span class="side-text">Option Expiration</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='grace-period' )) class="active" @endif>
            <a href="{{route('admin.grace')}}" class="nav-link text-white">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                <span class="side-text">Grace Period</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='bulk' )) class="active" @endif>
            <a href="{{route('admin.bulk.upload')}}" class="nav-link text-white">
                <i class="fa fa-upload"></i>
                <span class="side-text">Bulk Upload</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='user' )) class="active" @endif>
            <a href="{{route('admin.users')}}" class="nav-link text-white">
                <i class="fas fa-users"></i>
                <span class="side-text">Users</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='docusign' )) class="active" @endif>
            <a href="{{route('admin.docusign')}}" class="nav-link text-white">
                <i class="fas fa-plug"></i>
                <span class="side-text">Connect Docusign</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='customer' )) class="active" @endif>
            <a href="{{route('admin.customer.enquiry')}}" class="nav-link text-white">
                <i class="fas fa-plug"></i>
                <span class="side-text">Customer Enquiry</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='config' )) class="active" @endif>
            <a href="{{route('admin.configuration')}}" class="nav-link text-white">
                <i class="fa fa-cog"></i>
                <span class="side-text">Configuration</span></a>
        </li>
        <li>
            <a href="{{route('admin.logout')}}" class="nav-link text-white">
                <i class="fas fa-sign-out-alt"></i>
                <span class="side-text">Log Out</span>
            </a>
        </li>
    </ul>
    @else
    <!-- Sidebar Menu -->
    <ul class="list-unstyled components">
        <li class="header">User Menu</li>
        <!-- Optionally, you can add icons to the links -->
        <li @if(isset($active) AND ($active=='user' )) class="active" @endif>
            <a href="{{route('user.profile')}}"><i class="fa fa-user"></i> <span class="side-text">Profile</span></a>
        </li>

        <!-- Functions as Lessee/Buyer -->
        <li @if(isset($active) AND ($active=='orders' )) class="active" @endif>
            <a href="{{route('user.orders')}}"><i class="fa fa-shopping-cart "></i> <span
                    class="side-text">Orders</span></a>
        </li>

        <li @if(isset($active) AND ($active=='rental-agreement' )) class="active" @endif>
            <a href="{{route('user.rental.agreement')}}"><i class="fa fa-credit-card" aria-hidden="true"></i> <span
                    class="side-text">Rental Agreements</span></a>
        </li>

        <hr>
        <!-- Functions as Lessor/Seller -->
        @if (Auth::user()->is_vendor == 'yes')
        <li class="header">Seller + Lessor Tools</li>

        <!-- These three menu items need to be user.specific -->
        <li @if(isset($active) AND ($active=='seller-order' )) class="active" @endif>
            <a href="{{route('user.seller.orders')}}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span
                    class="side-text">Orders</span></a>
        </li>
        <li @if(isset($active) AND ($active=='domains' )) class="active" @endif>
            <a href="{{route('user.domains')}}"><i class="fa fa-globe"></i> <span class="side-text">Owned
                    Domains</span></a>
        </li>
        <li @if(isset($active) AND ($active=='active-lease' )) class="active" @endif>
            <a href="{{route('user.active.lease')}}"><i class="fa fa-dollar-sign" aria-hidden="true"></i> <span
                    class="side-text">Active Lease</span></a>
        </li>
        <li @if(isset($active) AND ($active=='inactive-lease' )) class="active" @endif>
            <a href="{{route('user.inactive.lease')}}">
                <i class="fa fa-ban" aria-hidden="true"></i> <span class="side-text">Inactive Lease</span></a>
        </li>
{{--        <li @if(isset($active) AND ($active=='bank-details' )) class="active" @endif>--}}
{{--            <a href="{{route('user.stripe-connect')}}">--}}
{{--                <i class="fa fa-university" aria-hidden="true"></i> <span class="side-text">Connect Stripe</span></a>--}}
{{--        </li>--}}
        @endif
        <li>
            <a href="{{route('user.logout')}}"><i class="fa fa-power-off"></i> <span class="side-text">Log
                    Out</span></a>
        </li>
    </ul><!-- /.sidebar-menu -->
    @endif
</nav>
