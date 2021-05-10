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
    <ul class="list-unstyled components">
        <li class="text-white">ADMIN MENU</li>
        <li @if(isset($active) AND ($active=='dashboard' )) class="active" @endif>
            <a href="{{route('admin.dashboard')}}" class="nav-link text-white"><i class="fa fa-columns"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='add-commission' )) class="active" @endif>
            <a href="{{route('admin.add.commission')}}" class="nav-link text-white"><i class="fa fa-calculator"></i>
                <span>Add Commission</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='domains' )) class="active" @endif>
            <a href="{{route('admin.domain')}}" class="nav-link text-white"><i class="fa fa-globe"></i>
                <span>Domains</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='active-lease' )) class="active" @endif>
            <a href="{{route('admin.active.lease')}}" class="nav-link text-white"><i class="fas fa-rocket"></i>
                <span>Active Lease</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='inactive-lease' )) class="active" @endif>
            <a href="{{route('admin.inactive.lease')}}" class="nav-link text-white"><i class="fas fa-meteor"></i>
                <span>Inactive Lease</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='categories' )) class="active" @endif>
            <a href="{{route('admin.category')}}" class="nav-link text-white"><i class="fa fa-list"
                                                                                 aria-hidden="true"></i>
                <span>Categories</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='period' )) class="active" @endif>
            <a href="{{route('admin.period')}}" class="nav-link text-white">
                <i class="fas fa-clock"></i>
                <span>Period Types</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='option' )) class="active" @endif>
            <a href="{{route('admin.option')}}" class="nav-link text-white">
                <i class="fas fa-calendar-day"></i>
                <span>Option Expiration</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='grace-period' )) class="active" @endif>
            <a href="{{route('admin.grace')}}" class="nav-link text-white">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                <span>Grace Period</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='bulk' )) class="active" @endif>
            <a href="{{route('admin.bulk.upload')}}" class="nav-link text-white">
                <i class="fa fa-upload"></i>
                <span>Bulk Upload</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='user' )) class="active" @endif>
            <a href="{{route('admin.users')}}" class="nav-link text-white">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='config' )) class="active" @endif>
            <a href="{{route('admin.configuration')}}" class="nav-link text-white">
                <i class="fa fa-cog"></i>
                <span>Configuration</span></a>
        </li>
        <li>
            <a href="{{route('admin.logout')}}" class="nav-link text-white">
                <i class="fas fa-sign-out-alt"></i>
                <span>Log Out</span>
            </a>
        </li>
    </ul>
</nav>