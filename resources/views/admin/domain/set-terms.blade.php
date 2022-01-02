@extends('user.base')
@section('section_title')
<strong>Set Terms</strong>
<a href="{{route('admin.domain')}}" class="btn btn-primary btn-xs float-end">Back</a>
<br /><br />
<h1 class="text-center">{{$domainName}}</h1>
@endsection
@section('section_body')
@php
    $clickwrap = Session::get('docusign');
@endphp
@isset($clickwrap)
    @include('partials.docusign')
@endisset
@if($isInNegotiation)
    <h5 class="card-title">Lessee Counter Price</h5>
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <label>First Payment</label><br>
                <input type="number" class="form-control firstPayment" name="first_payment" id="firstPayment"
                    disabled=""  value="{{$isInNegotiation->first_payment}}">
            </div>
            <input type="hidden" name="domain_id" value="9">
            <input type="hidden" name="domain" value="sachin.in">
            <input type="hidden" name="lessor_id" value="0">
            <div class="col-xs-12 col-md-6">
                <label for="periodPayments">Period Payments ($)</label>
                <input type="number" class="form-control periodPayment" name="period_payment" id="periodPayments"
                    disabled="" value="{{$isInNegotiation->period_payment}}">
            </div>
            <div class="col-xs-12 col-md-6">
                <label for="periodPayments">Period Type</label>
                <select name="period_type_id" {{ $isLease == 'LEASE' ? 'disabled' : '' }} class="form-control period"
                   disabled="">
                    <option selected value="">Select Period Type</option>
                    @if(count($periods))
                    @foreach($periods as $p)
                    <option value="{{$p->id}}" @if(isset($contracts->period_type_id) && $contracts->period_type_id ==
                        $p->id)
                        selected @endif>{{$p->period_type}}
                    </option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="col-xs-12 col-md-6">
                <label for="periods">Periods</label>
                <input type="number" class="form-control period" id="periods" disabled="" name="number_of_periods" value="{{$isInNegotiation->number_of_periods}}"
                   >
            </div>
            <div class="col-xs-12 col-md-6">
                <label for="optionPurchasePrice">Option Purchase Price ($)</label>
                <input type="number" class="form-control" id="optionPurchasePrice" disabled="" name="option_price" value="{{$isInNegotiation->option_purchase_price}}"
                   >
            </div>
            <div class="col-xs-12 col-md-6">
                <label for="gracePeriod">Option Expiration</label>
                <select class="form-control" id="periodPayments" name="option_expiration" disabled="">
                    <option>Select purchase option expiration point</option>
                    <option value="1">1 month prior to lease expiration</option>
                    <option value="2">2 weeks prior to lease expiration</option>
                    <option value="3">3 days prior to lease expiration</option>
                    <option value="4">2 days prior to lease expiration</option>
                    <option value="5">1 day prior to lease expiration</option>
                    <option value="6" selected="">simultaneous with lease expiration</option>
                </select>
            </div>
            <div class="col-xs-12 col-md-6">
                <label for="gracePeriod">Grace Period</label>
                <select class="form-control" id="periodPayments" name="grace_period_id" disabled="" required="">
                    <option selected="" disabled="" value="">Select Grace Period</option>
                    <option value="1">30</option>
                    <option value="2">15</option>
                    <option value="3">10</option>
                    <option value="4" selected="">5</option>
                    <option value="5">4</option>
                    <option value="6">3</option>
                    <option value="7">2</option>
                    <option value="8">1</option>
                    <option value="9">0</option>
                </select>
            </div>
            <div class="col-xs-12 col-md-6">
                <label for="leaseTotal">Lease Total ($)</label>
                <input type="text" class="form-control" placeholder="Lease Total"
                    value="{{$isInNegotiation->lease_total}}" disabled="">
            </div>
        </div>
    <hr>
@endif
@if($isLease != 'LEASE')
<h5 class="card-title">Set/Update Terms</h5>
<form method="POST" id="form" enctype="multipart/form-data set-terms-form" action="{{url('user/add-terms')}}">
    @csrf
    @endif
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <label>First Payment</label><br />
            <input type="number" class="form-control firstPayment" name="first_payment" id="firstPayment"
                 required {{ $isLease == 'LEASE' ? 'disabled' : '' }}
                value="{{$contracts->first_payment ?? old('first_payment')}}">
        </div>
        <input type="hidden" name="domain_id" value="{{$domainId}}">
        <input type="hidden" name="domain" value="{{$domainName}}">
        <input type="hidden" name="lessor_id" value="0">
        <div class="col-xs-12 col-md-6">
            <label for="periodPayments">Period Payments ($)</label>
            <input type="number" class="form-control periodPayment" name="period_payment" id="periodPayments"
                 {{ $isLease == 'LEASE' ? 'disabled' : '' }} required
                value="{{$contracts->period_payment ?? old('period_payment')}}">
        </div>
        <div class="col-xs-12 col-md-6">
            <label for="periodPayments">Period Type</label>
            <select name="period_type_id" {{ $isLease == 'LEASE' ? 'disabled' : '' }} class="form-control period"
                readonly>
                <option value="3" selected="">Month</option>
                {{-- <option selected value="">Select Period Type</option>
                @if(count($periods))
                    @foreach($periods as $p)
                    <option value="{{$p->id}}" @if(isset($contracts->period_type_id) || $p->id ==
                        3)
                        selected @endif>{{$p->period_type}}</option>
                    @endforeach
                @endif --}}
            </select>
        </div>
        <div class="col-xs-12 col-md-6">
            <label for="periods">Periods</label>
            <input type="number" {{ $isLease == 'LEASE' ? 'disabled' : '' }} class="form-control period" id="periods"
                name="number_of_periods" value="{{$contracts->number_of_periods ?? old('number_of_periods')}}">
        </div>
        <div class="col-xs-12 col-md-6">
            <label for="optionPurchasePrice">Option Purchase Price ($)</label>
            <input type="number" {{ $isLease == 'LEASE' ? 'disabled' : '' }} class="form-control"
                id="optionPurchasePrice" name="option_price" value="{{$contracts->option_price ?? old('option_price')}}"
                >
        </div>
        <div class="col-xs-12 col-md-6">
            <label for="gracePeriod">Option Expiration</label>
            <select class="form-control" id="periodPayments" name="option_expiration" readonly required>
                <option value="6" selected="">simultaneous with lease expiration</option>
                {{-- <option>Select purchase option expiration point</option>
                @if(count($options))
                @php
                $selected = 6;
                @endphp
                @foreach($options as $o)
                <option value={{$o->id}} @if($selected==$o->id) selected @endif>{{$o->option_expiration}}</option>
                @endforeach
                @endif --}}
            </select>
        </div>
        <div class="col-xs-12 col-md-6">
            <label for="gracePeriod">Grace Period</label>
            <select class="form-control" id="periodPayments" name="grace_period_id" readonly required>
                <option value="4" selected="">5</option>
                {{-- <option selected disabled value="">Select Grace Period</option>
                @if(count($graces))
                @php $selectedGrace = 4; @endphp
                @foreach($graces as $g)
                <option value={{$g->id}} @if($selectedGrace==$g->id) selected @endif>{{$g->grace_period}}</option>
                @endforeach
                @endif --}}
            </select>
        </div>
        <div class="col-xs-12 col-md-6">
            {{--Auto-calculates based on terms. (No. of periods x rate per period.)--}}
            <label for="leaseTotal">Lease Total ($)</label>
            <input type="text" class="form-control" name="lease_total" id="leaseTotal" 
                value="{{$contracts->lease_total ?? ''}}" disabled>
        </div>
        {{-- <div class="col-xs-12 col-md-6">
            <label for="annualIncrease">Annual Increase (%)</label>
            <input type="number" class="form-control" id="annualIncrease" name="annual_increase" placeholder="3"
                value="0" disabled>
        </div>
        <div class="col-xs-12 col-md-6">
            <label for="annualTowardsPurchase">Annual Towards Purchase (%)</label>
            <input type="number" class="form-control" id="annualTowardsPurchase" name="annual_towards_purchase"
                placeholder="3" value="0" disabled>
        </div> --}}
        @if($isLease != 'LEASE')
        <div class="col-xs-12 col-md-6" style="margin-top:2%">
            <button type="submit" class="btn btn-primary call-docusign">Submit</button>
            @if($isInNegotiation)
                <a href="{{route('counter.offer',$domainName)}}" class="btn btn-success">Counter</a>
            @endif
        </div>
    </div>
</form>
@endif
</div>
@endsection
