<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('admin.partials.header')
<body>
<div class="wrapper">
    <!-- Sidebar  -->
@include('user.partials.user-nav')
<!-- Page Content  -->
    <div id="content">
        @include('admin.partials.admin-message')
        @include('admin.partials.admin-navbar')
        <div class="container">
            <div class="row">
                <div class="col-md-9 ms-sm-auto col-lg-10" style="margin-top: 6rem; margin-bottom: 6rem;">
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
    </div>
@include('admin.partials.footer')
</body>
</html>
