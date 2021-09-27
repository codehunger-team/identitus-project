<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Exception;
use App\Mail\CustomerEnquiry;
use Illuminate\Support\Facades\Mail;

class EnquiryController extends Controller
{
     /**
      * Store Enquiry in Contacts Table
      *
      */
     public function sendEnquiry(Request $request)
     {    
          $this->validate($request, [
               'name' => 'required',
               'email' => 'required|email',
               'message' => 'required'
          ]);
          try {
               $data = $request->all();
               Contact::create($data);
               Mail::to('admin@identitus.com')->later(now()->addMinutes(1), new CustomerEnquiry($data));
               return back()->with('contact-msg', 'Will Contact you soon.');
          } catch (Exception $e) {
               \Log::critical($e->getFile().$e->getLine().$e->getMessage());
          }
     }
}
