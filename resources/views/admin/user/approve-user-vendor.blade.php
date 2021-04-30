@extends('admin.base')

@section('section_title')
<strong>Users Overview</strong>
<a href="{{route('admin.users')}}" class="btn btn-primary btn-xs float-end">Back to User's List</a>
@endsection

@section('section_body')
<form method="POST" enctype="multipart/form-data" action="{{url('admin/vendor-approval')}}">
    @csrf
    <div class="row">
        @if($user->is_vendor != 'yes')
        <input type="hidden" name="is_vendor" value="yes">
        @else
        <input type="hidden" name="is_vendor" value="no">
        @endif
        <input type="hidden" name="user_id" value={{$user->id}}>
        <div class="col-xs-12 col-md-6">
            <label>Name</label><br />
            <input type="text" class="form-control" readonly placeholder="name" value="{{$user->name ?? ''}}">
        </div>
        <div class="col-xs-12 col-md-6">
            <label>Email</label>
            <input type="email" class="form-control periodPayment" readonly placeholder="email"
                value="{{$user->email ?? ''}}">
        </div>
        <div class="col-xs-12 col-md-6">
            <label>Phone</label>
            <input type="number" class="form-control" readonly placeholder="phone" value="{{$user->phone ?? ''}}">
        </div>
        <div class="col-xs-12 col-md-6">
            <label>Company</label>
            <input type="text" class="form-control period" readonly value="{{$user->company ?? ''}}"
                placeholder="company">
        </div>
        <div class="col-xs-12 col-md-6">
            <label>Country</label>
            <input type="text" class="form-control" readonly value="{{$user->country ?? ''}}" placeholder="country">
        </div>
        <div class="col-xs-12 col-md-6">
            <label>State</label>
            <input type="text" class="form-control" readonly value="{{$user->state ?? ''}}" placeholder="state">
        </div>
        <div class="col-xs-12 col-md-6">
            <label>City</label>
            <input type="text" class="form-control" readonly placeholder="city" value="{{$user->city ?? ''}}">
        </div>
        <div class="col-xs-12 col-md-6">
            <label>Street 1</label>
            <input type="text" class="form-control" readonly placeholder="street 1" value="{{$user->street_1 ?? ''}}">
        </div>
        <div class="col-xs-12 col-md-6">
            <label>Street 2</label>
            <input type="text" class="form-control" readonly placeholder="street 2" value="{{$user->street_2 ?? ''}}">
        </div>
        <div class="col-xs-12 col-md-6" style="margin-bottom: 2%;">
            <label for="gracePeriod">ZIP</label>
            <input type="text" class="form-control" readonly placeholder="ZIP" value="{{$user->zip ?? ''}}">
        </div>
        @if($user->is_vendor != 'yes')
        <div class="col-xs-12 col-md-6" style="margin-top:2%">
            <button type="submit" class="btn btn-success">Approve User</button>
        </div>
        @else
        <div class="col-xs-12 col-md-6" style="margin-top:2%">
            <button type="submit" class="btn btn-danger">Unapprove User</button>
        </div>
        @endif
    </div>
</form>
@endsection
