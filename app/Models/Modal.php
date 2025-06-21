<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\DataIkm;
use App\Traits\UpdatesIkmLevel;


class Modal extends Model
{
    use HasFactory;
    use UpdatesIkmLevel;

    protected $table = 'modal';
    protected $primaryKey = 'id_modal';

    protected $fillable = [
        'id_ikm',
        'jenis_barang',
        'pembelian_penambahan_perbaikan',
        'pengurangan_barang_modal',
        'penyusutan_barang',
        'nilai_taksiran',
    ];

    public function dataIkm(): BelongsTo
    {
        return $this->belongsTo(DataIkm::class, 'id_ikm', 'id_ikm');
    }
}
