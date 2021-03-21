<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $hasheddata;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($hasheddata)
    {
        //
        $this->hasheddata = $hasheddata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.invitation');
    }
}
