<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class EnquiryController extends Controller
{
    /**
     * Show the data from contacts table
     */
     public function index()
     {
        $contacts = Contact::get();

        return view('admin.enquiry.index',compact('contacts'))->with('active', 'customer');
     }
}
