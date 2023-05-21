<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\DocusignController;

class FrontPageController extends Controller
{   

    /**
     * Return the homepage
     * @method GET home
     * @return Renderable
     */
    public function home(DocusignController $docusign)
    {   
        $diff_in_hours = docusignHourDifference();

        if ($diff_in_hours > 7) {
            $docusign->refreshToken();
        }

        return view('welcome');
    }

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
