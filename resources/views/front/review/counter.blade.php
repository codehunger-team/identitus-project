@extends('layouts.app')
@section('content')
<div class="container">
    <div class="section-title">
        @include('front.components.alert')
        @php
            $clickwrap = Session::get('docusign');
        @endphp
        @isset($clickwrap)
            @include('front.components.docusign')
        @endisset
        <h4 class="text-center text-muted"> Negotiation lease terms for...</h4>
        <!-- Depending upon how this is handled, this page can be a form with changable fields or simply a static page to review. -->
        <h2 class="mb-10 text-center" style="margin-bottom:5%">{{$domainName ?? ''}}</h2>
        <div class="alert alert-success alert-block" role="alert" style="display: none;" id="main">
            <button class="close" data-dismiss="alert"></button>
            Counter Lease is updated successfully.
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class='text-center'>Current Price</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="firstPayment">First Payment ($)</label>
                                    <input type="number" class="form-control" id="firstPayment"
                                         value="{{$contracts->first_payment ?? ''}}"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="periodPayments">Period Payments ($)</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{$contracts->period_payment ?? ''}}">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="periods">Periods <span class="text-danger">*</span></label>
                                    <div class="input-group mb-2">
                                        <div class="input-group mb-2">
                                            <input type="number" class="form-control" id="periods" 
                                                readonly value="{{$contracts->number_of_periods ?? ''}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="optionPurchasePrice">Option Purchase Price ($)</label>
                                    <input type="number" class="form-control" id="optionPurchasePrice"
                                        placeholder="$50,000" readonly value="{{$contracts->option_price ?? ''}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class='text-center'>{{Auth::user()->is_vendor == 'yes' || Auth::user()->admin == 1 ? 'Lessee Price' : 'Lessor Price'}}</h4>
                    </div>
                    <div class="card-body">
                        @if($isVendor == 'yes')
                        <h5 class="card-title">{{ $name }}</h5>
                        @else
                        <h5 class="card-title">{{ $name }}</h5>
                        @endif
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="firstPayment">First Payment ($)</label>
                                    <input type="number" name="first_payment" class="form-control" id="first-payments"
                                         value="{{$counterOffer->first_payment ?? ''}}"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="periodPayments">Period Payments ($)</label>
                                    <input type="text" name="period_payment" id="periodPayments" class="form-control"
                                        value="{{$counterOffer->period_payment ?? ''}}" readonly>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="periods">Periods <span class="text-danger">*</span></label>
                                    <div class="input-group mb-2">
                                        <input type="number" name="number_of_periods" class="form-control" id="periods"
                                             value="{{$counterOffer->number_of_periods?? ''}}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="optionPurchasePrice">Option Purchase Price ($)</label>
                                    <input type="number" name="option_purchase_price" class="form-control"
                                        id="option-purchase-prices" 
                                        value="{{$counterOffer->option_purchase_price ?? ''}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            @if(Auth::user()->is_vendor == 'yes')
                                <a href="{{route('accept.offer',$contracts->contract_id)}}"><button class="btn btn-primary disable-button">Accept  Offer</button></a>
                            @else 
                                <a href="{{route('review.terms',$domainName)}}"><button class="btn btn-primary disable-button">Lease Now</button></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class='text-center'>Counter</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <form action="{{ route('counter.contract') }}" method="post" id="counter_vendor"
                                name="counterVendor" enctype="multipart/form-data">
                                @csrf
                                @if(count($errors))
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.
                                    <br />
                                    <ul>
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul></ul>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="firstPayment">First Payment ($)</label>
                                        <input type="number" name="first_payment" class="form-control"
                                            id="first-payment" value="{{Request::old('first_payment')}}"  required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="periodPayments">Period Payments ($)</label>
                                        <input type="text" value="{{Request::old('period_payment')}}" name="period_payment" id="periodPayment" class="form-control"
                                             required>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="periods">Periods <span class="text-danger">*</span></label>
                                        <div class="input-group mb-2">
                                            <input type="number" value="{{Request::old('number_of_periods')}}" name="number_of_periods" class="form-control"
                                                id="period"  required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="optionPurchasePrice">Option Purchase Price ($)</label>
                                        <input type="number" value="{{Request::old('option_purchase_price')}}" name="option_purchase_price" class="form-control"
                                            id="option-purchase-price"  required>
                                    </div>
                                </div>
                                <input type="hidden" value="{{$domainName}}" name="domain_name">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn lease-counter-vendor btn-primary ">Submit</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <br>
<hr>
<script>
    $(document).on('click','.disable-button',function(){
        $(this).attr("disabled", true);
    });
</script>
@endsection
