<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\DataIkm;

class MesinProduksi extends Model
{
    use HasFactory;

    protected $table = 'mesin_produksi';
    protected $primaryKey = 'id_mesin';

    protected $fillable = [
        'id_ikm',
        'jenis_mesin',
        'nama_mesin',
        'merk_type',
        'teknologi',
        'negara_pembuat',
        'tahun_perolehan',
        'tahun_pembuatan',
        'jumlah_unit',
    ];

    public function dataIkm(): BelongsTo
    {
        return $this->belongsTo(DataIkm::class, 'id_ikm', 'id_ikm');
    }
}
