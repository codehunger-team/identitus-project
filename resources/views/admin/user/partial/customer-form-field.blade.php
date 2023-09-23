<div class="card border-0 p-3 shadow my-3 customer-form">
    <div class="row">
        <div class="card-header border-0 bg-white mb-3">
            <h4 class="text-muted">Customer</h4>
        </div>
        <div class="col-md-6">
            <dl>
                Name
                <dd>
                    <input type="text" name="name" class="form-control customer-form-value customer-form-value">
                </dd>
            </dl>
        </div>
        <div class="col-md-6">
            <dl>
                Email
                <dd>
                    <input type="email" name="email" class="form-control customer-form-value">
                </dd>
            </dl>
        </div>
        <div class="col-md-6">
            <div class="form-label-group mb6">
                <label for="phone">Phone</label>
                <input type="text" onkeypress="if(this.value.length==10) return false;" name="phone"
                    class="form-control customer-form-value" value="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-label-group mb6">
                <label for="company">Company</label>
                <input type="text" name="company" id="company" class="form-control customer-form-value"
                    value="">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-label-group mb6">
                <label for="country">Country</label>
                <input type="text" id="country" name="country" class="form-control customer-form-value"
                    value="">
            </div>
        </div>


        <div class="col-lg-6">
            <div class="form-label-group mb6">
                <label for="state">State</label>
                <input type="text" name="state" id="state" class="form-control customer-form-value " value="">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-label-group mb6">
                <label for="city">City</label>
                <input type="text" id="city" name="city" class="form-control customer-form-value" value="">
            </div>
        </div>


        <div class="col-lg-6">
            <div class="form-label-group mb6">
                <label for="stree1">Street 1</label>
                <input type="text" name="street_1" id="stree1" class="form-control customer-form-value " value="">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-label-group mb6">
                <label for="street2">Street 2</label>
                <input type="text" id="street2" name="street_2" class="form-control customer-form-value " autofocus="" value="">
            </div>
        </div>


        <div class="col-lg-6">
            <div class="form-label-group mb6">
                <label for="zip">ZIP</label>
                <input type="number" name="zip" id="zip" class="form-control customer-form-value " value="">
            </div>
        </div>
        <div class="col-md-6">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror customer-form-value" name="password" autocomplete="new-password">
            <div id="passwordHelpBlock" class="form-text">
                Your password must be 8-20 characters long, contain letters,numbers,special
                character and must not contain spaces or emoji.
            </div>
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" type="password" onChange="checkPasswordMatch();" class="form-control customer-form-value" name="password_confirmation" autocomplete="new-password">
            <div id="divCheckPasswordMatch">
            </div>
        </div>
    </div>
</div>