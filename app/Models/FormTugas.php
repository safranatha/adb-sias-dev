<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormTugas extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'status',
        'due_date',
        'jenis_permintaan',
        'kegiatan',
        'keterangan',
        'file_path_form_tugas',
        'lingkup_kerja',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function disposisis()
    {
        return $this->hasMany(Disposisi::class);
    }

    public function getPenerimaAttribute()
    {
        $penerima_id=$this->disposisis()->latest()->value('penerima_id');
        $user=User::find($penerima_id);
        return $user->getRoleNames()->implode(', ');
    }
}
