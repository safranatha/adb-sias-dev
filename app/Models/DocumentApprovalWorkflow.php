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
    public function getCountProposalAttribute()
    {
        return self::where('proposal_id', $this->id)
            ->count();
    }

    public function getStatusProposalAttribute()
    {
        if ($this->count_proposal == 1 || $this->count_proposal == null) {  // Memanggil accessor pertama
            return 'Proposal Baru';
        }

        return 'Proposal Revisi ke-' . ($this->count_proposal - 1);
    }
}
