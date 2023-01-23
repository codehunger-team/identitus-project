<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- termly.io consent banner -->
    
    <script
    type="text/javascript"
    src="https://app.termly.io/embed.min.js"
    data-auto-block="on"
    data-website-uuid="c2d97ad4-8a15-41a4-bbf4-57589e63be22"
    ></script>
           
     <!-- End termly.io consent banner -->

    <!-- CSRF Token -->

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Identitius') }}</title>
    <meta name="description" content="Domains for adoption">
    <meta name="keywords" content="domains">

    <!-- termly.io Scripts --> 
              
    <script
    type="text/javascript"
    src="https://app.termly.io/embed.min.js"
    data-auto-block="off"
    data-website-uuid="c2d97ad4-8a15-41a4-bbf4-57589e63be22"
    ></script>

    <!-- End termly.io Scripts -->

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-180909623-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', 'UA-180909623-1');
    </script>
</head>
