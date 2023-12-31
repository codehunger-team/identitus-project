@extends('layouts.app')
@section('content')
@if (Session::has('docusign'))
@php
$clickwrap = Session::get('docusign');
@endphp
@include('user.lessee.docusign.become-vendor-terms')
@endif
<div class="container mt-6">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-light">{{ __('Register') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" onsubmit="return validate()">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-6 mb-2">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span style="display: none;" class="invalid-feedback duplicate-email" role="alert">
                                    <strong>Email Account Already Exists</strong> </span>
                            </div>
                        </div>
                        <div class="form-group row mt-2">
                            <div class="col-md-6">
                                <div class="form-label-group mb6">
                                    <label for="phone">Phone</label>
                                    <input type="text" onKeyPress="if(this.value.length==10) return false;" name="phone" class="form-control  @error('phone') is-invalid @enderror" autofocus required value="{{ old('phone') ?? '' }}">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-label-group mb6">
                                    <label for="company">Company</label>
                                    <input type="text" name="company" id="company" class="form-control @error('company') is-invalid @enderror" autofocus required value="{{ old('company') ?? '' }}">
                                    @error('company')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="form-label-group mb6">
                                    <label for="country">Country</label>
                                    <input type="text" id="country" name="country" class="form-control @error('country') is-invalid @enderror" autofocus required value="{{ old('country') ?? '' }}">
                                    @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-label-group mb6">
                                    <label for="state">State</label>
                                    <input type="text" name="state" id="state" class="form-control @error('state') is-invalid @enderror" required value="{{ old('name') ?? '' }}">
                                    @error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="form-label-group mb6">
                                    <label for="city">City</label>
                                    <input type="text" id="city" name="city" class="form-control @error('city') is-invalid @enderror" autofocus required value="{{ old('city') ?? '' }}">
                                    @error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-label-group mb6">
                                    <label for="stree1">Street 1</label>
                                    <input type="text" name="street_1" id="stree1" class="form-control @error('street_1') is-invalid @enderror" required value="{{ old('street_1') ?? '' }}">
                                    @error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-label-group mb6">
                                    <label for="street2">Street 2</label>
                                    <input type="text" id="street2" name="street_2" class="form-control @error('street_2') is-invalid @enderror" autofocus value="{{ old('street_2') ?? '' }}">
                                    @error('street_2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-label-group mb6">
                                    <label for="zip">ZIP</label>
                                    <input type="number" name="zip" id="zip" class="form-control @error('zip') is-invalid @enderror" required value="{{ old('zip') ?? '' }}">
                                    @error('zip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
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
                                <input id="password-confirm" type="password" onChange="checkPasswordMatch();" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <div id="divCheckPasswordMatch">
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <input class="form-check-input" type="checkbox" onclick="readTheAgreement('agreement')" value="1" id="agreement-checkbox" name="is_agreement" data-bs-toggle="modal"> Please
                                tick to agree our
                                <a style="color:blue" href="{{ route('membership') }}">Membership Agreement</a>
                            </div>
                            <div class="col-md-6 mt-2">
                            </div>
                            <div class="col-md-6 mt-2">
                                <input class="form-check-input" name="is_tos" type="checkbox" onclick="readTheAgreement('tos')" value="1" id="tos-checkbox"> Please tick
                                to agree our <a style="color:blue" href="{{ route('tos') }}">Terms of Service</a>
                            </div>
                            <div class="text-center mb-0 mt-3">
                                <div class="form-text">
                                    <br>
                                    <p><b>Please read!</b> When you click on the button below to register and create a
                                        new account, you are agreeing to our <a style="color:blue" href="{{ route('membership') }}">Membership Agreement</a> and our <a style="color:blue" href="{{ route('tos') }}">Terms of Service</a>.
                                        <br>
                                        <br>
                                </div>
                                <div>
                                    <b>I certify that I have fully read, understand and accept the identitus membership
                                        agreement and terms and conditions.I also understand that the membership
                                        agreement and terms and conditions will continue to be updated as identitius
                                        evolves</b>
                                </div>
                                <button type="submit" class="btn btn-block w-25 btn-primary register-submit-button">
                                    {{ __('Register') }}
                                </button>
                                <a href="{{ route('sign.document', 'terms.pdf') }}" id="become-vendor" class="d-none">{{ __('Register') }}</a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('auth.agreements.membership')
@include('auth.agreements.terms-of-service')
@endsection
@push('scripts')
@include('auth.js.auth-js')
@endpush