<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyLicense
{
    public function handle(Request $request, Closure $next): Response
    {
        $licenseKey = env('LICENSE_KEY');

        if (empty($licenseKey) || !$this->isValidLicense($licenseKey)) {
            abort(403, 'Invalid or expired license key');
        }

        return $next($request);
    }

    protected function isValidLicense($key): bool
    {
        // Hardcoded valid keys, or fetch from API
        $validKeys = [
            'XXXX-YYYY-ZZZZ-1234',
            'ABCD-EFGH-IJKL-MNOP',
        ];

        return in_array($key, $validKeys);
    }
}
