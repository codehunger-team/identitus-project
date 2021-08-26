<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Domain;
use Auth;
use App\Models\User;

class CounterLeaseVendor extends Mailable
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
        $lessorId = Domain::where('domain',$data['domain_name'])->pluck('user_id')->first();
        $user = User::where('id',$lessorId)->first();
        return $this->from($data['from_email'])
        ->subject('Lease Counter')
        ->markdown('emails.lease-counter-vendor-email',compact('data','user'));
    }
}
