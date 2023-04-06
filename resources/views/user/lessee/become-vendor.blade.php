@extends('user.base')

@section('section_title')
<strong>Become Vendor</strong>
@endsection

@section('section_body')
@if(Session::has('docusign'))
    @php
    $clickwrap = Session::get('docusign');
    @endphp
    @include('user.lessee.docusign.become-vendor-terms')
@endif

@if(Auth::user()->is_vendor == 'pending')
<div class="alert alert-warning" role="alert">
    <h5>Thanks, {{Auth::user()->name}} for showing your interest in becoming vendor, your application is in progress,
        after the confirmation you will receive the email on your registered e-mail id, or you can check here after 2
        days.</h5>
</div>

@elseif(Auth::user()->is_vendor == 'yes')
<div class="alert alert-success" role="alert">
    <h5>Your profile has been successfully verified now you can start adding your domains, Good Luck</h5>
</div>
@else
<div class="alert alert-danger" role="alert">
    <h5>Hello, {{Auth::user()->name}} we are happy to see you again, to sell your domain through our website, you are
        just a step away, click on the below button to register yourself as a vendor and start listing your domain, it
        tooks 24 to 48 hours to verify the profile.</h5>
</div>
<a href="{{route('sign.document','terms.pdf')}}" id="become-vendor" class="btn btn-primary btn-block text-center">Become
    Vendor</a>
<script>
    $(document).on('click', '#become-vendor', function () {
        $(this).addClass('disabled');
        $(this).text('Redirecting to terms page ...')
    });

</script>
@endif
@endsection
