<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\License;

class CheckLicenseCommand extends Command
{
    protected $signature = 'license:check';
    protected $description = 'Check the current license status';

    public function handle()
    {
        $licenseKey = config('app.license_key');

        if (empty($licenseKey)) {
            $this->error('No license key found');
            return 1;
        }

        $license = License::where('license_key', $licenseKey)->first();

        if (!$license) {
            $this->error('Invalid license key');
            return 1;
        }

        if ($license->isValid()) {
            $this->info('License is valid');
            $this->line("Type: {$license->plan}");
            $this->line("Expires: {$license->end_date->format('Y-m-d')}");
            return 0;
        }

        $this->error('License has expired or is inactive');
        return 1;
    }
}
