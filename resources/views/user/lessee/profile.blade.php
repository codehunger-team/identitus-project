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
            <div class="col-xs-12 col-md-6">
                <label for="Become Vendor">Become Vendor</label>
                <select name="is_vendor" id="apply-for-vendor" class="form-control">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div class="col-xs-12 col-md-6">
                <label>Old Password</label>
                <input type="password" class="form-control" name="old_password" placeholder="**********">
            </div>
            <div class="col-xs-12 col-md-6">
                <label>New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="**********">
            </div>
            <div class="col-xs-12 col-md-6">
                <label>Confirm New Password</label>
                <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" placeholder="**********">
                <span id='message'></span>
            </div>

            <div class="col-xs-12 col-md-6 mt-4">
                <h4>Become a vendor to lease or sell your domains by marking the checkbox.</h4>
            </div>
            <div class="col-xs-12 col-md-6 mt-4">
                <input class="form-check-input" type="checkbox" id="become-vendor">
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

<div class="modal fade" id="terms-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Terms to become vendor</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <iframe height="500px" width="460px" src="{{url('pdf/terms.pdf')}}"></iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary discard" data-bs-dismiss="modal">No, I don't agree</button>
          <button type="button" class="btn btn-primary agree">Yes, I agree</button>
        </div>
      </div>
    </div>
</div>
<script>
    $(document).on('click',	'#become-vendor', function(){
        if($(this).is(":checked")) 
        {   
            $('#terms-modal').modal('show');
        }
    });
    $(document).on('click',	'.discard' ,function(){
        $('#become-vendor').prop('checked', false)
    });
    $(document).on('click',	'.agree' ,function(){
        $('#terms-modal').modal('toggle');
        $('#apply-for-vendor').val(1);
        $('#profile-submit-button').trigger('click');
        $('#profile-submit-button').attr('disabled', 'disabled');
        $('#profile-submit-button').text('submiting...');
    });
</script>
@endsection