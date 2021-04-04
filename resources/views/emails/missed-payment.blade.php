<p>Hi {{ $missedPayment['user_name'] }},</p>

<p>Your rent payment for {!! $missedPayment['domain_name'] !!} in the amount of {!! App\Options::get_option( 'currency_symbol' ) . number_format($missedPayment['period_payment']) !!} is past due as of {{ date('jS F Y', strtotime($missedPayment['payment_due_date']) )}}.</p> 

<p>Please click <a href="{{url('user/lease-payment/',$missedPayment['contract_id'])}}"> Here</a> to make the payment </p>

<p>Identitius</p>

    