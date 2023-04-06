@extends('emails.base')

@section('mail_subject')
Applied For Vendor
@endsection

@section('email_title')
Applied For Vendor
@endsection

@section('intro_heading')
Hi {{ $user->name }}, is want to become vendor!
@endsection

@section('intro_message')
	<h3>The user with the following details has applied to be a vendor</p>
	<p> Name : {{ $user->name }}</p>
	<p> Email : {{ $user->email }}</p>
	<p> Street 1 : {{ $user->street_1 }}</p>
	<p> Street 2 : {{ $user->street_2 }}</p>
	<p> City : {{ $user->city }}</p>
	<p> State : {{ $user->state }}</p>
	<p> Zip : {{ $user->zip }}</p>
	<p> Country : {{ $user->country }}</p>
	<p> Phone : {{ $user->phone }}</p>
	<p> Company : {{ $user->company }}</p>
	<a href="{{url('admin/users')}}">Click on the link to approve</a>
@endsection

@section('mail_content')

@endsection