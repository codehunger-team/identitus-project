<footer class="page-footer font-small py-4 bg-primary">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Identitius') }}
                    </a>
                    <p>
                        Affordable and flexible domain lease plans,
                        with&nbsp;the option to buy.
                    </p>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <h1 class="brand brand-footer text-white">
                        Links
                    </h1>
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="/membership">Membership Agreement</a>
                        </li>
                        <li>
                        <li>
                            <a href="/tos">Terms of Service</a>
                        </li>
                        <li>
                            <a href="/privacy-policy">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="/cookie-policy">Cookie Policy</a>
                        </li>
                        <li>
                            <a href="/disclaimer">Disclaimer</a>
                        </li>
                        <li>
                            <a href="/ccpa-do-not-sell">CCPA Do Not Sell</a>
                        </li>
                        <li>
                            <a href="#" onclick="window.displayPreferenceModal();return false;" id="termly-consent-preferences">Consent Preferences</a>
                        </li>
                        <li>
                            <a href="/sitemap.xml">Sitemap</a>
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


