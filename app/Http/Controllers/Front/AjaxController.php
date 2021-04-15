<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    // add to cart
    public function add_to_cart($domain, Request $request)
    {
        $dataOfDoamin = Domain::Where('domain', $domain)->first();
        $LeasePricing = Contracts::where('domain_id', $dataOfDoamin->id)->firstOrFail()->first_payment;

        //check for the duplicate items in cart
        $items = \Cart::getContent();

        foreach ($items as $item) {
            if ($item->name == $domain) {
                Session::flash('message', 'Domain already in cart.');
                Session::flash('message_type', '');
                return redirect()->back();
            }
        }

        // add this domain to cart
        try {

            if ($LeasePricing) {
                $pricing = $LeasePricing;
            } else {
                $pricing = (!is_null($dataOfDoamin['discount']) && ($dataOfDoamin['discount'] > 0)) ? $dataOfDoamin['discount'] : $dataOfDoamin['pricing'];
            }

            \Cart::add($dataOfDoamin['id'], $dataOfDoamin['domain'], $pricing, 1, ['lease'], 0.00);

            if ($LeasePricing) {
                return redirect('checkout');
            } else {
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
}
