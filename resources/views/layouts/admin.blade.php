<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('admin.partials.header')
<body>
<div id="app">
    <main class="py-4">
        <div class="container-fluid">
            <div class="row">
                @include('admin.partials.admin-nav')
                <div class="col">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>
</div>
@include('admin.partials.footer')
</body>
</html>
