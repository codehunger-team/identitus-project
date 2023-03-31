@extends('user.base')

@section('section_title')
    <strong>Profile Setting</strong>
@endsection
@section('section_body')
   
<form method="POST" enctype="multipart/form-data" action="{{route('user.update')}}">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <label>Name</label><br />
                <input type="text" class="form-control" name="name"  placeholder="name" value="{{$user->name ?? ''}}">
            </div>
            <div class="col-xs-12 col-md-6">
                <label>Email</label>
                <input type="email" class="form-control periodPayment" name="email" placeholder="email" value="{{$user->email ?? ''}}">
            </div>
            <div class="col-xs-12 col-md-6">
                <label>Phone</label>
                <input type="number" class="form-control" name="phone"  placeholder="phone" value="{{$user->phone ?? ''}}">
            </div>
            <div class="col-xs-12 col-md-6">
                <label>Company</label>
                <input type="text" class="form-control period" name="company" value="{{$user->company ?? ''}}" placeholder="company">
            </div>
            <div class="col-xs-12 col-md-6">
                <label>Country</label>
                <input type="text" class="form-control" name="country" value="{{$user->country ?? ''}}" placeholder="country">
            </div>
            <div class="col-xs-12 col-md-6">
                <label>State</label>
                <input type="text" class="form-control" name="state" value="{{$user->state ?? ''}}" placeholder="state">
            </div>
            <div class="col-xs-12 col-md-6">
                <label>City</label>
                <input type="text" class="form-control" name="city" placeholder="city" value="{{$user->city ?? ''}}">
            </div>
            <div class="col-xs-12 col-md-6">
                <label>Street 1</label>
                <input type="text" class="form-control" name="street_1" placeholder="street 1" value="{{$user->street_1 ?? ''}}">
            </div>
            <div class="col-xs-12 col-md-6">
                <label>Street 2</label>
                <input type="text" class="form-control" name="street_2" placeholder="street 2" value="{{$user->street_2 ?? ''}}">
            </div>
            <div class="col-xs-12 col-md-6">
                <label for="gracePeriod">ZIP</label>
                <input type="text" class="form-control" name="zip" placeholder="ZIP" value="{{$user->zip ?? ''}}">
            </div>
            @if($user->is_vendor == 'no' || empty($user->is_vendor))
            {{-- <div class="col-xs-12 col-md-6">
                <label for="Become Vendor">Become Vendor</label>
                <select name="is_vendor" id="apply-for-vendor" class="form-control">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div> --}}
            <div class="col-xs-12 col-md-4">
                <label>Old Password</label>
                <input type="password" class="form-control" name="old_password" placeholder="**********">
            </div>
            <div class="col-xs-12 col-md-4">
                <label>New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="**********">
            </div>
            <div class="col-xs-12 col-md-4">
                <label>Confirm New Password</label>
                <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" placeholder="**********">
                <span id='message'></span>
            </div>
            @if(Session::has('docusign'))
            @php
            $clickwrap = Session::get('docusign');
            @endphp
            @include('user.lessee.docusign.become-vendor-terms')
            @endif
            <div class="col-xs-12 col-md-6 mt-4">
                <h4>Become a vendor to lease or sell your domains by marking the checkbox.</h4>
            </div>
            <div class="col-xs-12 col-md-6 mt-4">
                <a href="{{route('sign.document','terms.pdf')}}" id="become-vendor" class="btn btn-primary btn-sm btn-block text-center">Become Vendor</a>
            </div>
            
            @else  
            <div class="col-xs-12 col-md-4">
                <label>Old Password</label>
                <input type="password" class="form-control" name="old_password" placeholder="**********">
            </div>
            <div class="col-xs-12 col-md-4">
                <label>New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="**********">
            </div>
            <div class="col-xs-12 col-md-4">
                <label>Confirm New Password</label>
                <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" placeholder="**********">
                <span id='message'></span>
            </div>
            @endif
            {{-- <p>You are about to make a public offer by setting your domain lease terms, and are agreeing to Identitius Terms of Use, and making a legal offer that another party may accept and execute. We want our market to function with as little friction as possible, and request that you honor your public offer if accepted by another party. </p> --}}
            <div class="col-xs-12 col-md-6" style="margin-top:2%">
                <button type="submit" class="btn btn-success" id="profile-submit-button">Submit</button>
            </div>
        </div>
</form>
<script>
    $(document).on('click',	'#become-vendor', function(){
        $(this).addClass('disabled');
        $(this).text('Redirecting to terms page ...')
    });
</script>
@endsection