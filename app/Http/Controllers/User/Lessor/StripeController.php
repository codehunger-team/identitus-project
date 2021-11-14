<?php

namespace App\Http\Controllers\User\Lessor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\StripeConnectTrait;
use App\Traits\AuthTrait;
use App\Models\Option;

class StripeController extends Controller
{   
    use StripeConnectTrait,AuthTrait;

    /**
     * Use to connect stripe
     */
    public function stripeConnect()
    {   
        $active = 'stripe-connect';
        $stripe_account_id =  User::where('id',$this->authID())->first()->stripe_account_id;
        return view('user.lessor.stripe.connect',compact('stripe_account_id','active'));
    }

     /**
     * Redirect after connection
     * 
     */
    public function stripeConnectRedirect(Request $request)
    {   
        $userId = $this->authID();

        try {
			$response = \Stripe\OAuth::token([
                'grant_type' => 'authorization_code',
                'code' => $request->code,
                ]);
			// Use Stripe's library to make requests...
		  } catch(\Stripe\Exception\CardException $e) {
              			// Since it's a decline, \Stripe\Exception\CardException will be caught;
			$request->session()->flash('msg', $e->getError()->error_description);
			return redirect('user/stripe-connect');

		  } catch (\Stripe\Exception\RateLimitException $e) {
            
			// Too many requests made to the API too quickly
			$request->session()->flash('msg', $e->getError()->error_description);
			return redirect('user/stripe-connect');

		  } catch (\Stripe\Exception\InvalidRequestException $e) {
            
			// Invalid parameters were supplied to Stripe's API
			$request->session()->flash('msg', $e->getError()->error_description);
			return redirect('user/stripe-connect');

		  } catch (\Stripe\Exception\AuthenticationException $e) {
            
            // Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
			$request->session()->flash('msg', $e->getMessage());
			return redirect('user/stripe-connect');

		  } catch (\Stripe\Exception\ApiConnectionException $e) {
            
			// Network communication with Stripe failed
			$request->session()->flash('msg', $e->getMessage());
			return redirect('user/stripe-connect');

		  } catch (\Stripe\Exception\ApiErrorException $e) {
            // echo $e->getMessage(); die;
			// Display a very generic error to the user, and maybe send
			// yourself an email
			$request->session()->flash('msg', $e->getError()->error_description);
			return redirect('user/stripe-connect');

		  } catch (Exception $e) {
            
			// Something else happened, completely unrelated to Stripe
			$request->session()->flash('msg', $e->getError()->error_description);
			return redirect('user/stripe-connect');

        }

        $connected_account_id = $response->stripe_user_id;

        User::where('id',$this->authID())->update(['stripe_account_id'=>$connected_account_id]);
        $request->session()->flash('msg', 'Your account has been connected');
        return redirect()->back();
    }

    /**
     * Remove account from stripe
     * 
     */
    public function revokeStripe(Request $request)
    {   
        $stripe_client_id = env('STRIPE_CLIENT_ID');
        $stripe_account_id =  User::where('id',$this->authID())->first()->stripe_account_id;
        try {
			\Stripe\OAuth::deauthorize([
                'client_id' => $stripe_client_id,
                'stripe_user_id' => $stripe_account_id,
              ]);
			// Use Stripe's library to make requests...
		  } catch(\Stripe\Exception\CardException $e) {
              			// Since it's a decline, \Stripe\Exception\CardException will be caught;
			$request->session()->flash('msg', $e->getError()->error_description);
			return redirect()->back();

		  } catch (\Stripe\Exception\RateLimitException $e) {
            
			// Too many requests made to the API too quickly
			$request->session()->flash('msg', $e->getError()->error_description);
			return redirect()->back();

		  } catch (\Stripe\Exception\InvalidRequestException $e) {
            
			// Invalid parameters were supplied to Stripe's API
			$request->session()->flash('msg', $e->getError()->error_description);
			return redirect()->back();

		  } catch (\Stripe\Exception\AuthenticationException $e) {
            
            
            // Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
			$request->session()->flash('msg', $e->getMessage());
			return redirect()->back();

		  } catch (\Stripe\Exception\ApiConnectionException $e) {
            
			// Network communication with Stripe failed
			$request->session()->flash('msg', $e->getMessage());
			return redirect()->back();

		  } catch (\Stripe\Exception\ApiErrorException $e) {
            // echo $e->getMessage(); die;
			// Display a very generic error to the user, and maybe send
			// yourself an email
			$request->session()->flash('msg', $e->getError()->error_description);
			return redirect()->back();

		  } catch (Exception $e) {
            
			// Something else happened, completely unrelated to Stripe
			$request->session()->flash('msg', $e->getError()->error_description);
			return redirect()->back();

		}
        User::where('id',$this->authID())->update(['stripe_account_id'=>NULL]);
        $request->session()->flash('msg', 'Your account has been revoked');
        return redirect()->back();
    }
    
}
