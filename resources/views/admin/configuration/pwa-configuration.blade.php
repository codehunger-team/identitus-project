@extends('admin.base')

@section('section_title')
<strong>PWA Configuration</strong>
@endsection

@section('section_body')
<form method="POST" action="{{ route('admin.save.pwa.configuration') }}" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-6 mb-2">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">PWA 72x72 Icon <span class="text-danger">*</span></label>
                        <input type="file" name="pwa_app_72_72_icon" value="{{ getOption('pwa_app_72_72_icon') }}" class="form-control" accept="image/png">
                        @error('pwa_app_72_72_icon')<span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <img class="image-responsive" width="100" src="{{ getOption('pwa_app_72_72_icon') }}">
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">PWA 96x96 Icon <span class="text-danger">*</span></label>
                        <input type="file" name="pwa_app_96_96_icon" value="{{ getOption('pwa_app_96_96_icon') }}" class="form-control" accept="image/png">
                        @error('pwa_app_96_96_icon')<span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <img class="image-responsive" width="100" src="{{ getOption('pwa_app_96_96_icon') }}">
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">PWA 128x128 Icon <span class="text-danger">*</span></label>
                        <input type="file" name="pwa_app_128_128_icon" value="{{ getOption('pwa_app_128_128_icon') }}" class="form-control" accept="image/png">
                        @error('pwa_app_128_128_icon')<span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <img class="image-responsive" width="100" src="{{ getOption('pwa_app_128_128_icon') }}">
                </div>
            </div>
        </div>
        <div class="col-xs-6 mt-3">
            <input type="submit" name="sb_settings" value="Save" class="btn btn-block btn-primary">
        </div>
    </div>
</form>
@endsection