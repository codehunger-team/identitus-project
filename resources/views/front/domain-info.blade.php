@extends('layouts.app')
@section('content')

<div class="container">
    <div class="section-title">
        <h1 class="text-center">
            {{ $domain->domain }}<br />
        </h1>
        @if( session()->has('message') AND session()->has('message_type') )
        @include('components.sweet-alert')
        @endif
        <h3 class="text-center text-muted">This domain name is available to rent or purchase.</h3>
        <p class="text-center text-muted">If you know someone that might want to rent or purchase this domain name, <a href="mailto:info@identitius.com"><u>let us know</u></a>. We offer referral fees.</p>
    </div>
</div>
<div class="container">
    <!-- //section-title -->
    <div class="row my-4">
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-body text-center">
                    <h2>RENT NOW</h2>
                    <h3>
                        @if(! isset($domain->contract->period_payment))
                        Unavailable
                        @else
                        {{ App\Models\Option::get_option( 'currency_symbol' ) . number_format($domain->contract->period_payment, 0) }}
                        @endif
                    </h3>
                    <h5 class="text-muted">Secure the domain with an option to buy it by renting now.</h5>
                    <a class="btn btn-success btn-block @if(! isset($domain->contract->period_payment))  disabled @endif" href="{{route('review.terms',$domain->domain)}}">Lease Now</a>
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
                    <h5 class="text-muted">Forget renting, just buy the domain and own it now!</h5>
                    <a class="btn btn-success btn-block" href="{{route('ajax.add-to-cart.buy',$domain->domain)}}">Buy Now</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-white">
    <div class="row mt-4">
        @if(isset($whois['domain']))
        <div class="col-lg-8 col-md-12 col-sm-12 mx-auto my-4">
            <div class="text-center">
                <h2 class="my-4">Summary</h2>
            </div>
            <table class="table table-bordered table-responsive">
                <tr>
                    <th class="theading">Registered On</th>
                    <td>{{ $whois['created_date'] }}</td>
                    <th class="theading">Registrar</th>
                    <td>{{ $whois['registrar'] }}</td>
                </tr>
                <tr>
                    <th class="theading">Domain Age</th>
                    <td>
                        @php
                        $created = new DateTime($whois['created_date']);
                        $now = new DateTime(date('Y-m-d'));
                        $diff = $now->diff($created);
                        echo $diff->y . ' Years';
                        @endphp
                    </td>
                    <th class="theading">Registrant Country</th>
                    <td>
                        {{ $whois['registrant_country'] }}
                    </td>
                </tr>
                <tr>
                    <th class="theading">Nameservers</th>
                    <td>
                        <ul>
                            @foreach($whois['nameservers'] as $nameserver)
                            <li>{{ $nameserver }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="col-sm-12">{!! $domain->description !!}</div>
                    </td>
                </tr>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection