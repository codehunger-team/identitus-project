<nav class="navbar fixed-top navbar-expand-md navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Identitius') }}
        </a>
        <button class="navbar-toggler text-white" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="{{ __('Toggle navigation') }}">
            <i class="fas fa-bars text-white"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('about')}}">About</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('domains')}}">Domains</a></li>

                <li class="nav-item" href="">
                    <a class="nav-link" href="{{route('qa')}}">Q&As</a>
                </li>

                <!-- Authentication Links -->
                @guest
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-bs-toggle="dropdown" aria-expanded="false" aria-label="Login/Register">
                        <i class="fas fa-user-circle  fa-2x"></i>
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        @if (Route::has('login'))
                            <li>
                                <a class="dropdown-item" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li>
                                <a class="dropdown-item" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle btn btn-secondary text-white" href="#"
                        role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        @if(Auth::user()->admin == 1)
                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        @else
                        <a class="dropdown-item" href="{{ route('user.profile') }}">Profile</a>
                        @endif
                    </div>
                </li>
                @endguest
                <li class="nav-item">
                    <a class="nav-link cart_items" href="javascript:void(0)" target="_self" aria-label="Cart">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                        <span class="translate-cart badge rounded-pill bg-danger">
                           {{Cart::getContent()->count() ?? ''}}
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>