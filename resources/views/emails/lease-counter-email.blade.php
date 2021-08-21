@extends('emails.base')

@section('mail_subject')
New Contact Form Notification!
@endsection

@section('email_title')
New Contact Form Notification!
@endsection

@section('intro_heading')
New contact message was received via contact form.
@endsection

@component('mail::message')
# Lease Counter <br> <br> <hr>

## First Payment :<h2 class="font-weight-bold">$ {{$data['first_payment']}}</h2><br>
## Period Payments :<h2 class="font-weight-bold">$ {{$data['period_payment']}}</h2><br>
## Periods :<h2 class="font-weight-bold">{{$data['number_of_periods']}}</h2><br>
## Option Purchase Price :<h2 class="font-weight-bold">$ {{$data['option_price']}}</h2><br>

Thanks,<br>
@endcomponent