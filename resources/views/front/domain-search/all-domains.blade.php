@extends('layouts.app')
@section('seo_title') Domains List - {!! \App\Models\Option::get_option('seo_title') !!} @endsection
@section('content')

{!! $autoSearch !!}
{{--Title--}}
<div class="container main-top">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="text-center">Find Your Domain Filter</h1>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12 mx-auto">
            <form method="POST" action="{{route('ajax.domainfiltering')}}" id="ajax-search-form">
                @csrf
                <div class="col-12-sm">
                    <div id="custom-search-input">
                        <div class="input-group">
                            <input id="input" placeholder="Enter Domain or keyword" @if( !empty( $autoKeyword ) ) value="{{ $autoKeyword }}" @endif name="keyword" class="form-control search-input input-lg" />
                            <button id="buttonAjaxFilter" class="btn btn-primary" type="submit">
                                <svg class="bi bi-search" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
                                    <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
                                </svg>
                            </button>
                        </div>
                    </div><!-- ./#custom-search-input -->
                </div>
                <div class="form-group row my-2">
                    <div class="col-lg-4 col-sm-12 my-2">
                        <select name="category" class="form-control category">
                            <option value="0">All Categories</option>
                            @foreach( $categories as $c )
                            <option value="{{ $c->catID }}">{{ stripslashes($c->catname) }}</option>
                            @endforeach
                        </select>
                    </div>
                    @php
                    //converting array into uppercase and removing repeated tld
                    $tlds = array_unique(array_map('strtoupper', $tlds));
                    @endphp
                    <div class="col-lg-4 col-sm-12 my-2">
                        <select name="extension" class="form-control any-tld">
                            <option value="">Any TLD</option>
                            @foreach( $tlds as $tld )
                            <option value="{{ $tld }}">.{{ $tld }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-4 col-sm-12 my-2">
                        <select name="age" class="form-control age">
                            <option value="0">Any Age</option>
                            @for( $i=1; $i<=10; $i++ ) <option value="{{ $i }}">{{ $i }}+ Years Old</option>
                                @endfor
                        </select>
                    </div>
                    <div class="col-lg-3 col-sm-12 my-2" style="display: none;">
                        <select name="sortby" class="form-control">
                            <option value="domain.asc">Sort Order</option>
                            <option value="id.desc">Added Date</option>
                            <option value="pricing.asc">Lowest Price</option>
                            <option value="pricing.desc">Highest Price</option>
                            <option value="domain.asc">Alphabetically</option>
                        </select>
                    </div>
                    <div class="col-lg-4 col-sm-12 my-2">
                        <label class="label">Character Length</label>
                        <div class="row mt-2">
                            <input type="hidden" name="char_from" placeholder="from" class="form-control char_from" value="0">
                            <div class="col-lg-5">
                                <input type="number" name="char_to" value="63" class="form-control char_to">
                            </div>
                        </div>
                        <input id="char_slider" class="border-0 character-length" type="range" min="0" max="63" />
                    </div>
                    <div class="col-lg-4 col-sm-12 my-2">
                        <label class="label">Purchase Price Range($)</label>
                        <div class="row mt-2">
                            <div class="col-lg-5">
                                <input type="text" name="price_from" placeholder="from" class="form-control price_from">
                            </div>
                            <div class="col-lg-5">
                                <input type="text" name="price_to" placeholder="to" class="form-control price_to">
                            </div>
                        </div>
                        {{-- <input id="price_slider" class="border-0 price-range" type="range" min="0" max="20000"
                            step="500" /> --}}
                    </div>
                    <div class="col-lg-4 col-sm-12 my-2">
                        <label class="label">Monthly Price Range($)</label>
                        <div class="row mt-2">
                            <div class="col-lg-5">
                                <input type="text" name="monthly_price_from" placeholder="from" class="form-control monthly_price_from">
                            </div>
                            <div class="col-lg-5">
                                <input type="text" name="monthly_price_to" placeholder="to" class="form-control monthly_price_to">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 my-2">
                        <label class="label">Keyword Placement</label>
                        <div class="row mt-2">
                            <div class="col-lg-5 col-sm-12 my-2">
                                <select name="keyword_placement" class="form-control keyword-placement">
                                    <option value="contains">Contains</option>
                                    <option value="starts_with">Starts with</option>
                                    <option value="ends_with">Ends with</option>
                                </select>
                            </div>
                            <div class="col-lg-5 mt-2">
                                <button type="button" id="sbAjaxSearch" class="btn btn-full-width-sm btn-primary mr-auto float-right ">Search Query
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{--Preloader--}}
<div class="container preload-search">
    <div class="row">
        <div class="col-auto mx-auto">
            <div class="d-flex align-items-center mx-auto preload-search">
                <div class="spinner-border text-secondary ml-auto" role="status" aria-hidden="true"></div>
                <strong>&nbsp;&nbsp;Loading Domains...</strong>
            </div>
        </div>
    </div>
</div>

{{-- Table--}}
<div class="container my-4">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body ajax-filtered-domains">
                    <table id="domainsTable" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Domain</th>
                                <th>Monthly Lease</th>
                                <th>Purchase Price</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
@include('front.domain-search.domain-search-script')
@endpush
@endsection