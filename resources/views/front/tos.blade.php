@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-6">
            <div class="col">
                <h1 class="text-theme text-center">Terms of Service</h1>
                <div class="separator-3"></div>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-sm-12 mx-auto">

                <p>
                    <div name="termly-embed" data-id="003bc7d0-817f-4528-9353-8cbbf031dee6" data-type="iframe"></div>
                    <script type="text/javascript">(function(d, s, id) {
                    var js, tjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = "https://app.termly.io/embed-policy.min.js";
                    tjs.parentNode.insertBefore(js, tjs);
                    }(document, 'script', 'termly-jssdk'));</script>
                </p>
            </div>
        </div>
    </div>
@endsection
