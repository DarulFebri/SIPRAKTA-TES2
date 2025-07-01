<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'jenis_pengajuan',
        'judul_pengajuan',
        'status',
        'alasan_penolakan_admin',
        'alasan_penolakan_kaprodi',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }

    public function sidang()
    {
        return $this->hasOne(Sidang::class);
    }

    /**
     * Memeriksa apakah pengajuan sudah diserahkan dan tidak bisa lagi diedit dengan mudah.
     *
     * @return bool
     */
    public function isSubmitted(): bool
    {
        return in_array($this->status, [
            'diajukan_mahasiswa',
            'diverifikasi_admin',
            'dosen_ditunjuk',
            'menunggu_persetujuan_dosen',
            'sidang_dijadwalkan_final',
            'diverifikasi_kajur',
            'selesai'
        ]);
    }
}
