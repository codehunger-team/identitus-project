<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Auth;

class DomainReviewTerm extends Mailable
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
        $userEmail = Auth::user()->email;
        $data = $this->data;
        return $this->from($userEmail)
            ->subject('Lease Counter')
            ->markdown('emails.lease-counter-email', compact('data'));
    }
}
