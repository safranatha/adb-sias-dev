<?php
namespace App\Services\SendTelegram\Tender\FormTugas;

use Http;

class UpdateStatusFormTugasTele
{
    protected string $token;

    public function __construct()
    {
        $this->token = config('services.telegram.bot_token');
    }

    public function sendMessageToPengirim(string $jenis_permintaan, string $penerima_id, string $chatId)
    {
        Http::post("https://api.telegram.org/bot{$this->token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => "✅ Tugas Telah Diselesaikan\n" .
                "Jenis Permintaan: {$jenis_permintaan}\n" .
                "Diselesaikan oleh: {$penerima_id}\n\n" .
                "Detail lebih lanjut, silakan cek SIAS Anda.",
        ]);
    }

}
