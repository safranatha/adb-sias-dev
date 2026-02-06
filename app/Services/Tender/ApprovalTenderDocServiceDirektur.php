<?php
namespace App\Services\Tender;

use App\Models\Proposal;
use App\Models\SuratPenawaranHarga;
use App\Models\Tender;
use App\Models\User;
use App\Services\SendTelegram\Tender\Proposal\ValidateProposalTele;
use App\Services\SendTelegram\Tender\SPH\ValidateSPHTele;
use Illuminate\Database\Eloquent\Model;

class ApprovalTenderDocServiceDirektur
{

    protected ValidateSPHTele $telegramSPH;
    protected ValidateProposalTele $telegramPropo;

    public function __construct(ValidateSPHTele $telegramSPH, ValidateProposalTele $telegramPropo)
    {
        $this->telegramSPH = $telegramSPH;
        $this->telegramPropo = $telegramPropo;
    }

    public function rejectDocumentProposal(
        string $modelClass,
        int $id,
        string $nama_role,
        string $pesan_revisi,
        string $path
    ) {
        // Cari document approval berdasarkan proposal_id
        /** @var Model|null $data */
        $proposal_id = Proposal::where('tender_id', $id)->first()->id;
        $tender_name = Tender::where('id', $id)->first()->nama_tender;
        $namaProposal = Proposal::where('id', $id)->first()->nama_proposal;

        $createdByProposal = Proposal::where('id', $proposal_id)->first()->user_id;

        $chatIdBasedOnUserId = User::where('id', $createdByProposal)->first()->telegram_chat_id;

        $modelClass::create([
            'user_id' => auth()->user()->id,
            'proposal_id' => $proposal_id,
            'status' => false,
            'level' => ($nama_role == "Manajer Teknik") ? "2" : ($nama_role == "Direktur" ? "3" : null),
            'keterangan' => ($nama_role == "Manajer Teknik") ? "Proposal ditolak oleh Manajer Teknik" : ($nama_role == "Direktur" ? "Proposal ditolak oleh Direktur" : null),
            'file_path_revisi' => $path,
            'pesan_revisi' => $pesan_revisi
        ]);

        $message = "❌ *Proposal Ditolak*\n\n"
            . "📌 *Tender* : {$tender_name}\n"
            . "📄 *Nama Proposal* : {$namaProposal}\n"
            . "👤 *Ditolak oleh* : {$nama_role}\n"
            . "📝 *Alasan Revisi* :\n"
            . "{$pesan_revisi}\n"
            . "Silahkan cek dan revisi kembali proposal Anda melalui SIAS.";

        $this->telegramPropo->sendMessageToStaff($message, $chatIdBasedOnUserId);
        $this->telegramPropo->sendMessageToManajer($message);
        return null;
    }

    public function approveDocumentProposal(
        string $modelClass,
        int $id,
        string $nama_role
    ) {
        // Cari document approval berdasarkan proposal_id
        $proposal_id = Proposal::where('tender_id', $id)->first()->id;
        $tender_name = Tender::where('id', $id)->first()->nama_tender;
        $namaProposal = Proposal::where('id', $id)->first()->nama_proposal;

        $createdByProposal = Proposal::where('id', $proposal_id)->first()->user_id;

        $chatIdBasedOnUserId = User::where('id', $createdByProposal)->first()->telegram_chat_id;

        /** @var Model|null $data */
        $modelClass::create([
            'user_id' => auth()->user()->id,
            'proposal_id' => $proposal_id,
            'status' => true,
            'level' => ($nama_role == "Manajer Teknik") ? "2" : ($nama_role == "Direktur" ? "3" : null),
            'keterangan' => ($nama_role == "Manajer Teknik") ? "Proposal disetujui oleh Manajer Teknik" : ($nama_role == "Direktur" ? "Proposal disetujui oleh Direktur" : null),
        ]);

        // Format pesan Telegram
        $message = "✅ *Proposal Disetujui*\n\n"
            . "📌 *Tender* : {$tender_name}\n"
            . "📄 *Nama Proposal* : {$namaProposal}\n"
            . "👤 *Disetujui oleh* : {$nama_role}\n"
            . " Silahkan cek proposal Anda melalui SIAS.";

        $this->telegramPropo->sendMessageToStaff($message, $chatIdBasedOnUserId);
        $this->telegramPropo->sendMessageToManajer($message);
        return null;
    }

    public function rejectDocumentSPH(
        string $modelClass,
        int $id,
        string $nama_role,
        string $pesan_revisi,
        string $path
    ) {
        $sph_id = SuratPenawaranHarga::where('tender_id', $id)->first()->id;
        $tender_name = Tender::where('id', $id)->first()->nama_tender;
        $namaSPH = SuratPenawaranHarga::where('id', $sph_id)->first()->nama_sph;

        $createdBySPH = SuratPenawaranHarga::where('id', $sph_id)->first()->user_id;

        $chatIdBasedOnUserId = User::where('id', $createdBySPH)->first()->telegram_chat_id;

        // Cari document approval berdasarkan surat_penawaran_harga_id
        /** @var Model|null $data */

        // Format pesan Telegram
        $message = "❌ *Surat Penawaran Harga Ditolak*\n\n"
            . "📌 *Tender* : {$tender_name}\n"
            . "📄 *Nama SPH* : {$namaSPH}\n"
            . "👤 *Ditolak oleh* : {$nama_role}\n\n"
            . "📝 *Alasan Revisi* :\n"
            . "{$pesan_revisi}\n"
            . " Silahkan cek dan revisi kembali Surat Penawaran Harga Anda melalui SIAS.";

        $this->telegramSPH->sendMessageToStaff($message, $chatIdBasedOnUserId);
        $this->telegramSPH->sendMessageToManajer($message);

        return null;
    }

    public function approveDocumentSPH(
        string $modelClass,
        int $id,
        string $nama_role
    ) {
        $sph_id = SuratPenawaranHarga::where('tender_id', $id)->first()->id;
        $tender_name = Tender::where('id', $id)->first()->nama_tender;
        $namaSPH = SuratPenawaranHarga::where('id', $sph_id)->first()->nama_sph;

        $createdBySPH = SuratPenawaranHarga::where('id', $sph_id)->first()->user_id;

        $chatIdBasedOnUserId = User::where('id', $createdBySPH)->first()->telegram_chat_id;

        // Cari document approval berdasarkan surat_penawaran_harga_id
        /** @var Model|null $data */
        $modelClass::create([
            'user_id' => auth()->user()->id,
            'surat_penawaran_harga_id' => $sph_id,
            'status' => true,
            'level' => ($nama_role == "Manajer Admin") ? "2" : ($nama_role == "Direktur" ? "3" : null),
            'keterangan' => ($nama_role == "Manajer Admin") ? "Surat Penawaran Harga disetujui oleh Manajer Admin" : ($nama_role == "Direktur" ? "Surat Penawaran Harga disetujui oleh Direktur" : null),
        ]);

        // Format pesan Telegram
        $message = "✅ *Surat Penawaran Harga Disetujui*\n\n"
            . "📌 *Tender* : {$tender_name}\n"
            . "📄 *Nama SPH* : {$namaSPH}\n"
            . "👤 *Disetujui oleh* : {$nama_role}\n"
            ." Silahkan cek Surat Penawaran Harga Anda melalui SIAS.";

        $this->telegramSPH->sendMessageToStaff($message, $chatIdBasedOnUserId);
        $this->telegramSPH->sendMessageToManajer($message);

        return null;
    }
}