@extends('emails.base')

@section('mail_subject')
New Order Confirmation!
@endsection

@section('email_title')
New Order Confirmation!
@endsection

@section('intro_heading')
New Order was placed by {{ $order->customer }} ( {{ $order->email }} ) via {{ $order->payment_type }}
@endsection

@section('intro_message')
	@if( $order->payment_type == 'Escrow' )
	Hello admin! Please get in touch with {{ $order->customer }} for Escrow arrangement! 


	Unlinke PayPal or Skrill which is fully automated, Escrow will have to be arranged between you as a seller and the buyer! 

	Fingers Crossed!
	@else
	Order is paid and confirmed and you should get in touch as soon as possible with the customer to arrange transfer details!
	@endif
@endsection

@section('mail_content')


@php $cartCollection = \Cart::getContent(); @endphp
@if( $cartCollection->count()) )
@foreach( \Cart::getContent() as $domain )
<!-- MODULE ROW // -->
<tr>
	<td align="center" valign="top">
		<!-- CENTERING TABLE // -->
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td align="center" valign="top">
					<!-- FLEXIBLE CONTAINER // -->
					<table border="0" cellpadding="30" cellspacing="0" width="500" class="flexibleContainer">
						<tr>
							<td style="padding-bottom:0;" valign="top" width="500" class="flexibleContainerCell">

								<!-- CONTENT TABLE // -->
								<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr>
										<td align="left" valign="top" class="flexibleContainerBox">
											<table border="0" cellpadding="0" cellspacing="0" width="90" style="max-width:100%;">
												<tr>
													<td align="left" class="textContent">
														<br />
														.{{ pathinfo($domain->name, PATHINFO_EXTENSION) }}
													</td>
												</tr>
											</table>
										</td>
										<td align="right" valign="middle" class="flexibleContainerBox">
											<table class="flexibleContainerBoxNext" border="0" cellpadding="0" cellspacing="0" width="350" style="max-width:100%;">
												<tr>
													<td align="left" class="textContent">
														<h3 style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:left;">{{ App\Models\Option::get_option( 'currency_symbol' ) . number_format($domain->price)}}</h3>
														<div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#5F5F5F;line-height:135%;">Domain: {{ $domain->name }}</div>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
								<!-- // CONTENT TABLE -->

							</td>
						</tr>
					</table>
					<!-- // FLEXIBLE CONTAINER -->
				</td>
			</tr>
		</table>
		<!-- // CENTERING TABLE -->
	</td>
</tr>
<!-- // MODULE ROW -->
@endforeach

<!-- MODULE ROW // -->
<tr>
	<td align="center" valign="top">
		<!-- CENTERING TABLE // -->
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td align="center" valign="top">
					<!-- FLEXIBLE CONTAINER // -->
					<table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
						<tr>
							<td align="center" valign="top" width="500" class="flexibleContainerCell">
								<table border="0" cellpadding="30" cellspacing="0" width="100%">
									<tr>
										<td align="center" valign="top">

											<!-- CONTENT TABLE // -->
											<table border="0" cellpadding="0" cellspacing="0" width="100%">
												<tr>
													<td valign="top" class="textContent">
														<!--
															The "mc:edit" is a feature for MailChimp which allows
															you to edit certain row. It makes it easy for you to quickly edit row sections.
															http://kb.mailchimp.com/templates/code/create-editable-content-areas-with-mailchimps-template-language
														-->
														<h3 mc:edit="header" style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:left;">
															Order Total: {{ App\Models\Option::get_option( 'currency_symbol' ) . number_format(\Cart::getTotal(), 0)}}
														</h3>
													</td>
												</tr>
											</table>
											<!-- // CONTENT TABLE -->

										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<!-- // FLEXIBLE CONTAINER -->
				</td>
			</tr>
		</table>
		<!-- // CENTERING TABLE -->
	</td>
</tr>
<!-- // MODULE ROW -->

@endif

@endsection