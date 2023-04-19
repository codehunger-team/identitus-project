@extends('emails.base')

@section('mail_subject')
Congrats! You Have Been Approved For Vendor
@endsection

@section('email_title')
Congrats! You Have Been Approved For Vendor
@endsection

@section('intro_heading')
    Hi {{ $user->name }},
@endsection

@section('intro_message')
	<p>You are now a vendor on Identitius. Please login and begin adding your domains today!</p>
@endsection

@section('mail_content')

@endsection