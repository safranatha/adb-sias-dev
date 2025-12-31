<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tender extends Model
{
    use HasFactory;

    // fillable
    protected $fillable = [
        'nama_tender',
        'nama_klien',
        'file_pra_kualifikasi',
    ];

    public function proposal(): HasOne
    {
        return $this->hasOne(Proposal::class);
    }

    public function surat_penawaran_harga(): HasOne
    {
        return $this->hasOne(SuratPenawaranHarga::class);
    }
    public function internal_memo() :HasOne{
        return $this->hasOne(InternalMemo::class);
    }

    public function getStatusTenderAttribute(): string
    {
        return match ($this->status) {
            'Gagal' => 'Gagal',
            'Berhasil' => 'Berhasil',
            'Dalam Proses' => 'Dalam Proses',
            default => 'Status Tidak Diketahui',
        };
    }

    public function getLevelPropoAttribute()
    {
        $latestWorkflow = $this->proposal?->document_approval_workflows()
            ->latest()
            ->first();

        if (!$latestWorkflow) {
            return 'Proposal baru diupload';
        }

        if ($latestWorkflow->level === "3" && $latestWorkflow->status === 1) {
            return 'Proposal telah disetujui Direktur';
        }

        elseif ($latestWorkflow->level === "3" && $latestWorkflow->status === 0) {
            return 'Proposal ditolak oleh Direktur';
        }

        elseif ($latestWorkflow->level === "2" && $latestWorkflow->status === 1) {
            return 'Proposal telah disetujui Manajer Teknik';
        }

        elseif ($latestWorkflow->level === "2" && $latestWorkflow->status === 0) {
            return 'Proposal menunggu persetujuan Manajer Teknik';
        }

        return 'Menunggu proses persetujuan';
    }

    public function getLevelSphAttribute()
    {
        $latestWorkflow = $this->surat_penawaran_harga?->document_approval_workflows()
            ->latest()
            ->first();

        if (!$latestWorkflow) {
            return 'SPH baru diupload';
        }

        if ($latestWorkflow->level === "3" && $latestWorkflow->status === 1) {
            return 'SPH telah disetujui Direktur';
        }

        elseif ($latestWorkflow->level === "3" && $latestWorkflow->status === 0) {
            return 'SPH ditolak oleh Direktur';
        }

        elseif ($latestWorkflow->level === "2" && $latestWorkflow->status === 1) {
            return 'SPH telah disetujui Manajer Admin';
        }

        elseif ($latestWorkflow->level === "2" && $latestWorkflow->status === 0) {
            return 'SPH menunggu persetujuan Manajer Admin';
        }

        return 'Menunggu proses persetujuan';
    }
}
