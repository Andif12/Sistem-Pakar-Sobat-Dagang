<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class suratBalasan extends Model
{
    protected $table = 'surat_keluar_metrologi';
    protected $primaryKey = 'id_surat_balasan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_surat_balasan',
        'id_surat',
        'sifat',
        'perihal',
        'lampiran',
        'tanggal',
        'isi_surat',
        'path_dokumen',
        'status_surat_keluar',
        'status_kepalaBidang',
        'status_kadis',
        'keterangan_kadis'
    ];

    public function suratMetrologi(): BelongsTo
    {
        return $this->belongsTo(SuratMetrologi::class, 'id_surat', 'id_surat');
    }
}
