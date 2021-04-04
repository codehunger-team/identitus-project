@extends('emails.base')

@section('mail_subject')
You've got a new financing request!
@endsection

@section('email_title')
You've got a new financing request!
@endsection

@section('intro_heading')
You've got a new financing request for {{ $offer[ 'financing-months' ] }} Months for domain {{ $domain->domain }} <br />
Potential Customer: {{ $offer[ 'financing-name' ] }} ( {{ $offer[ 'financing-email' ]}}  ) <br/>
Tel: @if( !empty( $offer[ 'financing-phone' ] ) ) {{ $offer[ 'financing-phone' ] }} @else --- @endif
@endsection

@section('intro_message')
	
@endsection

@section('mail_content')


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
														Notes:
													</td>
												</tr>
											</table>
										</td>
										<td align="right" valign="middle" class="flexibleContainerBox">
											<table class="flexibleContainerBoxNext" border="0" cellpadding="0" cellspacing="0" width="350" style="max-width:100%;">
												<tr>
													<td align="left" class="textContent">
														@if( empty($offer['financing-notes'] ))
															No notes from potential customer!
														@else
															{{ $offer['financing-notes'] }}
														@endif
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
															Domain Price: {{ App\Options::get_option( 'currency_symbol' ) . number_format($domain->pricing,0) }}
														</h3>
														<br />
														<h4>To reply to this offer just hit Reply in your Mail Client/Service and start discussing options to setup this between you and your customer.</h4>
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

@endsection