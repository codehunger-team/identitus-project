<?php

namespace App\Traits;

trait StripeConnectTrait {

    public function __construct() {
		\Stripe\Stripe::setApiKey(\App\Options::get_option( 'stripe_secret' ));
    }
    
}
