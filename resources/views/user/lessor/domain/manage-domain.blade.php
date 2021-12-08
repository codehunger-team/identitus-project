@extends('user.base')
@section('section_title')
<div class="row">
    <div class="col-sm-6">
        <strong>Manage Domain: {{ $d->domain }}</strong>
    </div>
    <div class="col-sm-6">
        <a href="{{route('user.domains')}}" class="btn btn-primary btn-xs float-end">Back to Domains Overview</a>
    </div>
</div>
@endsection

@section('section_body')
<form method="POST" enctype="multipart/form-data" action="{{route('domain.update',$d->id)}}">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-md-8 mb-4">
            <label>Domain Name</label><br />
            <input type="text" required name="domain" value="{{ $d->domain }}" class="form-control">
            @error('domain')
            <span class="required-message" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="col-xs-12 col-md-4">
            <label>Logo Upload (ignore to keep current logo)</label><br />
            <input type="file" name="domain_logo" class="form-control">
        </div>

        <div class="col-xs-12 col-md-6">
            <label>Status</label><br />
            <select name="domain_status" class="form-control">
                <option @if($d->domain_status == 'AVAILABLE') selected @endif>AVAILABLE</option>
                <option @if($d->domain_status == 'SOLD') selected @endif>SOLD</option>
            </select>
            <br />
        </div>

        <div class="col-xs-12 col-md-6">
            <label>Price($)</label><br />
            <input type="number" required name="pricing" value="{{ $d->pricing }}" class="form-control"><br />
        </div>

        <div class="col-xs-12 col-md-6">
            <label>Discount (enter final price after discount, NOT percentage)</label><br />
            <input type="text" name="discount" value="{{ $d->discount }}" class="form-control"><br />
        </div>

        <div class="col-xs-12 col-md-6">
            <label>Registrar</label><br />
            <select name="registrar_id" class="form-control">
                @foreach($registrars as $registrar)
                <option value="{{$registrar->id}}" @if($d->registrar == $registrar->id) selected
                    @endif>{{$registrar->registrar}}</option>
                @endforeach
            </select>
            <br />
        </div>

        <div class="col-xs-12 col-md-6 mb-4">
            <label>Registration Date</label>
            <input type="text" name="reg_date" value="{{ $d->reg_date }}" class="form-control" id='datetimepicker'>
        </div>

        <div class="col-xs-12 col-md-6">
            <label>Category</label><br />
            <select name="category" class="form-control" required="">
                @if( !count( $categories ) )
                <option value="">Please add some categories first</option>
                @endif
                @foreach($categories as $c)
                @if( $c['id'] == $d->category )
                <option value="{{ $c['id'] }}" selected>{{ stripslashes($c['catname']) }}</option>
                @else
                <option value="{{ $c['id'] }}">{{ stripslashes($c['catname']) }}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="col-xs-12 col-md-6 mb-4">
            <label>Tags (Required for seo)</label><br />
            <select class="form-control js-example-basic-multiple" name="tags[]" multiple="multiple">
                @foreach ($tags as $tag)
                <option value="{{$tag}}" selected>{{$tag}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-xs-12 col-md-12">
            <label>Short description (Required for seo)</label><br />
            <textarea name="short_description" class="form-control"
                rows="4">{{ $d->short_description }}</textarea><br />
        </div>

        <div class="col-xs-12 col-md-12">
            <label>Full description</label><br />
            <textarea name="description" id="editor" class="form-control textarea"
                rows="8">{{ $d->description }}</textarea>
            <br />
        </div>

        <div class="col-xs-12 col-md-6 col-xs-offset-0 col-md-offset-3">
            <input type="submit" name="sb" value="Save" class="btn btn-primary btn-block">
        </div>
    </div>
</form>
@include('layouts.ckeditor')
@endsection
