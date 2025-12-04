<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternalMemo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tender_id',
        'nama_internal_memo',
        'isi_internal_memo',
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }
}
