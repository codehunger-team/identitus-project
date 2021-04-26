<?php

namespace App\Traits;

trait StripeConnectTrait {

    public function __construct() {
		\Stripe\Stripe::setApiKey(\App\Models\Option::get_option( 'stripe_secret' ));
    }
    
}
