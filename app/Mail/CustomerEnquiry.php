<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerEnquiry extends Mailable
{
    use Queueable, SerializesModels;

    /*
    * Holds Mail Data
    */
    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {   
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $data = $this->data;
        return $this->from($data['email'])
        ->subject('Customer Enquiry')
        ->markdown('emails.enquiry-email',compact('data'));
    }
}