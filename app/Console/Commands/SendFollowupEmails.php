<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Leads;
use Carbon\Carbon;
use App\Jobs\SendFollowupEmailJob;
use Illuminate\Support\Facades\Log;

class SendFollowupEmails extends Command
{
    protected $signature = 'email:send-followups';
    protected $description = 'Send follow up emails 30 minutes before follow time';

    public function handle()
    {
        $now = Carbon::now();
        $thirtyMinutesLater = $now->copy()->addMinutes(30);

        Log::info("Running follow-up check at {$now} for time {$thirtyMinutesLater}");

        $leads = Leads::where('follow_mail_status', 0)
            ->whereDate('follow_date', $thirtyMinutesLater->toDateString())
            ->whereTime('follow_time', '>=', $thirtyMinutesLater->format('H:i:00'))
            ->whereTime('follow_time', '<=', $thirtyMinutesLater->format('H:i:59'))
            ->get();

        foreach ($leads as $lead) {
            $followDateTime = Carbon::parse($lead->follow_date . ' ' . $lead->follow_time);

            if ($followDateTime->diffInMinutes($now) <= 30) {
                SendFollowupEmailJob::dispatch($lead);
                $lead->update(['follow_mail_status' => 1]);
                Log::info("Dispatched follow-up for lead ID: {$lead->id}");
            }
        }

        $this->info("Dispatched {$leads->count()} follow-up emails");
    }
}
