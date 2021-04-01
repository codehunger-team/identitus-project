@extends('admin.base')

@section('section_title')
    <strong>Set Terms</strong>
    <br /><br />
    {{-- <a href="{{ url()->previous() }}" class="btn btn-default btn-xs">Go Back</a> --}}
    <h1 class="text-center">{{$domainName}}</h1>
@endsection
@section('section_body')
@if($isLease != 'LEASE') 
<form method="POST" enctype="multipart/form-data" action="{{url('admin/add-terms')}}">
        @csrf
@endif
        <div class="col-xs-12 col-md-6">
            <label>First Payment</label><br />
        <input type="number" class="form-control firstPayment" name="first_payment" id="firstPayment" placeholder="First Payment" {{ $isLease == 'LEASE' ? 'disabled' : '' }} value="{{$contracts->first_payment ?? ''}}">
        </div>
        <input type="hidden" name="domain_id" value="{{$domainId}}">
        <input type="hidden" name="domain" value="{{$domainName}}">
        <input type="hidden" name="lessor_id" value="0">
        <div class="col-xs-12 col-md-6">
            <label for="periodPayments">Period Payments ($)</label>
        <input type="text" {{ $isLease == 'LEASE' ? 'disabled' : '' }} class="form-control periodPayment" name="period_payment" id="periodPayments" placeholder="$500" value="{{$contracts->period_payment ?? ''}}">
        </div>
        <div class="col-xs-12 col-md-6">
            <label for="periodPayments">Period Type</label>
            <select name="period_type_id" {{ $isLease == 'LEASE' ? 'disabled' : '' }} class="form-control period" required="">
                <option selected disabled value="">Select Period Type</option>
                @if(count($periods))
                    @foreach($periods as $p)
                        <option value="{{$p->id}}" @if(isset($contracts->period_type_id) && $contracts->period_type_id  == $p->id) selected @endif>{{$p->period_type}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-xs-12 col-md-6">
            <label for="periods">Periods</label>
        <input type="number" class="form-control period" {{ $isLease == 'LEASE' ? 'disabled' : '' }} id="periods" name="number_of_periods" value="{{$contracts->number_of_periods ?? ''}}" placeholder="Periods">
        </div>
        <div class="col-xs-12 col-md-6">
            <label for="optionPurchasePrice">Option Purchase Price ($)</label>
        <input type="number" class="form-control" {{ $isLease == 'LEASE' ? 'disabled' : '' }} id="optionPurchasePrice" name="option_price" value="{{$contracts->option_price ?? ''}}" placeholder="$50,000">
        </div>
        <div class="col-xs-12 col-md-6">
            <label for="gracePeriod">Option Expiration</label>
            <select class="form-control" id="periodPayments"  name="option_expiration" disabled required>
                <option>Select purchase option expiration point</option>
                @if(count($options))
                        @php
                            $selected = 6;
                        @endphp
                    @foreach($options as $o)
                        <option value={{$o->id}}  @if($selected == $o->id) selected @endif>{{$o->option_expiration}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-xs-12 col-md-6">
                {{--Auto-calculates based on terms. (No. of periods x rate per period.)--}}
            <label for="leaseTotal">Lease Total ($)</label>
        <input type="text" class="form-control" name="lease_total" id="leaseTotal" placeholder="Lease Total" value="{{$contracts->lease_total ?? ''}}" disabled>
        </div>
        <div class="col-xs-12 col-md-6">
                {{--            Number Percentage--}}
            <label for="annualIncrease">Annual Increase (%)</label>
        <input type="number" class="form-control" id="annualIncrease" name="annual_increase" placeholder="3" value="0" disabled>
        </div>
        <div class="col-xs-12 col-md-6">
                {{--            Number Percentage--}}
        <label for="annualTowardsPurchase">Annual Towards Purchase (%)</label>
        <input type="number" class="form-control" id="annualTowardsPurchase" name="annual_towards_purchase" placeholder="3" value="0" disabled>
        </div>
        <div class="col-xs-12 col-md-6">
            <label for="gracePeriod">Grace Period</label>
            <select class="form-control" id="periodPayments" name="grace_period_id" disabled required>
                <option selected disabled value="">Select Grace Period</option>
                @if(count($graces))
                    @php $selectedGrace = 4; @endphp
                    @foreach($graces as $g)
                        <option value={{$g->id}} @if($selectedGrace == $g->id) selected @endif>{{$g->grace_period}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    @if($isLease != 'LEASE')
        <div class="col-xs-12 col-md-6" style="margin-top:2%">
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </form>
    @endif
    </div>
@endsection