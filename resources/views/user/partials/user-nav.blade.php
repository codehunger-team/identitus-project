<nav id="sidebar">
    <div class="sidebar-header">
        <div class="row">
            <div class="col-sm-6">
                <a href="{{url('/')}}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <h3>Identitius</h3>
                    <strong>I</strong>
                </a>
            </div>
            <div class="col-sm-2 mt-2">
                <a href="javascript:void(0)"><i id="sidebarCollapse" class="fas fa-bars float-right text-white"></i></a>
            </div>
        </div>
    </div>
    <!-- Sidebar Menu -->
    <ul class="list-unstyled components">
        <li class="header">USER MENU</li>
        <!-- Optionally, you can add icons to the links -->
          <li @if(isset($active) AND ($active == 'user')) class="active" @endif>
            <a href="{{route('user.profile')}}"><i class="fa fa-user"></i> <span>Profile</span></a>
          </li>
  
        <!-- Functions as Lessee/Buyer -->
          <li @if(isset($active) AND ($active == 'orders')) class="active" @endif>
            <a href="{{route('user.orders')}}"><i class="fa fa-shopping-cart "></i> <span>Orders</span></a>
          </li>
  
          <li @if(isset($active) AND ($active == 'rental-agreement')) class="active" @endif>
            <a href="{{route('user.rental.agreement')}}"><i class="fa fa-credit-card" aria-hidden="true"></i> <span>Rental Agreements</span></a>
          </li>
          
          <hr>
        <!-- Functions as Lessor/Seller -->
        @if (Auth::user()->is_vendor == 'yes')
        <li class="header">Seller + Lessor Tools</li>
  
        <!-- These three menu items need to be user.specific -->
          <li @if(isset($active) AND ($active == 'seller-order')) class="active" @endif>
            <a href="{{route('user.seller.orders')}}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Orders</span></a>
          </li>
          <li @if(isset($active) AND ($active == 'domains')) class="active" @endif>
            <a href="{{route('user.domains')}}"><i class="fa fa-globe"></i> <span>Owned Domains</span></a>
          </li>
          <li @if(isset($active) AND ($active == 'active-lease')) class="active" @endif>
            <a href="{{route('user.active.lease')}}"><i class="fa fa-dollar-sign" aria-hidden="true"></i> <span>Active Lease</span></a>
          </li>
          <li @if(isset($active) AND ($active == 'inactive-lease')) class="active" @endif>
            <a href="{{route('user.inactive.lease')}}">
              <i class="fa fa-ban" aria-hidden="true"></i> <span>Inactive Lease</span></a>
          </li>
          <li @if(isset($active) AND ($active == 'bank-details')) class="active" @endif>
            <a href="{{route('user.stripe-connect')}}">
              <i class="fa fa-university" aria-hidden="true"></i> <span>Connect Stripe</span></a>
          </li>
        @endif
        <li>
          <a href="{{route('user.logout')}}"><i class="fa fa-power-off"></i> <span>Log Out</span></a>
        </li>
      </ul><!-- /.sidebar-menu -->
</nav>
