@extends('admin.base')

@section('section_title')
	<strong>Set commission</strong>
@endsection

@section('section_body')			
	<a class="btn btn-primary" href="{{route('set.domain.commission')}}">Set Domain Commission</a>
	<a class="btn btn-primary" href="{{route('set.contract.commission')}}">Set Contract Commission</a>
<hr />
@endsection