<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratMasuk extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'surat_masuk';

    // Nama primary key tabel
    protected $primaryKey = 'id_surat_masuk';
    
    /**
     * Matikan timestamps karena tabel tidak memiliki 
     * kolom created_at dan updated_at secara default.
     */
    public $timestamps = false; 

    /**
     * Kolom yang boleh diisi secara mass-assignment.
     * Pastikan 'asal_pengirim' sesuai dengan nama kolom di database Anda.
     */
    protected $fillable = [
        'nomor_surat',
        'tgl_surat',
        'asal_pengirim',
        'id_jenis', 
        'file_pdf'
    ];

    /**
     * Relasi ke tabel JenisSurat.
     * Mengasumsikan JenisSurat menggunakan primary key 'id_jenis'.
     */
    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'id_jenis', 'id_jenis');
    }
}