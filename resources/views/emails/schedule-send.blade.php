<p>Dear {!! $scheduleSend['user_name'] !!},</p>  

<p>You received lease payment in the amount of {!! App\Options::get_option( 'currency_symbol' ) . number_format($scheduleSend['period_payment']) !!} on {{ date('jS F Y', strtotime($scheduleSend['date']) )}} for the domain, {!! $scheduleSend['domain_name'] !!}.</p>

<p>Please click <a href="{!! route('user.lease-payment',$scheduleSend['contract_id']) !!}"> Here</a> to make the payment </p>

<p>If you have any questions, please feel free to contact us at mailto:info@identitius.com.</p>

<a href="https://identitius.com">Identitius</a>