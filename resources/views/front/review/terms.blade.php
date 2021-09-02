@extends('layouts.app')
@section('seo_keys'){{$domain->tags ?? ''}}@endsection
@section('seo_desc'){{$domain->short_description ?? ''}}@endsection
@section('seo_title') {{$domainName ?? ''}} - {!! \App\Models\Option::get_option('seo_title') !!}
@endsection
@section('content')
<div class="container">
    <div class="section-title">
        @include('front.components.alert')
        <h4 class="text-center text-muted">The primary lease terms for...</h4>


        <!-- Depending upon how this is handled, this page can be a form with changable fields or simply a static page to review. -->

        <h2 class="mb-10 text-center" style="margin-bottom:5%">{{$domainName ?? ''}}</h2>
        <div class="alert alert-success alert-block" role="alert" style="display: none;" id="main">
            <button class="close" data-dismiss="alert"></button>
            Profile updated successfully.
        </div>
        <div class="form-group row">
            <div class="col">
                {{--            Currency field--}}
                <label for="firstPayment">First Payment ($)</label>
                <div class="input-group mb-2">
                    <input type="number" class="form-control" id="firstPayment" placeholder="First Payment"
                        value="{{$contracts->first_payment ?? ''}}" readonly>
                </div>
            </div>
            <div class="col">
                {{--            Currency field--}}
                <label for="periodPayments">Period Payments ($)</label>
                <div class="input-group mb-2">
                    <input type="text" class="form-control" placeholder="$500" readonly
                        value="{{$contracts->period_payment ?? ''}}">
                </div>
            </div>
            <div class="col">
                <label for="periodPayments">Period Type</label>
                <div class="input-group mb-2">
                    <select class="form-control" disabled>
                        @if(count($periods))
                        @foreach($periods as $p)
                        <option value="{{$p->id}}" @if($contracts->period_type_id == $p->id) selected
                            @endif>{{$p->period_type}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-1">
                <label for="periods">Periods</label>
                <div class="input-group mb-2">
                    <input type="number" class="form-control" id="periods" placeholder="Periods" readonly
                        value="{{$contracts->number_of_periods ?? ''}}">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col">
                {{--            Currency field--}}
                <label for="optionPurchasePrice">Option Purchase Price ($)</label>
                <div class="input-group mb-2">
                    <input type="number" class="form-control" id="optionPurchasePrice" placeholder="$50,000" readonly
                        value="{{$contracts->option_price ?? ''}}">
                </div>
            </div>
            <div class="col">
                {{-- Date Field, can be dropdown, must include time. (full timestamp)--}}
                <label for="optionPurchasePrice">Option Expiration</label>
                <div class="input-group mb-2">
                    <select class="form-control" disabled>
                        @if(count($options))
                        @foreach($options as $o)
                        <option value={{$o->id}} @if($contracts->option_expiration == $o->id) selected
                            @endif>{{$o->option_expiration}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col">
                {{--Auto-calculates based on terms. (No. of periods x rate per period.)--}}
                <label for="leaseTotal">Lease Total ($)</label>
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="leaseTotal" placeholder="Lease Total" readonly
                        value="{{$leasetotal ?? ''}}">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col">
                {{--            Date/timestamp of the desired start. This is when the lease will actually start and the lessee will have DNS control.--}}
                <label for="leaseTotal">Lease Start</label>
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="leaseStart" placeholder="Lease Start Date and Time"
                        readonly
                        value="{{app('App\Helpers\DateTimeHelper')->ConvertIntoUTC($getCurrentDateTime) ?? ''}}">
                </div>
            </div>
            <div class="col">
                {{--            Auto-calculated based on terms. (Start time, period type, number of periods.)--}}
                <label for="leaseTotal">Lease End</label>
                <div class="input-group mb-2">
                    <input type="text" class="form-control" readonly id="leaseEnd" placeholder="Lease End Date and Time"
                        value="{{app('App\Helpers\DateTimeHelper')->ConvertIntoUTC($endOfLease) ?? ''}}">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col">
                {{--            Number Percentage--}}
                <label for="annualTowardsPurchase">Percent (%) Towards Purchase</label>
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="annualTowardsPurchase" placeholder="3%" readonly
                        value="{{$contracts->accural_rate ?? ''}}">
                </div>
            </div>
            <div class="col">
                <label for="gracePeriod">Grace Period</label>
                <div class="input-group mb-2">
                    <select class="form-control" disabled>
                        @if(count($graces))
                        @foreach($graces as $g)
                        <option value={{$g->id}} @if($contracts->grace_period_id == $g->id) selected
                            @endif>{{$g->grace_period}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <p>By clicking 'Review Lease' the basic lease and option terms above will be added to the full lease and
            option to purchase agreement below for your detailed review and digital signature. This is the surest
            and fastest path to a agreeable lease contract between you and the Domain Lessor. If you prefer to
            negotiate these terms with the Lessor, <a href="#">you may attempt to do so here</a>, but please be
            aware that the Lessor may withdraw their original offer to lease.</p>
        @if(Auth::check())

        <a href="{{route('sign.document',$domainName)}}"><button
                class="btn btn-primary btn-block text-center ml-2 mb-4 mt-5 w-30 lease-now">Lease Now</button></a>&nbsp;

        <a href="javascript:void(0)"><button
                class="btn btn-primary edit-lease-counter btn-block text-white text-center mb-4 mt-5 w-30"
                id="{{$contracts->contract_id}}" {{$isAlreadyCounterOffered == 1 ? 'disabled' : '' }} data-bs-toggle="modal" data-bs-target="#counterModal">Counter
                Lease</button></a>

        @else
        <a href="{{route('login')}}" class="btn btn-primary"> Login to Lease</a>
        @endif
        {{-- @include('front.components.review-term-modal') --}}
        @include('front.components.review-term-counter-modal')
    </div>
</div>

<script>
    // edit counter modal code
    $(document).on('click', '.edit-lease-counter', function () {
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

    $(document).on('click', '.lease-now', function () {
        $('.lease-now').attr('disabled', true)
        $(this).text('Redirecting you to docusign ....');
    });
    $(document).on('click', '.lease-counter', function () {
        $('.lease-now').attr('disabled', true)
        $(this).text('Sending mail to the owner ....');
    });

    //count offer form sumission
    $('#counter-form-submit').on('click', function(e) {
        e.preventDefault();
        $('#counter-form-submit').attr('disabled', true);
        $( '#first-payment-error' ).html( "" );
        $( '#periodPayment-error' ).html( "" );
        $( '#period-error' ).html( "" );
        $( '#option-purchase-price-error' ).html( "" );
        $.ajax({
            type: "POST",
            url: "{{ route('counter') }}",
            data: $('form.counter-form').serialize(),
            success: function(response) {
                if(response.errors) {
                    if(response.errors.first_payment){
                        $( '#first-payment-error' ).html( response.errors.first_payment[0] );
                        $( '#first-payment' ).addClass('border-danger');
                    } else {
                        $( '#first-payment' ).removeClass('border-danger');
                    }

                    if(response.errors.period_payment){
                        $( '#periodPayment-error' ).html( response.errors.period_payment[0] );
                        $( '#periodPayment' ).addClass('border-danger');
                    } else {
                        $( '#periodPayment' ).removeClass('border-danger');
                    }

                    if(response.errors.number_of_periods){
                        $( '#period-error' ).html( response.errors.number_of_periods[0] );
                        $( '#period' ).addClass('border-danger');
                    } else {
                        $( '#period' ).removeClass('border-danger');
                    }

                    if(response.errors.option_purchase_price){
                        $( '#option-purchase-price-error' ).html( response.errors.option_purchase_price[0] );
                        $( '#option-purchase' ).addClass('border-danger');
                    } else {
                        $( '#option-purchase' ).removeClass('border-danger');
                    }
                    
                }
                if(response.success) {
                    $('.counter-form')[0].reset();
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
@endsection
