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
}
