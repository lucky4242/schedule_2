<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduledSms;
use Carbon\Carbon;

class ScheduledSmsController extends Controller
{
    public function scheduleSms(Request $request)
    {
        $request->validate([
            'recipient' => 'required|string',
            'message' => 'required|string',
            'send_at' => 'required|date|after:now',
        ]);

        ScheduledSms::create([
            'recipient' => $request->recipient,
            'message' => $request->message,
            'send_at' => Carbon::parse($request->send_at),
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'SMS scheduled successfully!']);
    }
}
