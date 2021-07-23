@extends('user.base')
@section('section_title')
	<strong>Stripe Connect</strong>
@endsection
@section('section_body')
    @php
        $stripe_client_id = env('STRIPE_CLIENT_ID');
    @endphp
    @if(isset($stripe_account_id))
    <a class="btn btn-danger" href="{{route('user.revoke.stripe')}}">Revoke Account</a>
    @elseif(isset($stripe_client_id))
    <a href="https://connect.stripe.com/oauth/authorize?response_type=code&client_id={{$stripe_client_id}}&scope=read_write" class="btn btn-primary">Connect To Stripe</a>
    @else 
    <a href="https://connect.stripe.com/oauth/authorize?response_type=code&client_id={{$stripe_client_id}}&scope=read_write" class="btn btn-primary">Contact Admin To Activate Stripe</a>
    @endisset
@endsection