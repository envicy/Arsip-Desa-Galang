<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Operator extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';

    // BARIS PENTING: Tambahkan ini untuk menghilangkan error updated_at
    public $timestamps = false; 

    protected $fillable = [
        'nama_pengguna', 
        'kata_sandi', 
        'nama_lengkap', 
        'peran', 
        'terakhir_login'
    ];

    protected $hidden = [
        'kata_sandi',
    ];

    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }
}