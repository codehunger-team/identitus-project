@extends('layouts.app')
@section('seo')
<link rel="canonical" href="{{url('fees')}}" />
@endsection
@section('content')
<div class="container">
    <div class="row mt-6">
        <div class="col">
            <h1 class="text-theme text-center">Identitius Fees and Charges</h1>
            <div class="separator-3"></div>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-sm-12 mx-auto">
                <title>Identitius Fees</title>

                <h2>For the Renter - Lessee:</h2>
                <p><a href="https://www.identitius.com">Identitius</a> does not charge domain renters or lessees directly for any services. 
                    
                <p>When you lease a domain through <a href="https://www.identitius.com">Identitius</a>, we collect both the rent and the payment processing (credit card) fee. The payment processing fees never hit our account, and the rent is passed directly on to the domain owner / lessor minus our fee to them. Our goal is to lower our fees as much as we can, but there is a real cost to maintaining these services for you and others. We thank you for using <a href="https://www.identitius.com">Identitius</a> and for helping us to these services possible for everyone.</p>
                
                <p>As you probably know, the exact rent and payment processing fees are based on the specific domain and rental terms.</p>

                <h2>For the Domain Owner - Lessor:</h2>
                <p>Domain owners / lessors on <a href="https://www.identitius.com">Identitius</a> are subject to the following fees:</p>
                <ul>
                    <li><strong>Commission on Rents Received:</strong> Domain owners pay a 10% commission on domains pointed at their respective <a href="https://www.identitius.com">Identitius</a>.com page and a 20% commission on domains that are not.</li>
                    <li><strong>Commission on Domain Sales:</strong> In the event of a domain sale, domain owners pay a 10% commission on domains pointed at their respective <a href="https://www.identitius.com">Identitius</a> page and a 20% commission on domains that are not.</li>
                    <li><strong>Payment Processing Fees:</strong>All payment processing fees for leases and sales are charged to the customer seperately and passed on directly to the payment processing company: Stripe.</li>
                </ul>

                <h2>Disclaimer</h2>
                <p>Please note that the fees mentioned above are subject to change and may vary based on individual agreements and circumstances. Identitius reserves the right to me.odify the fees at any time. It is recommended to review the specific terms and conditions associated with each domain for accurate fee information and check here regularly for future fees and charges on domain leases and sales.</p>
        </div>
    </div>
</div>
@endsection