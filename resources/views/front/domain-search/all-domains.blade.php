@extends('layouts.app')
@section('seo_title') Domains List - {!! \App\Models\Option::get_option('seo_title') !!} @endsection
@section('content')

{!! $autoSearch !!}
{{--Title--}}
<div class="container main-top">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="text-center">Filter Domains</h1>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12 mx-auto">
            <form method="POST" action="{{route('ajax.domainfiltering')}}" id="ajax-search-form">
                {!! csrf_field() !!}
                <div class="col-12-sm">
                    <div id="custom-search-input">
                        <div class="input-group">
                            <input id="input" placeholder="Domain or keyword" @if( !empty( $autoKeyword ) )
                                value="{{ $autoKeyword }}" @endif name="keyword" class="form-control input-lg" />
                            <button id="buttonAjaxFilter" class="btn btn-primary" type="submit">
                                <svg class="bi bi-search" width="1em" height="1em" viewBox="0 0 16 16"
                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
                                    <path fill-rule="evenodd"
                                        d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
                                </svg>
                            </button>
                        </div>
                    </div><!-- ./#custom-search-input -->
                </div>
                <div class="form-group row my-2">
                    <div class="col-lg-3 col-sm-12 my-2">
                        <select name="category" class="form-control">
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
                    <div class="col-lg-3 col-sm-12 my-2">
                        <select name="extension" class="form-control">
                            <option value="">Any TLD</option>
                            @foreach( $tlds as $tld )
                            <option value="{{ $tld }}">.{{ $tld }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3 col-sm-12 my-2">
                        <select name="age" class="form-control">
                            <option value="0">Any Age</option>
                            @for( $i=1; $i<=10; $i++ ) <option value="{{ $i }}">{{ $i }}+ Years Old</option>
                                @endfor
                        </select>
                    </div>
                    <div class="col-lg-3 col-sm-12 my-2">
                        <select name="sortby" class="form-control">
                            <option value="domain.asc">Sort Order</option>
                            <option value="id.desc">Added Date</option>
                            <option value="pricing.asc">Lowest Price</option>
                            <option value="pricing.desc">Highest Price</option>
                            <option value="domain.asc">Alphabetically</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-sm-12 my-2">
                        <label class="label">Character Length</label>
                        <div class="row mt-2">
                            <div class="col-lg-4">
                                <input type="number" name="char_from" placeholder="from" class="form-control char_from"
                                    value="0">
                            </div>
                            <div class="col-lg-5">
                                <input type="number" name="char_to" placeholder="to" class="form-control char_to">
                            </div>
                        </div>
                        <input id="char_slider" class="border-0" type="range" min="0" max="63" />
                    </div>
                    <div class="col-lg-3 col-sm-12 my-2">
                        <label class="label">Price Range(USD)</label>
                        <div class="row mt-2">
                            <div class="col-lg-4">
                                <input type="number" name="price_from" placeholder="from"
                                    class="form-control price_from" value="0">
                            </div>
                            <div class="col-lg-5">
                                <input type="text" name="price_to" value="&infin;" placeholder="&infin;"
                                    class="form-control price_to">
                            </div>
                        </div>
                        <input id="price_slider" class="border-0" type="range" min="0" max="20000" step="500" />
                    </div>
                    <div class="col-lg-4 col-sm-12 my-2">
                        <label class="label">Keyword Placement</label>
                        <div class="row mt-2">
                            <div class="col-lg-4">
                                <input type="radio" class="form-check-input" value="contains"
                                    name="keyword_placement">Contains
                            </div>
                            <div class="col-lg-4">
                                <input type="radio" class="form-check-input" value="starts_with"
                                    name="keyword_placement">Starts with
                            </div>
                            <div class="col-lg-4">
                                <input type="radio" class="form-check-input" value="ends_with"
                                    name="keyword_placement">Ends with
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-12 my-2">
                        <label class="label">Include Adult</label>
                        <div class="row">
                            <div class="col-lg-12 mt-2">
                                <input type="checkbox" class="form-check-input" name="include_adult_domain"
                                    checked>Include adult domains
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-12 my-2">
                        <label class="label">Special Characters</label>
                        <div class="row">
                            <div class="col-lg-3 mt-2">
                                <input type="checkbox" class="form-check-input numerals"
                                    name="include_domains_with_hyphens" value="" checked>Include domains with hyphens
                            </div>
                            <div class="col-lg-3">
                                <input type="checkbox" class="form-check-input numerals"
                                    name="include_domains_with_numerals" value="" checked>Include domains with numerals
                            </div>
                            <div class="col-lg-3">
                                <input type="checkbox" class="form-check-input numerals" name="include_idn_domains"
                                    value="" checked>Include IDN domains
                            </div>
                            <div class="col-lg-3">
                                <input type="checkbox" class="form-check-input numeralsonly"
                                    name="domains_with_numerals_only" value="">Domains with numerals only
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 my-2">
                        <button type="submit" name="sbAjaxSearch"
                            class="btn btn-full-width-sm btn-primary mr-auto float-right ">Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{--Preloader--}}
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="preload-search container-white mx-auto my-auto">
                <img src="{{ asset( '../resources/assets/images/ajax.gif' ) }}" alt="preloading image"
                    style="float: left; padding: 10px;" />
                <h3 style="padding: 30px 0">Loading domains matching your criteria</h3>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

{{--    Table--}}
<div class="container container-white my-4">
    <div class="row">
        <div class="table-responsive">
            @include('front.components.domains-table')
        </div>
    </div>
</div>
@push('scripts')
<script>
    //uncheck all except domain with numerals
    $('input.numeralsonly').on('change', function () {
        $('input.numerals').not(this).prop('checked', false);
    });

    //uncheck domain with numerals only
    $('input.numerals').on('change', function () {
        $('input.numeralsonly').not(this).prop('checked', false);
    });
    $(document).ready(function () {
        const $charTo = $('.char_to');
        const $value = $('#char_slider');
        const $priceTo = $('.price_to');
        const $priceValue = $('#price_slider');

        $value.val(0); // set the charcter default value to zero
        $priceValue.val('20000'); // set the price defalut value

        $value.on('input change', () => {
            $('.char_to').val($value.val());
            if ($value.val() == 0) {
                $charTo.val('');
            }
        });


        $priceValue.on('input change', () => {
            priceCount = $("#price_slider").val();
            if (priceCount >= 17000) {
                $priceTo.val('');
            } else {
                $priceTo.val($priceValue.val());

            }
        });
    });

    $("#buttonAjaxFilter").on('click', function () {
        $("#ajax-search-form").trigger('submit');
    });

    var ajaxFilterDomains = $("#ajax-search-form");

    ajaxFilterDomains.submit(function (event) {

        console.log('form submitted')

        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: "{{route('ajax.domainfiltering')}}",
            data: formData,
            cache: false,
            beforeSend: function () {
                $('.preload-search').show();
                $('#ajax-filtered-domains').hide();
            },
            success: function (data) {
                $('.preload-search').hide();
                $('#ajax-filtered-domains').show();
                $('#ajax-filtered-domains').html(data);
            },
            error: function (data) {

                $('.preload-search').hide();
                $('#ajax-filtered-domains').show();
                sweetAlert("Oops...", data, "error");

            }
        });

        return false;
    });

</script>
@endpush
@endsection
