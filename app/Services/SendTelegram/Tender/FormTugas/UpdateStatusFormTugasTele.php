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
            'text' =>  'Form tugas baru dengan jenis permintaan ' . $jenis_permintaan . ' telah diselesaikan oleh '.$penerima_id.', silahkan cek SIAS anda.',
        ]);
    }

}
