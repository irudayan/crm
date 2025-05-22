<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\License;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class LicenseController extends Controller
{
    public function index()
    {
        $licenses = License::latest()->paginate(20);
        return view('admin.licenses.index', compact('licenses'));
    }

    public function create()
    {
        return view('admin.licenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'plan' => 'required|in:trial,1year,2years',
            'notes' => 'nullable|string'
        ]);

        $plan = $request->plan;
        $start = Carbon::now();
        $end = $this->calculateEndDate($plan, $start);

        $license = License::create([
            'license_key' => $this->generateLicenseKey(),
            'email' => $request->email,
            'plan' => $plan,
            'start_date' => $start,
            'end_date' => $end,
            'is_active' => true,
            'notes' => $request->notes
        ]);

        return redirect()->route('admin.licenses.index')
            ->with('success', 'License created successfully!');
    }

    public function show(License $license)
    {
        return view('admin.licenses.show', compact('license'));
    }

    public function edit(License $license)
    {
        return view('admin.licenses.edit', compact('license'));
    }

    public function update(Request $request, License $license)
    {
        $request->validate([
            'email' => 'required|email',
            'is_active' => 'boolean',
            'notes' => 'nullable|string'
        ]);

        $license->update([
            'email' => $request->email,
            'is_active' => $request->has('is_active'),
            'notes' => $request->notes
        ]);

        return redirect()->route('admin.licenses.index')
            ->with('success', 'License updated successfully!');
    }

    public function destroy(License $license)
    {
        $license->delete();
        return redirect()->route('admin.licenses.index')
            ->with('success', 'License deleted successfully!');
    }

    public function download(License $license)
    {
        $content = "License Key: {$license->license_key}\n";
        $content .= "Email: {$license->email}\n";
        $content .= "Plan: {$license->plan}\n";
        $content .= "Start Date: {$license->start_date->format('Y-m-d')}\n";
        $content .= "End Date: {$license->end_date->format('Y-m-d')}\n";
        $content .= "Status: {$license->status}\n\n";
        $content .= "Activation Instructions:\n";
        $content .= "1. Install the software\n";
        $content .= "2. Enter this license key when prompted\n";
        $content .= "3. Enjoy your {$license->plan} license!\n";

        $filename = "license_{$license->license_key}.txt";

        return response()->streamDownload(function() use ($content) {
            echo $content;
        }, $filename, [
            'Content-Type' => 'text/plain',
        ]);
    }

    public function bulkGenerate(Request $request)
    {
        $request->validate([
            'count' => 'required|integer|min:1|max:100',
            'plan' => 'required|in:trial,1year,2years'
        ]);

        $licenses = [];
        $start = Carbon::now();
        $end = $this->calculateEndDate($request->plan, $start);

        for ($i = 0; $i < $request->count; $i++) {
            $licenses[] = License::create([
                'license_key' => $this->generateLicenseKey(),
                'email' => 'bulk_generated@example.com',
                'plan' => $request->plan,
                'start_date' => $start,
                'end_date' => $end,
                'is_active' => true,
                'notes' => 'Bulk generated license'
            ]);
        }

        return redirect()->route('admin.licenses.index')
            ->with('success', "{$request->count} licenses generated successfully!");
    }

    public function toggleStatus(License $license)
    {
        $license->update(['is_active' => !$license->is_active]);
        $status = $license->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "License {$status} successfully!");
    }

    public function showActivationForm()
    {
        return view('admin.licenses.activate');
    }

    public function activate(Request $request)
    {
        $request->validate([
            'license_key' => 'required|string'
        ]);

        $license = License::where('license_key', $request->license_key)->first();

        if (!$license) {
            return back()->with('error', 'Invalid license key');
        }

        if (!$license->isValid()) {
            return back()->with('error', 'License has expired or is inactive');
        }

        // Store license key in config
        $this->setLicenseKeyInConfig($request->license_key);

        // Clear cache
        Artisan::call('config:clear');

        return redirect()->route('admin.home')->with('success', 'License activated successfully!');
    }

    public function check()
    {
        $licenseKey = config('app.license_key');

        if (empty($licenseKey)) {
            return response()->json(['valid' => false, 'message' => 'No license key found']);
        }

        $license = License::where('license_key', $licenseKey)->first();

        if (!$license) {
            return response()->json(['valid' => false, 'message' => 'Invalid license key']);
        }

        return response()->json([
            'valid' => $license->isValid(),
            'license' => $license
        ]);
    }

    protected function setLicenseKeyInConfig($licenseKey)
    {
        $configPath = config_path('app.php');
        $config = file_get_contents($configPath);

        // Add or update license key in config
        if (strpos($config, "'license_key'") === false) {
            $config = str_replace(
                "'name' => env('APP_NAME', 'Laravel'),",
                "'name' => env('APP_NAME', 'Laravel'),\n\t'license_key' => '$licenseKey',",
                $config
            );
        } else {
            $config = preg_replace(
                "/'license_key' => '.*?'/",
                "'license_key' => '$licenseKey'",
                $config
            );
        }

        file_put_contents($configPath, $config);
    }

    private function generateLicenseKey()
    {
        return strtoupper(Str::random(4) . '-' . Str::random(4) . '-' . Str::random(4) . '-' . Str::random(4));
    }

    private function calculateEndDate($plan, $startDate)
    {
        return match ($plan) {
            'trial' => $startDate->copy()->addDays(10),
            '1year' => $startDate->copy()->addYear(),
            '2years' => $startDate->copy()->addYears(2),
        };
    }
}
