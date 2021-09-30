<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('partials.header')
    <body>
        <div id="app">
            @include('partials.navbar')
            @yield('hero')

            <main class="py-4">
                @yield('content')
            </main>
        </div>
        @stack('scripts')
        @include('front.components.sweet-alert')
        @include('front.components.cart-popup')
        @include('partials.global-js')
    @include('front.components.footer')
    </body>
</html>
