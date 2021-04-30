<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="token" content="{!! csrf_token() !!}">
    <title>@yield('seo_title', 'Identitius')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
   
    <link rel="stylesheet" type="text/css" href="{{ asset('../resources/assets/admin/plugins/iCheck/flat/blue.css') }}">
    
    <link rel="stylesheet" type="text/css"
          href="{{ asset('../resources/assets/admin/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('../resources/assets/admin/css/style.css') }}"> --}}
    {{-- <script src="{{ asset('../resources/assets/admin/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="{{ asset('../resources/assets/admin/js/countries.js') }}"></script> --}}
    {{-- <script src="{{ asset('../resources/assets/admin/plugins/select2/select2.min.js') }}"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script> --}}
</head>
