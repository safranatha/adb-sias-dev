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
    ];

    public function proposal(): HasOne
    {
        return $this->hasOne(Proposal::class);
    }

    public function surat_penawaran_harga(): HasOne
    {
        return $this->hasOne(SuratPenawaranHarga::class);
    }

    public function getStatusAttribute()
    {
        $status= $this->proposal?->document_approval_workflows()
            ->latest()
            ->value('status') ?? null;
        
        $level= $this->proposal?->document_approval_workflows()
            ->latest()
            ->value('level') ?? null;
        
        if($level == 3){
            return true;
        }
    }
}
