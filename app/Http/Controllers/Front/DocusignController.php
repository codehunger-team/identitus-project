<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Exception;
use App\Traits\DocusignTrait;
class DocusignController extends Controller
{
    use DocusignTrait;
    /**
     * Call Docusign click wrap 
     *
     * @return response
     */
    public function signDocument($domain)
    {
        try {
            $params = $this->docusignClickWrap($domain);
            if ($params['created_time']) {
                return redirect()->back()->with('docusign', $params);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('msg', $e->getMessage());
        }
    }

}
