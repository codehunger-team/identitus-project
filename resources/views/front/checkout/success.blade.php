@extends('layouts.app') 
@section('content')
<div class="container-fluid mt-6">
	<div class="container add-paddings">
		<div class="col-xs-12 mx-auto col-xs-offset-0 col-md-6 col-md-offset-3">
			<div class="row">
				<div class="col-lg-10 col-lg-offset-2">
					<h1 class="text-theme-checkout "></i>Thank you for your order.</h1>
					<div class="separator-3"></div>
				</div>
			</div>
			<hr />We have sent you an email and also notified the admin.
			<br />We will get back to you shortly for discussing transfer details.
			<hr />
			    @foreach ($decodedOrderContent as $domainId => $item)
						You can set your DNS here for <a href="{{url('user/set-dns',$domainId)}}" target="_blank">{{$item->name}}</a>
					<br />
				@endforeach
				
			<br />
		</div>
		<!-- .col-* -->
	</div>
	<!-- ./container add-paddings -->
</div>
<!-- ./container-fluid & white -->
@endsection