<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\License;
use App\Mail\LicenseExpiryReminder;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // 1. Send follow-up emails every minute (if you have such command)
        $schedule->command('email:send-followups')
                 ->everyMinute()
                 ->appendOutputTo(storage_path('logs/followup-emails.log'));

        // 2. Deactivate expired licenses with log and check for license_key
        $schedule->call(function () {
            Log::info('Deactivating expired licenses...');
            $expiredLicenses = License::where('is_active', true)
                ->where('end_date', '<', now())
                ->get();

            foreach ($expiredLicenses as $license) {
                Log::info('Deactivating license with key: ' . $license->license_key);
            }

            License::where('is_active', true)
                ->where('end_date', '<', now())
                ->update(['is_active' => false]);

            Log::info('Expired license deactivation complete.');
        })->daily();

        // 3. Send license expiry reminder emails with log and license_key
        $schedule->call(function () {
            Log::info('Checking licenses for upcoming expiry...');
            $licenses = License::where('is_active', true)
                ->whereBetween('end_date', [now(), now()->addDays(3)])
                ->get();

            foreach ($licenses as $license) {
                Log::info('Sending expiry email for license: ' . $license->license_key);
                // Send the email
                if ($license->user) {
                    Mail::to($license->user->email)  // Assuming license has a related user
                        ->send(new LicenseExpiryReminder($license));
                    Log::info('Expiry reminder sent for license: ' . $license->license_key);
                } else {
                    Log::warning('License with key ' . $license->license_key . ' has no associated user.');
                }
            }
            Log::info('Expiry reminders sent.');
        })->daily();
    }


    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}