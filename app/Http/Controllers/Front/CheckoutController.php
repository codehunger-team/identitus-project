<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\PeriodType;
use App\Traits\CalculatePeriodTrait;
use App\Models\Order;
use App\Models\Domain;
use App\Models\ReleasePayment;
use Exception;

class CheckoutController extends Controller
{
    use CalculatePeriodTrait;

    public function __construct() {
		\Stripe\Stripe::setApiKey(env('STRIPE_SECRET' ));
	}
    // process credit card payment
    public function credit_card_processing(Request $r)
    {
        try {
            $user = $r->user();
            // save this order in database
            $order = new \App\Models\Order;
            $order->customer = $user->name;
            $order->email = $user->email;
            $order->total = \Cart::getTotal() * 2.9 /100 + 0.30;
            $order->order_contents = \Cart::getContent();
            $order->payment_type = 'Stripe';
            $order->order_status = 'Paid';
            $order->order_date = date("Y-m-d H:i:s");

            $order->save();
            // update domains statuses to "SOLD"

            foreach (\Cart::getContent() as $domains) {
                $d = \App\Models\Domain::find($domains->id);
                if ($domains->attributes[0] == 'from_cart') {
                    $d->domain_status = 'SOLD';
                } else {
                    $d->domain_status = 'LEASE';
                    $contracts = Contract::where('domain_id', $domains->id)->firstorFail();
                    $periods = PeriodType::all();
                    $periodDays = $periods->where('id', $contracts->period_type_id);
                    $endOfLease = $this->calculatePeriod($periodDays, $contracts->number_of_periods);
                    $leasetotal = $contracts->first_payment + ($contracts->number_of_periods * $contracts->period_payment);
                    $nextPayment = $this->calculatePeriod($periodDays, 1);

                    if (isset($contracts->payment_due_date)) {
                        $data = [
                            'payment_due_date' => $nextPayment,
                            'lessee_id' => $user->id,
                            'contract_status_id' => 1,
                        ];

                        $paymentMade = ReleasePayment::where('contract_id', $contracts->contract_id)->pluck('payment_made')->first();
                        $newPayment = $paymentMade + $order->total;
                        ReleasePayment::where('contract_id', $contracts->contract_id)->update(['payment_made' => $newPayment]);

                    } else {

                        $data = [
                            'lessee_id' => $user->id,
                            'start_date' => now(),
                            'end_date' => $endOfLease,
                            'lease_total' => $leasetotal,
                            'payment_due_date' => $nextPayment,
                            'contract_status_id' => 1,

                        ];

                        $releasePayment = [

                            'contract_id' => $contracts->contract_id,
                            'payment_made' => $order->total,

                        ];

                        ReleasePayment::create($releasePayment);

                    }

                    Contract::where('domain_id', $domains->id)->update($data);

                    // mail the user
                    \Mail::send('emails.rent-paid', ['d' => $d, 'order' => $order, 'contracts' => $contracts], function ($m) use ($d, $order, $contracts) {
                        $m->from(\App\Models\Option::get_option('admin_email'), \App\Models\Option::get_option('site_title'));
                        $m->to($order->email)->subject('Rent Paid for ' . $d->domain . '');

                    });

                }

                $d->save();

            }

            // mail the user

            \Mail::send('emails.user-order-confirmation', ['order' => $order], function ($m) use ($order) {
                $m->from(\App\Models\Option::get_option('admin_email'), \App\Models\Option::get_option('site_title'));
                $m->to($order->email, $order->customer)->subject('Your Order Confirmation!');
            });

            // mail the admin
            \Mail::send('emails.admin-order-confirmation', ['order' => $order], function ($m) use ($order) {
                $m->from(\App\Models\Option::get_option('admin_email'), \App\Models\Option::get_option('site_title'));
                $m->replyTo($order->email, $order->customer);
                $m->to(\App\Models\Option::get_option('admin_email'), 'Admin')->subject('New Order Confirmation!');

            });

            // remove items from cart
            \Cart::clear();

            // redirect with success message ( checkout/success )
            return redirect()->to('checkout/success/' . $order->id);
        } catch (Exception $e) {
            return redirect()->back();
        }

    }

    // stripe credit card payment
    public function credit_card(Request $request, $contractId = null)
    {   
        try{
            if (\Auth::guard()->user()) {

                if (isset($contractId) && \Cart::getContent()->count() == 0) {
                    $contract = Contract::where('contract_id', $contractId)->first();
                    $dataOfDoamin = Domain::Where('id', $contract->domain_id)->first();
                    \Cart::add($dataOfDoamin['id'], $dataOfDoamin['domain'], $contract->period_payment, 1, ['lease'], 0.00);
    
                }
    
                $sellerWise = null;
                foreach (\Cart::getContent() as $domains) {
                    $domainData = \App\Models\Domain::find($domains->id);
                    $sellerWise[$domainData->user_id][] = $domains->price;
                }
    
                foreach ($sellerWise as $sellerID => $sellerValue) {
                    $totalSellerWise[$sellerID] = array_sum($sellerValue);
                }
    
                $amount = \Cart::getTotal() * 2.9 /100 + 0.30;
                $amount *= 100;
                $amount = (int) $amount;
    
                try {
                    $payment_intent = \Stripe\PaymentIntent::create([
                        'description' => \App\Models\Option::get_option('site_title') ?? 'Web Domains',
                        'shipping' => [
                            'name' => $request->user()->name ?? '',
                            'address' => [
                                'line1' => $request->user()->street_1 ?? '',
                                'postal_code' => $request->user()->city ?? '',
                                'city' => $request->user()->city ?? '',
                                'state' => $request->user()->state ?? '',
                                'country' => 'US',
                            ],
                        ],
    
                        'amount' => $amount,
                        'currency' => \App\Models\Option::get_option('currency_code'),
                        'payment_method_types' => ['card'],
    
                    ]);
    
                    // Use Stripe's library to make requests...
    
                } catch (\Stripe\Exception\CardException $e) {
                    // Since it's a decline, \Stripe\Exception\CardException will be caught;
                    $request->session()->flash('msg', $e->getError()->message);
                    return redirect()->back();
    
                } catch (\Stripe\Exception\RateLimitException $e) {
                    // Too many requests made to the API too quickly
                    $request->session()->flash('msg', $e->getError()->message);
                    return redirect()->back();
    
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    // Invalid parameters were supplied to Stripe's API
                    $request->session()->flash('msg', $e->getError()->message);
                    return redirect()->back();
    
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    // Authentication with Stripe's API failed
                    // (maybe you changed API keys recently)
                    $request->session()->flash('msg', $e->getMessage());
                    return redirect()->back();
    
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    // Network communication with Stripe failed
                    $request->session()->flash('msg', $e->getError()->message);
                    return redirect()->back();
    
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    // Display a very generic error to the user, and maybe send
                    // yourself an email
                    $request->session()->flash('msg', $e->getError()->message);
                    return redirect()->back();
    
                } catch (Exception $e) {
                    // Something else happened, completely unrelated to Stripe
                    $request->session()->flash('msg', $e->getError()->message);
                    return redirect()->back();
    
                }
    
                try {
    
                } catch (\Stripe\Exception\CardException $e) {
                    // Since it's a decline, \Stripe\Exception\CardException will be caught;
                    $request->session()->flash('msg', $e->getError()->message);
                    return redirect()->back();
    
                } catch (\Stripe\Exception\RateLimitException $e) {
                    // Too many requests made to the API too quickly
    
                    return redirect('checkout')
                        ->withErrors([$e->getError()->message]);
    
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    // Invalid parameters were supplied to Stripe's API
                    $request->session()->flash('msg', $e->getError()->message);
    
                    return redirect()->back();
    
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    // Authentication with Stripe's API failed
                    // (maybe you changed API keys recently)
                    
                    return redirect('checkout')
                        ->withErrors([$e->getError()->message]);
    
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    // Network communication with Stripe failed
                    return redirect('checkout')
                        ->withErrors([$e->getError()->message]);
    
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    // Display a very generic error to the user, and maybe send
                    // yourself an email
    
                    return redirect('checkout')
                        ->withErrors([$e->getError()->message]);
    
                } catch (Exception $e) {
                    // Something else happened, completely unrelated to Stripe
                    return redirect('checkout')
                        ->withErrors([$e->getError()->message]);
    
                }
    
                $intent = $payment_intent->client_secret;
    
                if ($amount < 1) {
                    throw new \Exception("Error. Total amount is not valid.");
                }
    
                return view('front.checkout.credit-card', compact('intent'));
    
            } else {
                return redirect()->route('login');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('msg', 'Empty Cart');

        }

    }

    //success on paid
    public function success($id) 
    {
		$orderContent = Order::where('id',$id)->first()->order_contents;
		$decodedOrderContent = json_decode($orderContent); 
    	return view('front.checkout.success',compact('decodedOrderContent'));
    }
}
