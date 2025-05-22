<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WhatsAppService
{
    protected $twilio;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');

        if (empty($sid) || empty($token)) {
            throw new \RuntimeException('Twilio credentials not configured');
        }

        $this->twilio = new Client($sid, $token);
    }

    public function sendQuotation($lead, $pdfPath)
    {
        $pdfUrl = $this->uploadFileToCDN($pdfPath);

        try {
            $message = $this->twilio->messages
                ->create("whatsapp:+" . $this->formatPhoneNumber($lead->phone),
                [
                    "from" => "whatsapp:+" . config('services.twilio.whatsapp_number'),
                    "body" => "Hello {$lead->name}, please find attached your quotation.",
                    "mediaUrl" => [$pdfUrl]
                ]
            );

            Log::info('WhatsApp message sent', ['messageSid' => $message->sid]);
            return true;
        } catch (\Exception $e) {
            Log::error('WhatsApp message failed', ['error' => $e->getMessage()]);
            return false;
        }
    }

    protected function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (strlen($phone) == 10) {
            $phone = '91' . $phone; // India country code
        }

        return $phone;
    }

    protected function uploadFileToCDN($filePath)
    {
        // Implement your actual file upload logic
        return Storage::url(str_replace(storage_path('app/public/'), '', $filePath));
    }
}
