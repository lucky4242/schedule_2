<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ScheduledSms;
use Twilio\Rest\Client;
use Carbon\Carbon;

class SendScheduledSms extends Command
{
    protected $signature = 'sms:send-scheduled';
    protected $description = 'Send scheduled SMS messages';

    public function handle()
    {
        $smsList = ScheduledSms::where('status', 'pending')
            ->where('send_at', '<=', Carbon::now())
            ->get();

        if ($smsList->isEmpty()) {
            $this->info('No scheduled SMS to send.');
            return;
        }

        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        foreach ($smsList as $sms) {
            try {
                $twilio->messages->create(
                    $sms->recipient,
                    [
                        'from' => env('TWILIO_PHONE_NUMBER'),
                        'body' => $sms->message,
                        'messagingServiceSid' => env('TWILIO_MESSAGING_SERVICE_SID'),
                    ]
                );

                $sms->update(['status' => 'sent']);
                $this->info("SMS sent to: {$sms->recipient}");
            } catch (\Exception $e) {
                $sms->update(['status' => 'failed']);
                $this->error("Failed to send SMS to {$sms->recipient}: " . $e->getMessage());
            }
        }
    }
}
