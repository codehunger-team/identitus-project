@extends('layouts.app')
<!-- missing seo -->
@section('content')
@php
$stripe_key = env('PUBLISHABLE_KEY');
@endphp
<div class="container" style="margin-top:10%;margin-bottom:10%">
    <div class="row">
        <div class="col-md-6">
            @include('front.checkout.billing-detail')
            @include('front.checkout.card-detail')
        </div>
        <div class="col-md-6">
            @include('front.checkout.order-detail')
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)

    var style = {
        base: {
            color: '#32325d',
            lineHeight: '18px',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    const stripe = Stripe('{{ $stripe_key }}', {
        locale: 'en'
    }); // Create a Stripe client.
    const elements = stripe.elements(); // Create an instance of Elements.
    const cardElement = elements.create('card', {
        style: style
    }); // Create an instance of the card Element.
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;

    cardElement.mount('#card-element'); // Add an instance of the card Element into the `card-element` <div>.

    // Handle real-time validation errors from the card Element.
    cardElement.addEventListener('change', function (event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission.
    var form = document.getElementById('payment-form');

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        $('.submit-btn').attr('disabled', 'disabled');
        $("#card-button").text('processing...');
        stripe.handleCardPayment(clientSecret, cardElement, {
                payment_method_data: {
                    //billing_details: { name: cardHolderName.value }
                }
            })
            .then(function (result) {
                if (result.error) {
                    $('.submit-btn').prop("disabled", false); // Element(s) are now enabled.
                    $("#card-button").text('pay');
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    form.submit();
                }
            });
    });
</script>
@endsection