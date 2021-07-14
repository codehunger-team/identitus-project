<footer class="page-footer font-small pt-4 bg-primary">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <h1 class="brand brand-footer">
                        <a href="/">Identitius</a>
                    </h1>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <h1 class="brand brand-footer text-white">
                        Links
                    </h1>
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="/p-tos">Terms of Service</a>
                        </li>
                        <li>
                            <a href="/p-privacy-policy">Privacy Policy</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <h1 class="brand brand-footer text-white">
                        Contact
                    </h1>
                    @include('partials.contact-form')
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="{{ asset('js/app.js') }}" defer></script>
{{-- Do we need ajax?
<script src="{{ asset('js/ajax.js') }}"></script>
--}}
<script src="{{ asset('js/sweetalert.min.js') }}"></script>

