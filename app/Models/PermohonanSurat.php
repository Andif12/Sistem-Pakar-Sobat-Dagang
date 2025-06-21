<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanSurat extends Model
{
    use HasFactory;
    protected $keyType = 'string'; // Menggunakan string karena UUID adalah string
    public $incrementing = false; // Nonaktifkan incr
    protected $table = 'form_permohonan';
    protected $primaryKey = 'id_permohonan';
    protected $fillable = [
        'id_permohonan',    
        'id_user',
        'kecamatan',
        'kelurahan',
        'jenis_surat',
        'status',
        'tgl_pengajuan',
        'titik_koordinat',
        'file_balasan',
        'file_surat',

    ];
    public function document()
    {
        return $this->hasOne(DocumentUser::class, 'id_permohonan', 'id_permohonan');
    }
    // PermohonanSurat.php
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
