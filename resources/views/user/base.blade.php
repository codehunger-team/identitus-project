<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="token" content="{!! csrf_token() !!}">
    <title>@yield('seo_title', 'Domain.Trader')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/raphel.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar  -->
      @include('user.partials.user-nav')
      <!-- Page Content  -->
      <div id="content">
          @if(session('msg'))
              <div id="message">
                  <div style="padding: 5px;">
                      <div id="inner-message" class="alert alert-error">
                          <div class="alert alert-primary alert-dismissible  float-end notify" role="alert">
                              {!! session('msg') !!}
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                      </div>
                  </div>
              </div>
          @endif
          <div class="col m-4">
              <h1 class="box-header">@yield('section_title', 'Section Title')</h1>
              <div class="card mt-4">
                  <div class="card-body">
                      @yield('section_body', 'Body')
                  </div>
              </div>
              @yield('extra_bottom')
          </div>
      </div>
  </div>
    @include('admin.partials.footer')
  </body>
</html>
