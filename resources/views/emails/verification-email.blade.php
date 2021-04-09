@isset($name)
<p>Successful Account Creation at Identitius!</p>

<p>Successfully created an account at Identitius. Your username is: {{$name}}.</p>

<p>Thank you for joining the marketplace.</p>

<p>If you have any suggestions for improvement, please let us know. We are here to serve you.</p>
@endisset

{{-- @dd($email); --}}

<p>Please click <a href="{!! route('verify-email',$user_id) !!}"> Here</a> to confirm email </p>

<p> Timestamp: {{ $timestamp }} </p>
<p> IP Address: {{ Request::ip() }} </p>
