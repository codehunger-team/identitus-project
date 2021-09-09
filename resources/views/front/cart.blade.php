@extends('layouts.app')
@section('seo_title') Cart - {!! \App\Models\Option::get_option('seo_title') !!} @endsection
@section('content')
<div class="container">
    <div class="row" style="margin-top:8%">
        <div class="col-8-lg col-8-md col-8-sm mx-auto main-top ">
            <div class="text-center">
                <h1>Checkout</h1>
            </div>
            @if(Session::has('msg'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{ Session::get('msg') }}
                </div>
            @endif
            @if( session()->has('message') AND session()->has('message_type') )
                @include('components.sweet-alert')
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12-sm mx-auto mb-4 mt-4">
            <div class="card shadow-sm p-3 mx-auto mb-5 bg-white rounded" style="width: 26rem;">
                <div class="card-body">
                    <h6>Check your shopping cart and choose a type of payment.</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Domain</th>
                                    <th>Purchase Type</th>
                                    <th class="text-center">Price</th>

                                </tr>
                            </thead>@if( \Cart::getContent()->count() )
                            <tbody>@foreach( $cart as $domain )
                                <tr>
                                    <td class="text-primary align-middle">
                                        <a href="{{route('ajax.remove.to.cart',$domain->id)}}" type="link"><svg
                                                class="bi bi-x-circle-fill" width="1em" height="1em" viewBox="0 0 16 16"
                                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.146-3.146a.5.5 0 0 0-.708-.708L8 7.293 4.854 4.146a.5.5 0 1 0-.708.708L7.293 8l-3.147 3.146a.5.5 0 0 0 .708.708L8 8.707l3.146 3.147a.5.5 0 0 0 .708-.708L8.707 8l3.147-3.146z" />
                                            </svg> </a>
                                        <a href="{{url('/',$domain->name)}}">{{ $domain->name }}</a>
                                    </td>
                                    <td>
                                        {{ $domain->attributes[0] == 'lease' ? 'First Payment' : 'Purchase Payment' }}
                                    </td>
                                    <td class="text-right text-primary-price align-middle">
                                        {{ \App\Models\Option::get_option( 'currency_symbol' ) . number_format($domain->price)}}
                                    </td>
                                    <td>

                                    </td>
                                </tr>@endforeach
                                <tr>
                                    <td colspan="1">
                                        <h3>Total</h3>
                                    </td>
                                    <td class="text-center">
                                        <h3>
                                            <strong>{{ App\Models\Option::get_option( 'currency_symbol' ) .  number_format(\Cart::getTotal()) }}</strong>
                                        </h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-end" colspan="2">
                                        <a href="{{route('domains')}}" class="btn btn-primary"> Continue Shopping</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h4>Checkout</h4>
                                        @if( 'Yes' == \App\Models\Option::get_option( 'stripeEnable' ) )
                                        <a href="{{route('checkout.credit.card.processing')}}" class="btn btn-primary">Credit Card</a>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>@else
                            <tr>
                                <td colspan="1">
                                    <h3>Your Cart is Empty</h3>
                                </td>
                                <td class="text-right">
                                    <h3><strong>{{ App\Models\Option::get_option( 'currency_symbol' ) }}0.00</strong></h3>
                                </td>
                            </tr>@endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
