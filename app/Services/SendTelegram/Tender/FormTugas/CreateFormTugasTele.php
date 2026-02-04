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

    public function sendMessageToPenerima(
        string $jenis_permintaan,
        string $kegiatan,
        string $chatId,
        string $due_date
    ) {
        Http::post("https://api.telegram.org/bot{$this->token}/sendMessage", [
            'chat_id' => $chatId,
            'text' =>
                "📌 Form Tugas Baru\n" .
                "Jenis Permintaan: {$jenis_permintaan}\n" .
                "Kegiatan: {$kegiatan}\n" .
                "Batas Waktu: {$due_date}\n\n" .
                "Detail lebih lanjut, silakan cek SIAS Anda!",
        ]);
    }

}