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
    public function getLevelAttribute()
    {
        return $this->document_approval_workflows()
            ->latest()
            ->value('level'); // langsung ambil status, tidak butuh first()
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

    public function getValidatorAttribute()
    {
        $user = $this->document_approval_workflows()
            ->latest()
            ->first();

        if ($user) {
            return $user->user->getRoleNames()->implode(', ');
        }

        return null;
    }

    public function latestWorkflow()
    {
        return $this->hasOne(DocumentApprovalWorkflow::class)
            ->latestOfMany('created_at');
    }


}
