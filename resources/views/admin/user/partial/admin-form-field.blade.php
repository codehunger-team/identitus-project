<div class="card border-0 p-3 shadow my-3 admin-form">
    <div class="row">
        <div class="card-header border-0 bg-white mb-3">
            <h4 class="text-muted">Admin User</h4>
        </div>
        <div class="col-md-6">
            <dl>
                Name
                <dd>
                    <input type="text" name="name" class="form-control admin-form-value">
                </dd>
            </dl>
        </div>
        <div class="col-md-6">
            <dl>
                Email
                <dd>
                    <input type="email" name="email" class="form-control admin-form-value">
                </dd>
            </dl>
        </div>
        <div class="col-md-6">
            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
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
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
            <input id="password-confirm" type="password" onChange="checkPasswordMatch();" class="form-control" name="password_confirmation" autocomplete="new-password">
            <div id="divCheckPasswordMatch">
            </div>
        </div>
    </div>
</div>