@extends('layouts.app')
@section('seo_keys'){{$domain->tags ?? ''}}@endsection
@section('seo_desc'){{$domain->short_description ?? ''}}@endsection
@section('seo_title') {{$domainName ?? ''}} - {!! \App\Models\Option::get_option('seo_title') !!}
@endsection
@push('styles')
<style>
    @media (max-width: 767px) {
        .desktop-dt {
            display: none;
        }
    }

    @media (max-width: 767px) {
        .width-50 {
            width: 100%;
            margin: 0 auto;
        }
    }

    .width-50 {
        width: 100%;
        margin: 0 auto;
    }
</style>
@endpush
@section('content')
<div class="container">
    <div class="section-title">
        @include('front.components.alert')
        @if(Session::has('docusign'))
        @php
        $clickwrap = Session::get('docusign');
        @endphp
        @include('front.review.docusign')
        @endif
        <h4 class="text-center text-muted">The primary lease terms for...</h4>
        <!-- Depending upon how this is handled, this page can be a form with changable fields or simply a static page to review. -->
        <h2 class="mb-10 text-center" style="margin-bottom:5%">{{$domainName ?? ''}}</h2>
        <div class="alert alert-success alert-block" role="alert" style="display: none;" id="main">
            <button class="close" data-dismiss="alert"></button>
            Profile updated successfully.
        </div>
        <div class="card width-50">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <td>First Payment ($)</td>
                        <td>{{$contracts->first_payment ?? ''}}</td>
                    </tr>
                    <tr>
                        <td>Period Payment ($)</td>
                        <td>{{$contracts->period_payment ?? ''}}</td>
                    </tr>
                    <tr>
                        <td>Period Type</td>
                        <td>
                            @if(count($periods))
                            @foreach($periods as $p)
                            @if($contracts->period_type_id == $p->id)
                            {{ $p->period_type }}
                            @endif
                            @endforeach
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Periods</td>
                        <td>
                            {{ $contracts->number_of_periods ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Option Purchase Price ($)</td>
                        <td>
                            {{ $contracts->option_price ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Option Expiration</td>
                        <td>
                            @if(count($options))
                            @foreach($options as $o)
                            @if($contracts->option_expiration == $o->id)
                            {{ $o->option_expiration }}
                            @endif
                            @endforeach
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Lease Total ($)</td>
                        <td>
                            {{ $leasetotal ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Lease Start</td>
                        <td>
                            {{app('App\Helpers\DateTimeHelper')->ConvertIntoUTC($getCurrentDateTime) ?? ''}}
                        </td>
                    </tr>
                    <tr>
                        <td>Lease End</td>
                        <td>
                            {{app('App\Helpers\DateTimeHelper')->ConvertIntoUTC($endOfLease) ?? ''}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <p>By clicking 'Review Lease' the basic lease and option terms above will be added to the full lease and
            option to purchase agreement below for your detailed review and digital signature. This is the surest
            and fastest path to a agreeable lease contract between you and the Domain Lessor. If you prefer to
            negotiate these terms with the Lessor, <a href="#">you may attempt to do so here</a>, but please be
            aware that the Lessor may withdraw their original offer to lease.</p>
        <div class="text-center">
            @if(Auth::check())

            <a href="{{route('sign.document',$domainName)}}"><button class="btn btn-primary btn-block text-center ml-2 mb-4 mt-5 w-30 lease-now">Lease Now</button></a>&nbsp;

            <a href="javascript:void(0)">
                @if($isAlreadyCounterOffered != 1)
                <button class="btn btn-primary edit-lease-counter btn-block text-white text-center mb-4 mt-5" id="{{$contracts->contract_id}}" data-bs-toggle="modal" data-bs-target="#counterModal">Counter Lease
                </button>
                @endif
            </a>
            @else
            <a href="{{route('login')}}" class="btn btn-primary"> Login to Lease</a>
            @endif
        </div>
        @include('front.components.review-term-counter-modal')
    </div>
</div>
@endsection
@push('scripts')
<script>
    // edit counter modal code
    $(document).on('click', '.edit-lease-counter', function() {
        id = $(this).attr('id');
        var url = '{{ route("edit.counter", ":id") }}';
        url = url.replace(':id', id);
        axios({
                method: 'GET',
                url: url,
            }).then((res) => {
                $('#first-payment').val(res.data.first_payment);
                $('#periodPayment').val(res.data.period_payment);
                $('#period').val(res.data.number_of_periods);
                $('#option-purchase-price').val(res.data.option_price);
                $('#counter-id').val(res.data.contract_id);
                $('#lessor-id').val(res.data.lessor_id);
                $("#counter-modal").modal('show');
            })
            .catch((err) => {
                throw err
            });
    });

    $(document).on('click', '.lease-now', function() {
        $('.lease-now').attr('disabled', true)
        $(this).text('Redirecting you to docusign ....');
    });
    $(document).on('click', '.lease-counter', function() {
        $('.lease-now').attr('disabled', true)
        $(this).text('Sending mail to the owner ....');
    });

    //count offer form sumission
    $('#counter-form-submit').on('click', function(e) {
        e.preventDefault();
        $('#counter-form-submit').attr('disabled', true);
        $('#first-payment-error').html("");
        $('#periodPayment-error').html("");
        $('#period-error').html("");
        $('#option-purchase-price-error').html("");
        $.ajax({
            type: "POST",
            url: "{{ route('counter') }}",
            data: $('form.counter-form').serialize(),
            success: function(response) {
                if (response.errors) {
                    if (response.errors.first_payment) {
                        $('#first-payment-error').html(response.errors.first_payment[0]);
                        $('#first-payment').addClass('border-danger');
                    } else {
                        $('#first-payment').removeClass('border-danger');
                    }

                    if (response.errors.period_payment) {
                        $('#periodPayment-error').html(response.errors.period_payment[0]);
                        $('#periodPayment').addClass('border-danger');
                    } else {
                        $('#periodPayment').removeClass('border-danger');
                    }

                    if (response.errors.number_of_periods) {
                        $('#period-error').html(response.errors.number_of_periods[0]);
                        $('#period').addClass('border-danger');
                    } else {
                        $('#period').removeClass('border-danger');
                    }

                    if (response.errors.option_purchase_price) {
                        $('#option-purchase-price-error').html(response.errors
                            .option_purchase_price[0]);
                        $('#option-purchase').addClass('border-danger');
                    } else {
                        $('#option-purchase').removeClass('border-danger');
                    }

                }
                if (response.success) {
                    location.reload();
                }
            },
            error: function() {
                location.reload();
            }
        });
        return false;
    });
</script>
@endpush