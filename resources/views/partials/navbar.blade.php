<nav class="navbar fixed-top navbar-expand-md navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Identitius') }}
        </a>
        <button class="navbar-toggler text-white" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
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
                <li class="nav-item">
                    <a class="nav-link cart_items" href="javascript:void(0)" target="_self">Checkout <i class="fas fa-shopping-cart"></i></a>
                <li class="nav-item" href="">
                    <a class="nav-link" href="{{route('qa')}}">Q&As</a>
                </li>

                <!-- Authentication Links -->
                @guest
                    <div class="dropdown" aria-label="Login/Register">
                        <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path stroke-linejoin="round" stroke-linecap="round" stroke-miterlimit="10" stroke="#fff" d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path stroke-linecap="round" stroke-miterlimit="10" stroke="#fff" d="M19.33 18.79A8.002 8.002 0 0012 14c-3.28 0-6.09 1.97-7.33 4.79C6.5 20.76 9.1 22 12 22c2.9 0 5.5-1.24 7.33-3.21z"/><path stroke-linecap="round" stroke-miterlimit="10" stroke="#fff" d="M12 14a4 4 0 100-8 4 4 0 000 8z"/></svg>
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
                        <a id="navbarDropdown" class="nav-link dropdown-toggle btn btn-secondary text-white" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
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
            </ul>
        </div>
    </div>
</nav>
