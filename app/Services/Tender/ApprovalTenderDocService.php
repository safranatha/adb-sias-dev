<?php
namespace App\Services\Tender;

use App\Models\Proposal;
use App\Models\SuratPenawaranHarga;
use App\Models\User;
use App\Services\SendTelegram\Tender\Proposal\ValidateProposalTele;
use App\Services\SendTelegram\Tender\SPH\ValidateSPHTele;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tender;


class ApprovalTenderDocService
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
        $documentApproval = $modelClass::where('proposal_id', $id)
            ->latest() // Ambil yang terbaru
            ->first();

        if (!$documentApproval) {
            return null;
        }

        $createdByProposal = Proposal::where('id', $id)->first()->user_id;

        $chatIdBasedOnUserId = User::where('id', $createdByProposal)->first()->telegram_chat_id;
        
        $tender_name = Tender::where('id', Proposal::where('id', $id)->first()->tender_id)->first()->nama_tender;
        $namaProposal = Proposal::where('id', $id)->first()->nama_proposal;

        $documentApproval->update([
            'user_id' => auth()->user()->id,
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

        return $documentApproval;
    }

    public function approveDocumentProposal(
        string $modelClass,
        int $id,
        string $nama_role
    ) {
        // Cari document approval berdasarkan proposal_id
        /** @var Model|null $data */
        $documentApproval = $modelClass::where('proposal_id', $id)
            ->latest() // Ambil yang terbaru
            ->first();


        $createdByProposal = Proposal::where('id', $id)->first()->user_id;

        $chatIdBasedOnUserId = User::where('id', $createdByProposal)->first()->telegram_chat_id;
        $tender_name = Tender::where('id', Proposal::where('id', $id)->first()->tender_id)->first()->nama_tender;
        $namaProposal = Proposal::where('id', $id)->first()->nama_proposal;

        $documentApproval->update([
            'user_id' => auth()->user()->id,
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
        $this->telegramSPH->sendMessageToDirektur($message);

        return $documentApproval;
    }

    public function rejectDocumentSPH(
        string $modelClass,
        int $id,
        string $nama_role,
        string $pesan_revisi,
        string $path
    ) {
        // Cari document approval berdasarkan surat_penawaran_harga_id
        $documentApproval = $modelClass::where('surat_penawaran_harga_id', $id)
            ->latest() // Ambil yang terbaru
            ->first();

        $createdBySPH = SuratPenawaranHarga::where('id', $id)->first()->user_id;

        $chatIdBasedOnUserId = User::where('id', $createdBySPH)->first()->telegram_chat_id;

        $namaSPH = SuratPenawaranHarga::where('id', $id)->first()->nama_sph;
        // $tender_name = Tender::where('id', $id)->first()->nama_tender;
        $tender_name = Tender::where('id', SuratPenawaranHarga::where('id', $id)->first()->tender_id)->first()->nama_tender;

        $documentApproval->update([
            'user_id' => auth()->user()->id,
            'status' => false,
            'level' => ($nama_role == "Manajer Admin") ? "2" : ($nama_role == "Direktur" ? "3" : null),
            'file_path_revisi' => $path,
            'pesan_revisi' => $pesan_revisi,
            'keterangan' => ($nama_role == "Manajer Admin") ? "Surat Penawaran Harga ditolak oleh Manajer Admin" : ($nama_role == "Direktur" ? "Surat Penawaran Harga ditolak oleh Direktur" : null),
        ]);

        // Format pesan Telegram
        $message = "❌ *Surat Penawaran Harga Ditolak*\n\n"
            . "📌 *Tender* : {$tender_name}\n"
            . "📄 *Nama SPH* : {$namaSPH}\n"
            . "👤 *Ditolak oleh* : {$nama_role}\n\n"
            . "📝 *Alasan Revisi* :\n"
            . "{$pesan_revisi}\n"
            . " Silahkan cek dan revisi kembali Surat Penawaran Harga Anda melalui SIAS.";

        $this->telegramSPH->sendMessageToStaff($message, $chatIdBasedOnUserId);
        return $documentApproval;
    }

    public function approveDocumentSPH(
        string $modelClass,
        int $id,
        string $nama_role
    ) {
        // Cari document approval berdasarkan surat_penawaran_harga_id
        $documentApproval = $modelClass::where('surat_penawaran_harga_id', $id)
            ->latest() // Ambil yang terbaru
            ->first();

        $createdBySPH = SuratPenawaranHarga::where('id', $id)->first()->user_id;

        $chatIdBasedOnUserId = User::where('id', $createdBySPH)->first()->telegram_chat_id;
        // $tender_name = Tender::where('id', $id)->first()->nama_tender;
        $tender_name = Tender::where('id', SuratPenawaranHarga::where('id', $id)->first()->tender_id)->first()->nama_tender;
        $namaSPH = SuratPenawaranHarga::where('id', $id)->first()->nama_sph;

        $documentApproval->update([
            'user_id' => auth()->user()->id,
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
        $this->telegramSPH->sendMessageToDirektur($message);

        return $documentApproval;
    }
}