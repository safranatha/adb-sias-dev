<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPenawaranHarga extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'tender_id',
        'nama_sph',
        'file_path_sph',
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
            ->value('pesan_revisi'); // langsung ambil status, tidak butuh first()
    }

    public function getKeteranganAttribute()
    {
        return $this->document_approval_workflows()
            ->latest()
            ->value('keterangan'); // langsung ambil status, tidak butuh first()
    }
    public function latestWorkflow()
    {
        return $this->hasOne(DocumentApprovalWorkflow::class)
            ->latestOfMany('created_at');
    }
}
