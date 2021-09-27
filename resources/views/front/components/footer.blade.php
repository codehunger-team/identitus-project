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
                    @if(Session::has('contact-msg'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            {{ Session::get('contact-msg') }}
                        </div>
                    @endif
                    @include('partials.contact-form')
                </div>
            </div>
        </div>
    </div>
</footer>


