<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\DataIkm;
use App\Traits\UpdatesIkmLevel;


class PenggunaanBahanBakar extends Model
{
    use HasFactory;
    use UpdatesIkmLevel;

    protected $table = 'penggunaan_bahan_bakar';
    protected $primaryKey = 'id_bahan_bakar';

    protected $fillable = [
        'id_ikm',
        'jenis_bahan_bakar',
        'satuan_standar',
        'banyaknya_proses_produksi',
        'nilai_proses_produksi',
        'banyaknya_pembangkit_tenaga_listrik',
        'nilai_pembangkit_tenaga_listrik',
    ];

    public function dataIkm(): BelongsTo
    {
        return $this->belongsTo(DataIkm::class, 'id_ikm', 'id_ikm');
    }
}
