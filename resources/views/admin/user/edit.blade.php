@extends('admin.base')

@section('section_title')
<div class="row">
    <div class="col-sm-6">
        <strong>Edit User</strong>
    </div>
    <div class="col-sm-6">
        <a href="{{route('admin.users')}}" class="btn btn-primary btn-xs float-right">Back to User's List</a>
    </div>
</div>
@endsection

@section('section_body')
<form method="POST" enctype="multipart/form-data" action="{{ route('admin.user.update', $user['id']) }}">
    @csrf
    <input hidden value="{{ $user['id'] }}" name="user_id">
    <div class="card border-0 p-3 shadow my-3">
        <div class="row">
            <div class="card-header border-0 bg-white mb-3">
                <h4 class="text-muted user-heading">User Type</h4>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="isAdmin">User Type <span class="text-danger">*</span></label>
                    <select id="isAdmin" name="user_type" class="form-control">
                        <option value="admin" {{ ($user['admin'] == 1) ? 'selected' : '' }}>Admin</option>
                        <option value="vendor" {{ ($user['is_vendor'] == 'yes' && $user['admin'] != 1) ? 'selected' : '' }}>Vendor</option>
                        <option value="user" {{ ($user['is_vendor'] == 'no') ? 'selected' : '' }}>Customer</option>
                    </select>
                    @error('is_admin')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
    </div>
    <div @if($user['admin']==1) style="display:block" @else style="display:none" @endif class="card border-0 p-3 shadow my-3 admin-form">
        <div class="row">
            <div class="card-header border-0 bg-white mb-3">
                <h4 class="text-muted user-heading">User Details</h4>
            </div>
            <div class="col-md-6">
                <dl>
                    Name
                    <dd>
                        <input value="{{ $user['name'] }}" type="text" name="name" class="form-control customer-form-value customer-form-value">
                    </dd>
                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                </dl>
            </div>
            <div class="col-md-6">
                <dl>
                    Email
                    <dd>
                        <input value="{{ $user['email'] }}" type="email" name="email" class="form-control customer-form-value">
                    </dd>
                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                </dl>
            </div>
            <div class="col-md-6">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror customer-form-value" name="password" autocomplete="new-password">
                <div id="passwordHelpBlock" class="form-text">
                    Your password must be 8-20 characters long, contain letters,numbers,special
                    character and must not contain spaces or emoji.
                </div>
                @error('password')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="col-md-6">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" onChange="checkPasswordMatch();" class="form-control customer-form-value" name="password_confirmation" autocomplete="new-password">
                <div id="divCheckPasswordMatch">
                </div>
                @error('password_confirmation')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>
    <div @if($user['admin'] !=1) style="display:block" @else style="display:none" @endif class="card border-0 p-3 shadow my-3 user-form">
        <div class="row">
            <div class="card-header border-0 bg-white mb-3">
                <h4 class="text-muted user-heading">User Details</h4>
            </div>
            <div class="col-md-6">
                <dl>
                    Name
                    <dd>
                        <input value="{{ $user['name'] }}" type="text" name="name" class="form-control customer-form-value customer-form-value">
                    </dd>
                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                </dl>
            </div>
            <div class="col-md-6">
                <dl>
                    Email
                    <dd>
                        <input value="{{ $user['email'] }}" type="email" name="email" class="form-control customer-form-value">
                    </dd>
                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                </dl>
            </div>
            <div class="col-md-6">
                <div class="form-label-group mb6">
                    <label for="phone">Phone</label>
                    <input value="{{ $user['phone'] }}" type="text" onkeypress="if(this.value.length==10) return false;" name="phone" class="form-control customer-form-value" value="">
                    @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-label-group mb6">
                    <label for="company">Company</label>
                    <input value="{{ $user['company'] }}" type="text" name="company" id="company" class="form-control customer-form-value" value="{{ $user['company'] }}">
                    @error('company')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-label-group mb6">
                    <label for="country">Country</label>
                    <input value="{{ $user['country'] }}" type="text" id="country" name="country" class="form-control customer-form-value" value="">
                    @error('country')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>


            <div class="col-lg-6">
                <div class="form-label-group mb6">
                    <label for="state">State</label>
                    <input value="{{ $user['state'] }}" type="text" name="state" id="state" class="form-control customer-form-value " value="">
                    @error('state')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-label-group mb6">
                    <label for="city">City</label>
                    <input value="{{ $user['city'] }}" type="text" id="city" name="city" class="form-control customer-form-value" value="">
                    @error('city')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>


            <div class="col-lg-6">
                <div class="form-label-group mb6">
                    <label for="stree1">Street 1</label>
                    <input value="{{ $user['street_1'] }}" type="text" name="street_1" id="stree1" class="form-control customer-form-value " value="">
                    @error('street_1')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-label-group mb6">
                    <label for="street2">Street 2</label>
                    <input value="{{ $user['street_2'] }}" type="text" id="street2" name="street_2" class="form-control customer-form-value " autofocus="" value="">
                    @error('street_2')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>


            <div class="col-lg-6">
                <div class="form-label-group mb6">
                    <label for="zip">ZIP</label>
                    <input value="{{ $user['zip'] }}" type="number" name="zip" id="zip" class="form-control customer-form-value " value="">
                    @error('zip')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror customer-form-value" name="password" autocomplete="new-password">
                <div id="passwordHelpBlock" class="form-text">
                    Your password must be 8-20 characters long, contain letters,numbers,special
                    character and must not contain spaces or emoji.
                </div>
                @error('password')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="col-md-6">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" onChange="checkPasswordMatch();" class="form-control customer-form-value" name="password_confirmation" autocomplete="new-password">
                <div id="divCheckPasswordMatch">
                </div>
                @error('password_confirmation')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>
    <div class="col-xs-6">
        <input type="submit" class="btn btn-block btn-primary submit-button">
    </div>
</form>
<script>
    $(document).on('change', '#isAdmin', function() {
        if ($(this).val() == 'admin') {
            $('.admin-form').show();
            $('.user-form').hide();
        } else {
            $('.admin-form').hide();
            $('.user-form').show();
        }
    })

    function checkPasswordMatch() {
        var password = $("#password").val();
        var confirmPassword = $("#password-confirm").val();
        var regularExpression = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9_])/;

        if (confirmPassword.length < 8 && !regularExpression.test(confirmPassword)) {
            $("#divCheckPasswordMatch").html("Password guidelines doesn't match");
            $('#divCheckPasswordMatch').addClass('text-danger');
            $('#divCheckPasswordMatch').removeClass('text-success');
            $('.submit-button').attr('disabled', true);
        } else {
            if (password != confirmPassword) {
                $("#divCheckPasswordMatch").html("Passwords do not match!");
                $('#divCheckPasswordMatch').addClass('text-danger');
                $('#divCheckPasswordMatch').removeClass('text-success');
                $('.submit-button').attr('disabled', true);
            } else {
                $("#divCheckPasswordMatch").html("Passwords match.");
                $('.register-submit-button').removeClass('disabled');
                $('#divCheckPasswordMatch').addClass('text-success');
                $('#divCheckPasswordMatch').removeClass('text-danger');
                $('.submit-button').removeAttr('disabled');
            }
        }
    }
</script>
@endsection