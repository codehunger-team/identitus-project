<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontPageController extends Controller
{
    /**
     * Return the Fees Page
     * @method GET /fees
     * @return Renderable
     */

    public function feesPage()
    {
        return view('front.fees');
    }
    /**
     * Return the Domain Owners Page
     * @method GET /domain-owners
     * @return Renderable
     */

    public function domainOwners()
    {
        return view('front.domain_owners');
    }
    /**
     * Return the Domain Leases Page
     * @method GET /domain-leases
     * @return Renderable
     */

    public function domainLessees()
    {
        return view('front.domain_leases');
    }
}
