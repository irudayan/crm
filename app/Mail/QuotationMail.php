<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// class QuotationMail extends Mailable
// {
//     use Queueable, SerializesModels;

//     public $lead;
//     public $pdfPath;


//     public function __construct($lead, $pdfPath, $senderEmail, $senderName)
//     {
//         $this->lead = $lead;
//         $this->pdfPath = $pdfPath;
//     }

//     public function build()
//     {
//         return $this->subject('Quotation Details')
//                     ->view('admin.emails.quotation')
//                     ->attach($this->pdfPath, [
//                         'as' => 'quotation.pdf',
//                         'mime' => 'application/pdf',
//                     ]);
//     }
class QuotationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;
    public $pdfPath;
    public $senderEmail;
    public $senderName;

public function __construct($lead, $pdfPath, $senderEmail, $senderName)
    {
        $this->lead = $lead;
        $this->pdfPath = $pdfPath;
        $this->senderEmail = $senderEmail;
        $this->senderName = $senderName;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')) // Fixed "From" email
                    ->replyTo($this->senderEmail, $this->senderName) // Logged-in user's email
                    ->subject('Quotation Details')
                    ->view('admin.emails.quotation')
                    ->attach($this->pdfPath, [
                        'as' => 'quotation.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }

}
