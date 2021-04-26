@extends('admin.base')

@section('section_title')
    <strong>Nameserver</strong>
    </br></br>
    <a href="{{route('admin.active.lease')}}" class="btn btn-default btn-xs">Back to Lease Overview</a>
@endsection

@section('section_body')
    <div class="col-xs-12 col-md-6">
    <input type ="hidden" name="domain_id" value="{{$domainId}}">
        {{-- Nameserver 1--}}
        <label for="firstNameserver">First Nameserver</label><br />
    <input type="string" class="form-control" name="identitius_nameserver1" id="firstNameserver" placeholder="ns1.identitius.com" readonly value="{{$dns->identitius_nameserver1 ?? ''}}">
    </div>
    <div class="col-xs-12 col-md-6">
        {{-- Nameserver 2--}}
        <label for="secondNameserver">Second Nameserver</label>
        <input type="string" class="form-control" name="identitius_nameserver2" id="secondNameserver" placeholder="ns2.identitius.com" readonly value="{{$dns->identitius_nameserver2 ?? ''}}">
    </div>
    <div class="col-xs-12 col-md-6">
        {{-- Nameserver 3--}}
        <label for="thirdNameserver">Third Nameserver</label>
        <input type="string" class="form-control" readonly id="thirdNameserver" placeholder="optional">
    </div>
    <div class="col-xs-12 col-md-6">
        {{-- Nameserver 4--}}
        <label for="fourthNameserver">Fourth Nameserver</label>
        <input type="string" class="form-control" readonly id="fourthNameserver" placeholder="optional">
    </div>
@endsection