<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSRF Token -->
    <title>{{ config('app.name', 'Identitius') }}</title>
    <meta name="description" content="Domains for adoption">
    <meta name="keywords" content="domains">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!--favicon --> 
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('images/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/android-chrome-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/android-chrome-512x512.png')}}">
    <link rel="manifest" href="{{asset('images/site.webmanifest')}}">

    @yield('seo')
</head>