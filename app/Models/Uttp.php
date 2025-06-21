<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Uttp extends Model
{
    use HasFactory;

    protected $table = 'uttp';
    protected $primaryKey = 'id_uttp';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_user',
        'tanggal_penginputan',
        'no_registrasi',
        'nama_usaha',
        'nama_alat',
        'jenis_alat',
        'merk_type',
        'nomor_seri',
        'alat_penguji',
        'ctt',
        'spt_keperluan',
        't_u',
        'tanggal_selesai',
        'terapan',
        'keterangan',
        'sertifikat_path',
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke model DataAlatUkur
     */
    public function dataAlatUkur()
    {
        return $this->hasOne(DataAlatUkur::class, 'id_uttp', 'id_uttp');
    }
}
