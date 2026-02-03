<?php
namespace App\Services\SendTelegram\Tender\SPH;

use App\Models\User;
use Http;

class ReviseSPHTele
{
    protected string $token;

    public function __construct()
    {
        $this->token = config('services.telegram.bot_token');
    }

    public function sendMessageToManajer(string $text): void
    {
        $manager = User::role('Manajer Admin')
            ->whereNotNull('telegram_chat_id')
            ->first();

        $chatId = $manager->telegram_chat_id;

        Http::post("https://api.telegram.org/bot{$this->token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
        ]);
    }
}