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
        return $this->belongsTo(Proposal::class);
    }


    // asssor helper for get
    // public function getCountProposalAttribute()
    // {
    //     return self::where('proposal_id', $this->proposal_id)
    //         ->count();
    // }

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
}
