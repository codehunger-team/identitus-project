@extends('user.base')

@section('section_title')
<strong>Become Vendor</strong>
@endsection

@section('section_body')
@php
$stripe_client_id = env('STRIPE_CLIENT_ID');
@endphp
@if(Session::has('docusign'))
@php
$clickwrap = Session::get('docusign');
@endphp
@include('user.lessee.docusign.become-vendor-terms')
@endif


<section class="my-4 pb-2 border-bottom ">

    @if(isset($stripe_account_id))


    <div class="alert alert-success" role="alert">
        <h5>Hello {{Auth::user()->name}}, Your account has successfully connected with admin. Now you can transfer money
            safely.</h5>
    </div>
    <a class="btn btn-danger" href="{{route('user.revoke.stripe')}}">Revoke Account</a>
    @elseif(isset($stripe_client_id))

    <div class="alert alert-danger" role="alert">
        <h5>Hello {{Auth::user()->name}}, If you want to become a vendor, you need to connect to the admin Stripe
            account in order to transfer payments.</h5>
    </div>
    <a href="https://connect.stripe.com/oauth/authorize?response_type=code&client_id={{$stripe_client_id}}&scope=read_write"
        class="btn btn-primary text-white" id="connect-to-stripe">Connect To Stripe</a>

    @else

    @endisset
</section>

@if(Auth::user()->is_vendor == 'pending')
<div class="alert alert-warning" role="alert">
    <h5>Thank you, {{Auth::user()->name}} for your interest in becoming a vendor. Your application is being reviewed.
        Once approved, you will receive an email confirmation. You can also check here periodically.</h5>
</div>

@elseif(Auth::user()->is_vendor == 'yes')
<div class="alert alert-success" role="alert">
    <h5>Your profile has been successfully verified. Now you can start adding your domains. Good luck!</h5>
</div>
@else

<section>

    <div class="alert alert-danger" role="alert">
        <h5>Hello {{Auth::user()->name}}, We are happy to see your interest in being a Domain Lessor and Seller. You are
            one step away from listing domains on our website.
            Please click on the below button to register yourself or your company as a vendor (Lessor) and start listing
            your domains.
            It can take 24 to 48 hours to pass the verification process.</h5>
    </div>
    <a href="{{route('sign.document','terms.pdf')}}" id="become-vendor"
        class="btn btn-primary btn-block text-center">Become
        Vendor</a>
</section>
<script>
    $(document).on('click', '#become-vendor', function () {
        $(this).addClass('disabled');
        $(this).text('Redirecting to terms page ...')
    });


    $(document).on('click', '#connect-to-stripe', function () {
        $(this).addClass('disabled');
        $(this).text('Redirecting to Stripe ...')
    });

</script>
@endif
@endsection
