<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('admin.partials.header')
<body>
<div class="wrapper">
    <!-- Sidebar  -->
    @include('admin.partials.admin-nav')
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
        <nav class="navbar navbar-hide navbar-expand-lg navbar-primary bg-primary"><a href="javascript:void(0)"><i class="sidebarCollapse fas fa-bars text-white"></i></a><span class="text-white">IDENTITUS</span></nav>
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


