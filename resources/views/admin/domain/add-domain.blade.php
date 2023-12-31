@extends('admin.base')
@section('section_title')
<div class="row">
	<div class="col-sm-6">
		<strong>Add New Domain</strong>
	</div>
	<div class="col-sm-6">
		<a href="{{route('admin.domain')}}" class="btn btn-primary btn-xs float-right">Back to Domains Overview</a>
	</div>
</div>
@endsection
@section('section_body')
<form method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
	<div class="row">
		<div class="col-xs-12 col-md-6 mb-4">
			<label>Domain Name</label><br />
			<input type="text" required name="domain" class="form-control" @error('domain') is-invalid @enderror value="{{ old('domain') }}">
			@error('domain')
				<span class="required-message" role="alert">
					<strong>{{ $message }}</strong>
				</span>
			@enderror
		</div>
	
		<div class="col-xs-12 col-md-6">
			<label>Logo Upload</label><br />
			<input type="file" name="domain_logo" class="form-control">
		</div>
	
		<div class="col-xs-12 col-md-6">
			<label>Status (Listing Status)</label><br />
			<select name="domain_status" class="form-control">
				<option>AVAILABLE</option>
				<option>SOLD</option>
			</select>
			<br />
		</div>
	
		<div class="col-xs-12 col-md-6">
			<label>Price($)</label><br />
			<input type="number" required name="pricing" class="form-control" value="{{ old('pricing') }}"><br />
		</div>
	
		<div class="col-xs-12 col-md-6">
			<label>Discount (enter final price after discount, NOT percentage)</label><br />
			<input type="text" name="discount" class="form-control" value="{{ old('discount', 0) }}"><br />
		</div>
	
		<div class="col-xs-12 col-md-6">
			<label>Registrar</label><br />
			<select name="registrar_id" class="form-control"><br />
				@foreach ($registrars as $registrar)
				<option value="{{$registrar->id}}" @if($registrar->id == old('registrar')) selected
					@endif>{{$registrar->registrar}}</option>
				@endforeach
			</select>
			<br />
		</div>
		<div class='col-xs-12 col-md-6'>
			<label>Registration Date</label>
			<input type='text' name="reg_date" class="form-control" id='datetimepicker' />
		</div>
	
		<div class="col-xs-12 col-md-6">
			<label>Category</label><br />
			<select name="category" class="form-control" required>
				@if( !count( $categories ) )
				<option value="">Please add some categories first</option>
				@endif
				@foreach($categories as $c)
				<option value="{{ $c['id'] }}">{{ stripslashes($c['catname']) }}</option>
				@endforeach
			</select>
		</div>
	
		<div class="col-xs-12 col-md-6 mt-3">
			<label>Tags(Required for seo)</label><br />
			<select class="form-control js-example-basic-multiple"   style="width: 100% !important" required name="tags[]" multiple="multiple" ></select>
		</div>
	
		<div class="col-xs-12 col-md-12 mt-3">
			<label>Short description (Required for seo)</label><br />
			<textarea name="short_description" class="form-control" rows="4">{{ old('short_description') }}</textarea><br />
		</div>
	
		<div class="col-xs-12 col-md-12">
			<label>Full description</label><br />
			<textarea name="description" id="editor" class="form-control" rows="8">{{ old('description') }}</textarea>
			<br />
		</div>
	
		<div class="col-xs-12 col-md-6 col-xs-offset-0 col-md-offset-3">
			<input type="submit" name="sb" value="Save" class="btn btn-primary btn-block">
		</div>
	</div>
</form>
@include('layouts.ckeditor')
@endsection
