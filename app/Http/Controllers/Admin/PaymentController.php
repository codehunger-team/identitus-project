<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Contract;
use App\models\Domain;
use App\models\User;
use App\models\ReleasePayment;
use App\models\Commission;

class PaymentController extends Controller
{
    //Release Lessor Payment
    public function release_payment($id)
    {
        $contract = Contract::where('contract_id', $id)->first();
        $lessorId = $contract->lessor_id;
        $leasetotal = (int) $contract->lease_total;
        $domainCount = Domain::domainCount($lessorId);
        $stripeAccountId = User::where('id', $lessorId)->pluck('stripe_account_id')->first();

        $releasePayment = ReleasePayment::where('contract_id', $id)->first();
        if (empty($releasePayment->payment_release)) {
            $price = $releasePayment->payment_made;
        } else {
            $price = $releasePayment->payment_made - $releasePayment->payment_release;
        }

        $price = (int) $price;
        $domainCommission = Commission::where('from', '<=', $domainCount)->where('to', '>=', $domainCount)->where('is_percentage', '!=', '1')->pluck('price')->first();
        $ContractCommission = Commission::where('from', '<=', $price)->where('to', '>=', $price)->where('is_percentage', '1')->pluck('price')->first();
        if (isset($ContractCommission)) {
            $ContractCommissionAmount = $price - ($leasetotal * $ContractCommission) / 100;
        }

        if (empty($releasePayment->payment_release)) {
            if (isset($domainCommission)) {
                $ContractCommissionAmount = $ContractCommissionAmount - $domainCommission;
            }

        }

        $price = $ContractCommissionAmount;

        $amount = $price;
        $amount *= 100;
        $amount = (int) $amount;
        $payment_intent = \Stripe\PaymentIntent::create([
            'payment_method_types' => ['card'],
            'amount' => $amount,
            'currency' => \App\Options::get_option('currency_code'),
            'transfer_data' => [
                'destination' => $stripeAccountId,
            ],
            'description' => 'web domains',
            'shipping' => [
                'name' => 'sean',
                'address' => [
                    'line1' => 'test',
                    'postal_code' => '12345',
                    'city' => 'test',
                    'state' => 'test',
                    'country' => 'US',
                ],
            ],
        ]);

        $intent = $payment_intent->client_secret;
        return view('admin.checkout.credit-card', compact('intent', 'price', 'id', 'lessorId'));
    }

    //Stripe checkout
    public function stripe_checkout(Request $request)
    {
        $data = $request->all();
        $releasePayment = ReleasePayment::where('contract_id', $data['contract'])->first();

        if (empty($releasePayment->payment_release)) {
            $releasePayment->update(['payment_release' => $releasePayment->payment_made]);
        } else {

            $amount = $releasePayment->payment_release + $data['price'];
            $releasePayment->update(['payment_release' => $amount]);
        }

        // \Mail::send('emails.admin-payment-release', ['scheduleSend' => $scheduleSend], function ($m) use ($scheduleSend) {
        //     $m->from(\App\Options::get_option('admin_email'), \App\Options::get_option('site_title'));
        //     $m->to($scheduleSend['user_email'])->subject('Lease Payment Received for '.$scheduleSend['domain_name'].'');
        // });

        return view('admin.checkout.payment-success');

    }
}
