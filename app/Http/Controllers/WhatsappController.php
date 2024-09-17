<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsAppController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'message' => 'required|string',
        ]);

        $phoneNumber = $request->input('phone_number');
        $message = $request->input('message');

        $command = "node public/scripts/sendMessage.js {$phoneNumber} \"{$message}\"";
        $output = [];
        $returnValue = 0;

        exec($command, $output, $returnValue);

        if ($returnValue === 0) {
            return response()->json(['status' => 'success', 'message' => 'Message sent successfully.']);
        } else {
            Log::error('Failed to send message', ['output' => $output]);
            return response()->json(['status' => 'error', 'message' => 'Failed to send message.']);
        }
    }
}
