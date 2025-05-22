<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Leads;

class DemoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;
    public $products;

    /**
     * Create a new message instance.
     *
     * @param Leads $lead
     * @param Collection $products
     */
    public function __construct(Leads $lead, $products)
    {
        $this->lead = $lead;
        $this->products = $products;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Demo Details')
                    ->view('admin.emails.demoMail') // Blade template for the email
                    ->with([
                        'lead' => $this->lead,
                        'products' => $this->products,
                    ]);
    }
}
