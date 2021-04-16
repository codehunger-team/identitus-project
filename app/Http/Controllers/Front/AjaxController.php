<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Domain;
Use Session;

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

    //buy add to cart
    public function add_to_cart_buy($domain)
    {

        $dataOfDoamin = Domain::Where('domain', $domain)->first();

        //check for the duplicate items in cart
        $items = \Cart::getContent();

        foreach ($items as $item) {
            if ($item->name == $domain) {
                Session::flash('message', 'Domain already in cart.');
                return redirect()->back();
            }
        }

        // add this domain to cart
        try {

            $pricing = (!is_null($dataOfDoamin['discount']) && ($dataOfDoamin['discount'] > 0)) ? $dataOfDoamin['discount'] : $dataOfDoamin['pricing'];

            \Cart::add($dataOfDoamin['id'], $dataOfDoamin['domain'], $pricing, 1, ['from_cart'], 0.00);
            Session::flash('message', 'Domain added to cart.');
            Session::flash('message_type', 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    // cart contents
    public function cart_contents(Request $request)
    {

        $cart = \Cart::getContent(true);

        return view('cart')->with('cart', $cart);
    }

    // remove from cart
    public function remove_from_cart($rowId)
    {

        // try removing
        try {

            \Cart::remove($rowId);

            $r = ['message' => 'Domain removed from cart.',
                'message_type' => 'success'];

        } catch (\Exception $e) {

            $r = ['message' => $e->getMessage(),
                'message_type' => 'warning'];

        }

        // return with flash data
        return redirect('checkout')
            ->with('message', $r['message'])
            ->with('message_type', $r['message_type']);

    }
}
