<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('partials.header')
@stack('styles')

<body>
    <div id="app">
        @include('partials.navbar')
        @yield('hero')

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @include('front.components.cart-popup')
    @include('front.components.footer')
    @include('partials.global-js')
</body>
<!-- termly.io Scripts -->
<script type="text/javascript" src="https://app.termly.io/embed.min.js" data-auto-block="off" data-website-uuid="c2d97ad4-8a15-41a4-bbf4-57589e63be22"></script>
<!-- End termly.io Scripts -->
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@include('front.components.sweet-alert')
<script src="https://www.google.com/recaptcha/api.js"></script>
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-180909623-1"></script>
<script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/worker.js', {
            scope: '/'
        });
    }
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());
    gtag('config', 'UA-180909623-1');
</script>

<!-- Lucky Orange -->
<script async defer src="https://tools.luckyorange.com/core/lo.js?site-id=4d201ef8"></script>
@stack('scripts')

</html>