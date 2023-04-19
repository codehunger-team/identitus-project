@extends('user.base')

@section('section_title')
	<strong>Order Invoice </strong>
	<a href="{{url('user/orders')}}" class="btn btn-primary btn-xs float-end">Back to Orders</a>
@endsection
@section('section_body')
	<div class="row">
		<div class="col-md-6">
			<div class="box-header with-border"><strong>Invoice TO</strong></div>
				Name :{{ $order->customer }}</br>
			    Email :{{ $order->email }} </br>
				Mobile Number : {{formatMobileNumber(Auth::user()->phone)}} </br>
				Address : {{Auth::user()->street_1}}, {{Auth::user()->city}},  {{Auth::user()->state}}, {{Auth::user()->zip}}, {{Auth::user()->country}}</br>				
		</div>
		<div class="col-md-6">
			<div class="box-header with-border"><strong>Payment Details</strong></div>
			Total Paid:	${{ number_format( $order->total, 2) }}</br>
			Payment Date: {{app('App\Helpers\DateTimeHelper')->ConvertIntoUTC($order->order_date)}}</br>
			Paid Via: {{ $order->payment_type }}</br>
		</div>
	</div>
	<hr>
	<div class="container mt-2">
		<div class="row">
			<table class="table table-responsive table-bordered">
				<thead class="table-light">
				  <tr>
					<th scope="col">#</th>
					<th scope="col">Domain Name</th>
					<th>Purchase Type</th>
					<th scope="col">Price</th>
					<th>Action</th>
				  </tr>
				</thead>
				<tbody>
					@foreach( $order_content as $o )
					<tr>
						<td><b>{!! $o->id !!}</b></td>
						<td>{{ $o->name }}</td>
						<td>{{$o->attributes[0] == 'from_cart' ? 'Purchase Payment' : 'Period Payment' }}</td>
						<td>${{ number_format($o->price,0) }}</td>
						<td> <button class="btn btn-primary"><a href="{{url('user/set-dns').'/'.$o->id}}"> Set DNS</button> </td>
					</tr>
					@endforeach
					<tr>
						<td colspan="3">
							Thank You For Making Purchase From <b>Identitius.com</b> </br>
							On The Right Side We Are Showing Details Of Your Purchase </br>
							If You Have Any Concers Regarding Your Purchase, Please Contact <a href="mailto:info@identitius.com"><b>info@identitius.com</b></a>
						</td>	
						<td colspan="2">Sub Total: <b>${{ number_format( $order->sub_total, 2) }}</b> </br>
							Card Transaction Fee: <b>${{ number_format( $order->total - $order->sub_total, 2) }}</b></br>
							Grand Total: <b>${{ number_format( $order->total, 2) }}</b> </br>
						</td>
					</tr>
				</tbody>
			  </table>
		</div>
	</div>
@endsection