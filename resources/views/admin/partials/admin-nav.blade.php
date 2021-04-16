<div class="col-md-3 col-lg-2 d-md-block bg-primary sidebar collapse py-4 vh-100" style="width: 280px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-4">Identitius</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="header text-white">ADMIN MENU</li>
        <li @if(isset($active) AND ($active=='dashboard' )) class="active" @endif>
            <a href="{{route('admin.dashboard')}}" class="nav-link text-white"><i class="fas fa-columns"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='add-commission' )) class="active" @endif>
            <a href="{{route('admin.add.commission')}}" class="nav-link text-white"><i class="fas fa-calculator"></i>
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
        <li @if(isset($active) AND ($active=='pages' )) class="active" @endif>
            <a href="{{route('admin.cms')}}" class="nav-link text-white">
                <i class="fas fa-sticky-note"></i>
                <span>Pages</span>
            </a>
        </li>
        <li @if(isset($active) AND ($active=='navi' )) class="active" @endif>
            <a href="{{route('admin.navigation')}}" class="nav-link text-white">
                <i class="fas fa-compass"></i>
                <span>Navigation</span>
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
</div>
