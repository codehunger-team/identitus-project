@extends('layouts.app')
@section('content')
<div class="container mt-6">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
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
                            </div>
                        </div>
                        <div class="form-group row mt-2">
                            <div class="col-md-6">
                                <div class="form-label-group mb6">
                                    <label for="phone">Phone</label>
                                        <input type="number" id="phone" name="phone" class="form-control  @error('phone') is-invalid @enderror" autofocus required value="{{old('phone') ?? ''}}">
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
                                        <input type="text" name="company" id="company" class="form-control @error('company') is-invalid @enderror" autofocus required value="{{old('company') ?? ''}}">
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
                                     <input type="text" id="country" name="country" class="form-control @error('country') is-invalid @enderror"  autofocus required value="{{old('country') ?? ''}}">
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
                                     <input type="text" name="state" id="state" class="form-control @error('state') is-invalid @enderror"  required value="{{old('name') ?? ''}}">
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
                                     <input type="text" id="city" name="city" class="form-control @error('city') is-invalid @enderror" autofocus required value="{{old('city') ?? ''}}">
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
                                     <input type="text" name="street_1" id="stree1" class="form-control @error('street_1') is-invalid @enderror" required value="{{old('street_1') ?? ''}}">
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
                                     <input type="text" id="street2" name="street_2" class="form-control @error('street_2') is-invalid @enderror"  autofocus value="{{old('street_2') ?? ''}}">
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
                                     <input type="number" name="zip" id="zip" class="form-control @error('zip') is-invalid @enderror"  required value="{{old('zip') ?? ''}}">
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
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="text-center mb-0 mt-3">
                            <button type="submit" class="btn btn-block w-25 btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
