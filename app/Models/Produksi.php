<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\DataIkm;
use App\Traits\UpdatesIkmLevel;

class Produksi extends Model
{
    use HasFactory;
    use UpdatesIkmLevel;

    protected $table = 'produksi';
    protected $primaryKey = 'id_produksi';

    protected $fillable = [
        'id_ikm',
        'jenis_produksi',
        'kbli',
        'kode_hs',
        'spesifikasi',
        'banyaknya',
        'nilai',
        'satuan',
        'presentase_produk_ekspor',
        'negara_tujuan_ekspor',
        'kapasitas_terpasang_per_tahun',
    ];

    public function dataIkm(): BelongsTo
    {
        return $this->belongsTo(DataIkm::class, 'id_ikm', 'id_ikm');
    }
}
