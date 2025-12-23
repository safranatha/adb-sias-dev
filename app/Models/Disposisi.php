<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    //
    use HasFactory;

    protected $fillable=[
        'form_tugas_id',
        'penerima_id',
        'waktu_disposisi_dibaca'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'penerima_id');
    }

    public function form_tugas()
    {
        return $this->belongsTo(FormTugas::class);
    }

}
