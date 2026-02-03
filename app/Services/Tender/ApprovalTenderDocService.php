<?php
namespace App\Services\Tender;

use App\Models\Proposal;
use App\Models\SuratPenawaranHarga;
use App\Models\User;
use App\Services\SendTelegram\Tender\Proposal\ValidateProposalTele;
use App\Services\SendTelegram\Tender\SPH\ValidateSPHTele;
use Illuminate\Database\Eloquent\Model;


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

        $namaProposal = Proposal::where('id', $id)->first()->nama_proposal;

        $documentApproval->update([
            'user_id' => auth()->user()->id,
            'status' => false,
            'level' => ($nama_role == "Manajer Teknik") ? "2" : ($nama_role == "Direktur" ? "3" : null),
            'keterangan' => ($nama_role == "Manajer Teknik") ? "Proposal ditolak oleh Manajer Teknik" : ($nama_role == "Direktur" ? "Proposal ditolak oleh Direktur" : null),
            'file_path_revisi' => $path,
            'pesan_revisi' => $pesan_revisi
        ]);

        $this->telegramPropo->sendMessageToStaff("Proposal $namaProposal ditolak oleh Manajer Teknik", $chatIdBasedOnUserId);

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

        $namaProposal = Proposal::where('id', $id)->first()->nama_proposal;

        $documentApproval->update([
            'user_id' => auth()->user()->id,
            'status' => true,
            'level' => ($nama_role == "Manajer Teknik") ? "2" : ($nama_role == "Direktur" ? "3" : null),
            'keterangan' => ($nama_role == "Manajer Teknik") ? "Proposal disetujui oleh Manajer Teknik" : ($nama_role == "Direktur" ? "Proposal disetujui oleh Direktur" : null),
        ]);

        $this->telegramPropo->sendMessageToStaff("Proposal $namaProposal di-approve oleh Manajer Teknik", $chatIdBasedOnUserId);

        $this->telegramPropo->sendMessageToDirektur("Proposal $namaProposal di-approve oleh Manajer Teknik");


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

        $documentApproval->update([
            'user_id' => auth()->user()->id,
            'status' => false,
            'level' => ($nama_role == "Manajer Admin") ? "2" : ($nama_role == "Direktur" ? "3" : null),
            'file_path_revisi' => $path,
            'pesan_revisi' => $pesan_revisi,
            'keterangan' => ($nama_role == "Manajer Admin") ? "Surat Penawaran Harga ditolak oleh Manajer Admin" : ($nama_role == "Direktur" ? "Surat Penawaran Harga ditolak oleh Direktur" : null),
        ]);

        $this->telegramSPH->sendMessageToStaff("Surat Penawaran Harga $namaSPH ditolak oleh Manajer Admin", $chatIdBasedOnUserId);
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

        $namaSPH = SuratPenawaranHarga::where('id', $id)->first()->nama_sph;

        $documentApproval->update([
            'user_id' => auth()->user()->id,
            'status' => true,
            'level' => ($nama_role == "Manajer Admin") ? "2" : ($nama_role == "Direktur" ? "3" : null),
            'keterangan' => ($nama_role == "Manajer Admin") ? "Surat Penawaran Harga disetujui oleh Manajer Admin" : ($nama_role == "Direktur" ? "Surat Penawaran Harga disetujui oleh Direktur" : null),
        ]);

        $this->telegramSPH->sendMessageToStaff("Surat Penawaran Harga $namaSPH di-approve oleh Manajer Admin", $chatIdBasedOnUserId);

        $this->telegramSPH->sendMessageToDirektur("Surat Penawaran Harga $namaSPH di-approve oleh Manajer Admin");
        return $documentApproval;
    }
}