@extends('user.base')

@section('section_title')

<div class="row">
	<div class="col-sm-6">
		<strong>Add New Domain</strong>
	</div>
	<div class="col-sm-6">
		<a href="{{route('user.domains')}}" class="btn btn-primary btn-xs float-right">Back to Domains Overview</a>
	</div>
</div>
@endsection

@section('section_body')

<form method="POST" enctype="multipart/form-data" action="{{route('store.domain')}}">
{{ csrf_field() }}

<input type="hidden" value="{{Auth::user()->id}}" name="user_id">
<div class="row">
	<div class="col-xs-12 col-md-8">
		<label>Domain Name</label><br />
		<input type="text" required name="domain" class="form-control" value="{{ old('domain') }}"><br />
	</div>
	
	<div class="col-xs-12 col-md-4">
		<label>Logo Upload</label><br/>
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
					<option value="{{$registrar->id}}" @if($registrar->id == old('registrar')) selected @endif>{{$registrar->registrar}}</option>
				@endforeach
			</select>
		<br />
	</div>
	 <div class='col-xs-12 col-md-6'>
		<label>Registration Date</label>
		<input type='text' name="reg_date" class="form-control" id='datetimepicker'/>
	</div>
	
	<div class="col-xs-12 col-md-6">
	<label>Category</label><br />
	<select name="category" class="form-control" required="">
		@if( !count( $categories ) )
			<option value="">Please add some categories first</option>
		@endif
		
		@foreach($categories as $c)
			<option value="{{ $c->id }}">{{ stripslashes($c['catname']) }}</option>
		@endforeach
	</select>
	</div>
	
	<div class="col-xs-12 col-md-6">
		<label>Tags(Required for seo)</label><br />
		<select class="form-control js-example-basic-multiple" required name="tags[]" multiple="multiple"></select>
	</div>
	
	<div class="col-xs-12 col-md-12">
	<label>Short description (Required for seo)</label><br />
		<textarea name="short_description" class="form-control" rows="4">{{ old('short_description') }}</textarea><br />
	</div>
	
	<div class="col-xs-12 col-md-12">
		<label>Full description</label><br />
		<textarea id="editor" name="description" class="form-control textarea" rows="8">{{ old('description') }}</textarea>
		<br />
	</div>
	
	<div class="col-xs-12 col-md-6 col-xs-offset-0 col-md-offset-3">
		<input type="submit" name="sb" value="Save" class="btn btn-primary btn-block">
	</div>
</div>
</form>
@include('layouts.ckeditor')
@endsection
