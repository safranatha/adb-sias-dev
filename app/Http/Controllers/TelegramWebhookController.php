<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
class TelegramWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $message = $request->input('message');
         Log::info('WEBHOOK HIT', $request->all());

        if (!isset($message['text'])) {
            return response()->json(['ok' => true]);
        }
        Log::info('MESSAGE', $message ?? []);

        $text = $message['text'];
        $chatId = $message['chat']['id'];

        // format: /connect TOKEN
        if (str_starts_with($text, '/connect')) {
            $token = trim(str_replace('/connect', '', $text));

            $hashedToken = hash('sha256', $token);

            $user = User::where('telegram_connect_token', $hashedToken)->first();

            if (!$user) {
                return response()->json(['ok' => true]);
            }

            $user->update([
                'telegram_chat_id' => $chatId,
                'telegram_connect_token' => null,
            ]);
        }

        return response()->json(['ok' => true]);
    }
}
