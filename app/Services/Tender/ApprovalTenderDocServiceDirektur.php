<?php
namespace App\Services\Tender;

use App\Models\Proposal;
use App\Models\SuratPenawaranHarga;
use Illuminate\Database\Eloquent\Model;

class ApprovalTenderDocServiceDirektur
{
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

        return $modelClass::create([
            'user_id' => auth()->user()->id,
            'proposal_id' => $proposal_id,
            'status' => false,
            'level' => ($nama_role == "Manajer Teknik") ? "2" : ($nama_role == "Direktur" ? "3" : null),
            'keterangan' => ($nama_role == "Manajer Teknik") ? "Proposal ditolak oleh Manajer Teknik" : ($nama_role == "Direktur" ? "Proposal ditolak oleh Direktur" : null),
            'file_path_revisi' => $path,
            'pesan_revisi' => $pesan_revisi
        ]);
    }

    public function approveDocumentProposal(
        string $modelClass,
        int $id,
        string $nama_role
    ) {
        // Cari document approval berdasarkan proposal_id
        $proposal_id = Proposal::where('tender_id', $id)->first()->id;

        /** @var Model|null $data */
        return $modelClass::create([
            'user_id' => auth()->user()->id,
            'proposal_id' => $proposal_id,
            'status' => true,
            'level' => ($nama_role == "Manajer Teknik") ? "2" : ($nama_role == "Direktur" ? "3" : null),
            'keterangan' => ($nama_role == "Manajer Teknik") ? "Proposal disetujui oleh Manajer Teknik" : ($nama_role == "Direktur" ? "Proposal disetujui oleh Direktur" : null),
        ]);
    }

    public function rejectDocumentSPH(
        string $modelClass,
        int $id,
        string $nama_role,
        string $pesan_revisi,
        string $path
    ) {
        $sph_id=SuratPenawaranHarga::where('tender_id', $id)->first()->id;
        // Cari document approval berdasarkan surat_penawaran_harga_id
        /** @var Model|null $data */

        return $modelClass::create([
            'user_id' => auth()->user()->id,
            'surat_penawaran_harga_id' => $sph_id,
            'status' => false,
            'level' => ($nama_role == "Manajer Admin") ? "2" : ($nama_role == "Direktur" ? "3" : null),
            'file_path_revisi' => $path,
            'pesan_revisi' => $pesan_revisi,
            'keterangan' => ($nama_role == "Manajer Admin") ? "Surat Penawaran Harga ditolak oleh Manajer Admin" : ($nama_role == "Direktur" ? "Surat Penawaran Harga ditolak oleh Direktur" : null),
        ]);
    }

    public function approveDocumentSPH(
        string $modelClass,
        int $id,
        string $nama_role
    ) {
        $sph_id=SuratPenawaranHarga::where('tender_id', $id)->first()->id;

        // Cari document approval berdasarkan surat_penawaran_harga_id
        /** @var Model|null $data */
        return $modelClass::create([
            'user_id' => auth()->user()->id,
            'surat_penawaran_harga_id' => $sph_id,
            'status' => true,
            'level' => ($nama_role == "Manajer Admin") ? "2" : ($nama_role == "Direktur" ? "3" : null),
            'keterangan' => ($nama_role == "Manajer Admin") ? "Surat Penawaran Harga disetujui oleh Manajer Admin" : ($nama_role == "Direktur" ? "Surat Penawaran Harga disetujui oleh Direktur" : null),
        ]);
    }
}