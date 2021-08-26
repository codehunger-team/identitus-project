<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Domain;

class UserSetTermPriceDrop extends Mailable
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
        $domainName = Domain::latest()->first()->domain;
        return $this->from($data['from_email'])
        ->subject('Accepted Lease Counter')
        ->markdown('emails.price-drop-email',compact('data','domainName'));
    }
}
