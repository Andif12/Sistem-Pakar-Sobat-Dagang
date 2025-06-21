<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\DataIkm;
use App\Traits\UpdatesIkmLevel;


class PemakaianBahan extends Model
{
    use HasFactory;
    use UpdatesIkmLevel;

    protected $table = 'pemakaian_bahan';
    protected $primaryKey = 'id_pemakaian_bahan';

    protected $fillable = [
        'id_ikm',
        'nama_bahan',
        'jenis_bahan',
        'spesifikasi',
        'kode_hs',
        'satuan_standar',
        'jumlah_dalam_negeri',
        'nilai_dalam_negeri',
        'jumlah_impor',
        'nilai_impor',
        'negara_asal_impor',
    ];

    public function dataIkm(): BelongsTo
    {
        return $this->belongsTo(DataIkm::class, 'id_ikm', 'id_ikm');
    }
}
