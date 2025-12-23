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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function disposisis()
    {
        return $this->hasMany(Disposisi::class);
    }
}
