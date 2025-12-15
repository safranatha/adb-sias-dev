<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentApprovalWorkflow extends Model
{
    use HasFactory;
    protected $table = 'document_approval_workflow';

    protected $fillable = [
        'user_id',
        'proposal_id',
        'surat_penawaran_harga_id',
        'level',
        'status',
        'keterangan',
        'pesan_revisi',
        'waktu_pesan_dibaca',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function surat_penawaran_harga()
    {
        return $this->belongsTo(SuratPenawaranHarga::class);
    }


    // assesor untuk get status dokumen (penggolongan dokumen baru atau revisi. jika revisi sudah yang keberapa)

    // proposal
    public function getStatusProposalAttribute()
    {
        // Hitung ada berapa workflow yang lebih lama dari row ini untuk proposal yang sama
        $olderWorkflowCount = self::where('proposal_id', $this->proposal_id)
            ->where('created_at', '<', $this->created_at)
            ->count();

        if ($olderWorkflowCount == 0) {
            return 'Proposal Baru';
        }

        return 'Proposal Revisi ke-' . $olderWorkflowCount;
    }

    // surat penawaran harga
    public function getStatusSphAttribute()
    {
        // Hitung ada berapa workflow yang lebih lama dari row ini untuk surat penawaran harga yang sama
        $olderWorkflowCount = self::where('surat_penawaran_harga_id', $this->surat_penawaran_harga_id)
            ->where('created_at', '<', $this->created_at)
            ->count();

        if ($olderWorkflowCount == 0) {
            return 'Surat Penawaran Harga Baru';
        }

        return 'Surat Penawaran Harga Revisi ke-' . $olderWorkflowCount;
    }

}
