<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'tender_id',
        'nama_proposal',
        'file_path_proposal',
        // 'nama_klien',
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function document_approval_workflows()
    {
        return $this->hasMany(DocumentApprovalWorkflow::class);
    }

    // get status dan auto generate properties, nnti tinggal panggil proposal(model)->status. itu didapat dari getStatusAttribute (generate property status)
    public function getStatusAttribute()
    {
        return $this->document_approval_workflows()
            ->latest()
            ->value('status'); // langsung ambil status, tidak butuh first()
    }

    public function getPesanRevisiAttribute()
    {
        return $this->document_approval_workflows()
            ->latest()
            ->value('pesan_revisi'); 
    }

    public function getKeteranganAttribute()
    {
        return $this->document_approval_workflows()
            ->latest()
            ->value('keterangan'); 
    }


    // buat asssor get count proposal (count_proposal)
    public function getCountProposalAttribute()
    {
        return $this->document_approval_workflows()
            ->where('proposal_id', $this->id)
            ->count();
    }

    // manipulasi get count proposal (status_proposal)
    public function getStatusProposalAttribute()
    {
        if ($this->count_proposal == 1 || $this->count_proposal == null) {  // Memanggil accessor pertama
            return 'Proposal Baru';
        }

        return 'Proposal Revisi ke-' . ($this->count_proposal - 1);
    }

}
