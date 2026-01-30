<?php
namespace App\Services\SendTelegram\Tender\FormTugas;

use Http;

class CreateFormTugasTele
{
    protected string $token;

    public function __construct()
    {
        $this->token = config('services.telegram.bot_token');
    }

    public function sendMessageToPenerima(string $jenis_permintaan, string $chatId)
    {
        Http::post("https://api.telegram.org/bot{$this->token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => 'Terdapat form tugas baru dengan jenis permintaan ' . $jenis_permintaan . ', silahkan cek SIAS anda.',
        ]);
    }
}