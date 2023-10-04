<head>
    @php 
      $domainLastPart = request()->segment(count(request()->segments()));
      $domain = App\Models\Domain::where('domain',$domainLastPart)->first();
    @endphp
  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(isset($domain))
        <title>{{$domain->domain ?? 'Identitius: The Domain Name Leasing and Rental Marketplace'}}</title>
        <meta name="description" content="{!!$domain->short_description ?? 'Identitius: The Domain Name Leasing and Rental Marketplace'!!}">
        <meta name="keywords" content="{!!$domain->tags ?? 'domain name lease, lease domain name, rent domain names, lease domain'!!}">
    @else
        <title>Identitius: The Domain Name Leasing and Rental Marketplace</title>
        <meta name="description" content="Identitius: The Domain Name Leasing and Rental Marketplace">
        <meta name="keywords" content="domain name lease, lease domain name, rent domain names, lease domain">
    @endif
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!--favicon --> 
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('images/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/android-chrome-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/android-chrome-512x512.png')}}">

    @yield('seo')
    @laravelPWA
</head>