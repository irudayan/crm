<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LicenseExpiryReminder extends Mailable
{
    public $license;

    public function __construct($license)
    {
        $this->license = $license;
    }

    public function build()
    {
        return $this->subject('Your license is expiring soon!')
                    ->view('emails.expiry_reminder');
    }
}
