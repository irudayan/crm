<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\Leads;
use App\Models\Products;
use App\Mail\FollowMail;

class SendFollowupEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $lead;

    public function __construct(Leads $lead)
    {
        $this->lead = $lead;
    }

    public function handle()
    {
        $products = Products::all();
        Mail::to($this->lead->email)->send(new FollowMail($this->lead, $products));

        \Log::info("Follow-up email sent to lead ID: {$this->lead->id} at " . now());
    }
}