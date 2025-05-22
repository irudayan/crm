<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\License;
use Illuminate\Http\Request;

class CheckLicense
{
    public function handle(Request $request, Closure $next)
    {
        // Skip license check for these routes
        if ($request->is('admin/licenses*')) {
            return $next($request);
        }

        // Get license key from config or database
        $licenseKey = config('app.license_key');

        if (empty($licenseKey)) {
            return redirect()->route('admin.license.activate')->with('error', 'Please activate your license');
        }

        $license = License::where('license_key', $licenseKey)->first();

        if (!$license) {
            return redirect()->route('admin.license.activate')->with('error', 'Invalid license key');
        }

        if (!$license->isValid()) {
            return redirect()->route('admin.license.activate')->with('error', 'License has expired or is inactive');
        }

        return $next($request);
    }
}
