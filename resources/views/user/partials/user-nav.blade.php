<nav id="sidebar" class="sidebar px-4" >

    <!-- Sidebar Menu -->
    <ul class="list-unstyled components">
        <li class="header">USER MENU</li>
        <!-- Optionally, you can add icons to the links -->
          <li @if(isset($active) AND ($active == 'user')) class="active" @endif>
            <a href="{{route('user.profile')}}"><i class="fa fa-user"></i> <span class="side-text">Profile</span></a>
          </li>

        <!-- Functions as Lessee/Buyer -->
          <li @if(isset($active) AND ($active == 'orders')) class="active" @endif>
            <a href="{{route('user.orders')}}"><i class="fa fa-shopping-cart "></i> <span class="side-text">Orders</span></a>
          </li>

          <li @if(isset($active) AND ($active == 'rental-agreement')) class="active" @endif>
            <a href="{{route('user.rental.agreement')}}"><i class="fa fa-credit-card" aria-hidden="true"></i> <span class="side-text">Rental Agreements</span></a>
          </li>

          <hr>
        <!-- Functions as Lessor/Seller -->
        @if (Auth::user()->is_vendor == 'yes')
        <li class="header">Seller + Lessor Tools</li>

        <!-- These three menu items need to be user.specific -->
          <li @if(isset($active) AND ($active == 'seller-order')) class="active" @endif>
            <a href="{{route('user.seller.orders')}}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="side-text">Orders</span></a>
          </li>
          <li @if(isset($active) AND ($active == 'domains')) class="active" @endif>
            <a href="{{route('user.domains')}}"><i class="fa fa-globe"></i> <span class="side-text">Owned Domains</span></a>
          </li>
          <li @if(isset($active) AND ($active == 'active-lease')) class="active" @endif>
            <a href="{{route('user.active.lease')}}"><i class="fa fa-dollar-sign" aria-hidden="true"></i> <span class="side-text">Active Lease</span></a>
          </li>
          <li @if(isset($active) AND ($active == 'inactive-lease')) class="active" @endif>
            <a href="{{route('user.inactive.lease')}}">
              <i class="fa fa-ban" aria-hidden="true"></i> <span class="side-text">Inactive Lease</span></a>
          </li>
          <li @if(isset($active) AND ($active == 'bank-details')) class="active" @endif>
            <a href="{{route('user.stripe-connect')}}">
              <i class="fa fa-university" aria-hidden="true"></i> <span class="side-text">Connect Stripe</span></a>
          </li>
        @endif
        <li>
          <a href="{{route('user.logout')}}"><i class="fa fa-power-off"></i> <span class="side-text">Log Out</span></a>
        </li>
      </ul><!-- /.sidebar-menu -->
</nav>

<style>
    body {
        font-size: .875rem;
    }

    .feather {
        width: 16px;
        height: 16px;
        vertical-align: text-bottom;
    }

    /*
     * Sidebar
     */

    .sidebar {
        position: fixed;
        top: 0;
        /* rtl:raw:
        right: 0;
        */
        bottom: 0;
        /* rtl:remove */
        left: 0;
        z-index: 100; /* Behind the navbar */
        padding: 48px 0 0; /* Height of navbar */
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
    }

    @media (max-width: 767.98px) {
        .sidebar {
            top: 5rem;
        }
    }

    .sidebar-sticky {
        position: relative;
        top: 0;
        height: calc(100vh - 48px);
        padding-top: .5rem;
        overflow-x: hidden;
        overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
    }

    .sidebar .nav-link {
        font-weight: 500;
        color: #333;
    }

    .sidebar .nav-link .feather {
        margin-right: 4px;
        color: #727272;
    }

    .sidebar .nav-link.active {
        color: #2470dc;
    }

    .sidebar .nav-link:hover .feather,
    .sidebar .nav-link.active .feather {
        color: inherit;
    }

    .sidebar-heading {
        font-size: .75rem;
        text-transform: uppercase;
    }

    /*
     * Navbar
     */

    .navbar-brand {
        padding-top: .75rem;
        padding-bottom: .75rem;
        font-size: 1rem;
        background-color: rgba(0, 0, 0, .25);
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
    }

    .navbar .navbar-toggler {
        top: .25rem;
        right: 1rem;
    }

    .navbar .form-control {
        padding: .75rem 1rem;
        border-width: 0;
        border-radius: 0;
    }

    .form-control-dark {
        color: #fff;
        background-color: rgba(255, 255, 255, .1);
        border-color: rgba(255, 255, 255, .1);
    }

    .form-control-dark:focus {
        border-color: transparent;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, .25);
    }

</style>
