@extends('layouts.app')
@section('content')

<div class="container">
    <div class="section-title">
        <h1 class="text-center">
            {{ $domain->domain }}<br/>
        </h1>
        @if( session()->has('message') AND session()->has('message_type') )
                @include('components.sweet-alert')
        @endif
        <h4 class="text-center text-muted">This domain is available for purchase.</h4>
    </div>
</div>
<div class="container">
    <!-- //section-title -->
    <div class="row my-4">
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-body text-center">
                    <h2>LEASE NOW</h2>
                            <h3>
                                @if(! isset($domain->contract->period_payment))
                                    Unavailable      
                                @else 
                                {{ App\Models\Option::get_option( 'currency_symbol' ) . number_format($domain->contract->period_payment, 0) }}
                                @endif
                            </h3>
                            <h5 class="text-muted">The checkout process is very quick and easy. Grab it before anyone else!</h5>
                        <a class="btn btn-success btn-block @if(! isset($domain->contract->period_payment))  disabled @endif"
                            href="{{route('review.terms',$domain->domain)}}">Lease Now</a>
                </div>           
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-body text-center">
                    <h2>BUY NOW</h2>
                    <h3>
                        @if( !is_null($domain->discount) AND ($domain->discount != 0 ))
                            <span class="text-discount">{{ \App\Models\Option::get_option( 'currency_symbol' ) . number_format($domain->pricing,0) }}</span>
                            {{ App\Models\Option::get_option( 'currency_symbol' ) . number_format($domain->discount, 0) }}
                        @else
                            {{ App\Models\Option::get_option( 'currency_symbol' ) . number_format($domain->pricing, 0) }}
                        @endif
                        </h3>
                    <h5 class="text-muted">The checkout process is very quick and easy. Grab it before anyone else!</h5>
                    <a class="btn btn-success btn-block"
                    href="{{route('ajax.add-to-cart.buy',$domain->domain)}}">Buy Now</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-white">
    <div class="row mt-4">
        <div class="col-lg-8 col-md-12 col-sm-12 mx-auto my-4">
            <div class="text-center">
                <h2 class="my-4">Summary</h2>
            </div>
            {{-- @dd($registrar) --}}
            <table class="table table-bordered table-responsive">
                <tr>
                    <th class="theading">Registered On</th>
                    <td>{{ date('jS F Y', strtotime($domain->reg_date) ) ?? ''}}</td>
                    <th class="theading">Registrar</th>
                    <td>{{ $registrar->registrar }}</td>
                </tr>
                <tr>
                    <th class="theading">Domain Age</th>
                    <td>@if( $domain->domain_age != 0 ) {{ $domain->domain_age ?? ''}} Years Old @else Less than 1
                        Year Old @endif</td>
                    <th class="theading">Domain Category</th>
                    <td>
                        {{ $category->catname ?? ''}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="col-sm-12">{!! $domain->description !!}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
