<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('admin.partials.header')
<body>
<div id="app">
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="container-fluid" id="content">
            @if( session('msg') )
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
                    {!! session('msg') !!}
                </div>
            @endif
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row vh-50">
                @include('admin.partials.admin-nav')
                <div class="col m-4">
                    <h1 class="box-header">@yield('section_title', 'Section Title')</h1>
                    @yield('section_body', 'Body')
                    @yield('extra_bottom')
                </div>
            </div>
        </div>
    </main>
</div>
@include('admin.partials.footer')
</body>
</html>


