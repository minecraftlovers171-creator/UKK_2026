<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'siswa_id',
        'category_id',
        'tempat',
        'deskripsi_peminjaman',
        'status',
        'feedback',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
