<?php

namespace App\Traits;

trait StripeConnectTrait {

    public function __construct() {
		  \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    }
    
}
