<?php
namespace App\Services\SendTelegram\Tender\SPH;

use App\Models\User;
use Http;

class ValidateSPHTele
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

    public function sendMessageToDirektur(string $text): void
    {
        $direktur = User::role('Direktur')
            ->whereNotNull('telegram_chat_id')
            ->first();

        $chatId = $direktur->telegram_chat_id;

        Http::post("https://api.telegram.org/bot{$this->token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
        ]);
    }

    public function sendMessageToStaff(string $text, string $chatId): void
    {
        // $staff = User::role('Staff Teknik')
        //     ->whereNotNull('telegram_chat_id')
        //     ->first();

        // $chatId = $staff->telegram_chat_id;

        Http::post("https://api.telegram.org/bot{$this->token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
        ]);
    }

}