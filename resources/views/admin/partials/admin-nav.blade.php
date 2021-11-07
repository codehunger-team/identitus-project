<nav id="sidebar"  class="sidebar px-4">
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
        <li @if(isset($active) AND ($active=='user' )) class="active" @endif>
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
</nav>
