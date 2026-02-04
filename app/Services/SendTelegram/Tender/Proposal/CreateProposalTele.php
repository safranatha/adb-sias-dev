<?php
namespace App\Services\SendTelegram\Tender\Proposal;

use App\Models\User;
use Http;

class CreateProposalTele
{
    protected string $token;

    public function __construct()
    {
        $this->token = config('services.telegram.bot_token');
    }

    public function sendMessageToManajer(
        string $namaStaff,
        string $namaProposal,
        string $namaTender
    ): void {
        $manager = User::role('Manajer Teknik')
            ->whereNotNull('telegram_chat_id')
            ->first();

        if (!$manager) {
            return;
        }

        $text =
            "*📄 Proposal Baru Diajukan*\n" .
            "*Dibuat oleh:* {$namaStaff}\n" .
            "*Nama Proposal:* {$namaProposal}\n" .
            "*Tender:* {$namaTender}\n\n" .
            "_Silakan lakukan pemeriksaan proposal melalui SIAS._";

        Http::post("https://api.telegram.org/bot{$this->token}/sendMessage", [
            'chat_id' => $manager->telegram_chat_id,
            'text' => $text,
            'parse_mode' => 'Markdown',
        ]);
    }
}