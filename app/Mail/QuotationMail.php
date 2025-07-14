<?php
// namespace App\Mail;

// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Mail\Mailable;
// use Illuminate\Queue\SerializesModels;

// class QuotationMail extends Mailable
// {
//     use Queueable, SerializesModels;

//     public $lead;
//     public $pdfPath;
//     public $senderEmail;
//     public $senderName;

//     public function __construct($lead, $pdfPath, $senderEmail, $senderName)
//     {
//         $this->lead = $lead;
//         $this->pdfPath = $pdfPath;
//         $this->senderEmail = $senderEmail;
//         $this->senderName = $senderName;
//     }

//     public function build()
//     {
//         return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
//                     ->replyTo($this->senderEmail, $this->senderName)
//                     ->subject('Quotation Details - ' . $this->lead->quotation_reference)
//                     ->view('admin.emails.quotation')
//                     ->attach($this->pdfPath, [
//                         'as' => 'quotation_'.$this->lead->id.'.pdf',
//                         'mime' => 'application/pdf',
//                     ]);
//     }
// }


// namespace App\Mail;

// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Mail\Mailable;
// use Illuminate\Queue\SerializesModels;

// class QuotationMail extends Mailable
// {
//     use Queueable, SerializesModels;

//     public $lead;
//     public $pdfPath;
//     public $senderEmail;
//     public $senderName;

// public function __construct($lead, $pdfPath, $senderEmail, $senderName)
//     {
//         $this->lead = $lead;
//         $this->pdfPath = $pdfPath;
//         $this->senderEmail = $senderEmail;
//         $this->senderName = $senderName;
//     }

//     public function build()
//     {
//         return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')) // Fixed "From" email
//                     ->replyTo($this->senderEmail, $this->senderName) // Logged-in user's email
//                     ->subject('Quotation Details')
//                     ->view('admin.emails.quotation')
//                     ->attach($this->pdfPath, [
//                         'as' => 'quotation.pdf',
//                         'mime' => 'application/pdf',
//                     ]);
//     }

// }

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuotationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;
    public $pdfPath;
    public $senderEmail;
    public $senderName;

    public function __construct($lead, $pdfPath, $senderEmail = null, $senderName = null)
    {
        $this->lead = $lead;
        $this->pdfPath = $pdfPath;
        $this->senderEmail = $senderEmail ?? config('mail.from.address');
        $this->senderName = $senderName ?? config('mail.from.name');
    }

    public function build()
    {
        return $this->from($this->senderEmail, $this->senderName)
                    ->subject('Quotation Proposal - ' . $this->lead->quotation_reference)
                    ->view('admin.emails.quotation')
                    ->attach($this->pdfPath, [
                        'as' => 'Quotation_'.$this->lead->quotation_reference.'.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}