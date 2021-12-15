<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Exception;
use App\Mail\CustomerEnquiry;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class EnquiryController extends Controller
{
     /**
      * Store Enquiry in Contacts Table
      *
      */
     public function sendEnquiry(Request $request)
     {
          $data = $request->all();
          $rules = [
               'name' => 'required',
               'email' => 'required|email',
               'message' => 'required'
          ];
          $validator = \Validator::make($data, $rules);

          // Validate the input and return correct response
          if ($validator->fails()) {
               return \Response::json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

               ), 200); // 400 being the HTTP code for an invalid request.
          }
          try {
               $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => env('RECAPTCHA_SECRET_KEY'),
                    'response' => $request->recaptchaToken,
               ]);
               $recaptchaResponse = $response->json();
               if ($recaptchaResponse['success'] == true) {
                    Contact::create($data);
                    
                    dispatch(function ($data) {
                         Mail::to('admin@identitus.com')->send(new CustomerEnquiry($data));
                     })->afterResponse();

                    $message = [
                         'success' => true,
                    ];
                    Session::flash('contact-msg','Will Contact you soon');
                    return response()->json($message, 200);

               } else {
                    $recaptchaFail = 'Something went wrong !';
                    return response()->json($recaptchaFail, 200);
               }
          } catch (Exception $e) {
               \Log::critical($e->getFile() . $e->getLine() . $e->getMessage());
          }
     }
}
