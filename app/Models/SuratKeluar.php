<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';
    protected $primaryKey = 'id_surat_keluar';
    
    // TAMBAHKAN INI: Matikan timestamps agar tidak mencari kolom updated_at
    public $timestamps = false; 

    protected $fillable = [
        'nomor_surat',
        'tgl_surat',
        'tujuan_surat',
        'id_jenis', 
        'file_pdf'
    ];

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'id_jenis', 'id_jenis');
    }
}