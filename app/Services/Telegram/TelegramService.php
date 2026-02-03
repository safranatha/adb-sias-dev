<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected string $token;

    public function __construct()
    {
        $this->token = config('services.telegram.bot_token');
    }

    public function sendMessage(string $chatId, string $text): void
    {
        Http::post("https://api.telegram.org/bot{$this->token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
        ]);
    }
}
