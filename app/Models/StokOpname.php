<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokOpname extends Model
{
    use HasFactory;

    protected $table = 'stok_opname'; // nama tabel di database

    protected $primaryKey = 'id_stok_opname';

    protected $fillable = [
        'id_distributor',
        'id_toko',
        'stok_awal',
        'penyaluran',
        'stok_akhir',
        'tanggal',
        'nama_barang',
    ];

    public function toko(): BelongsTo
    {
        return $this->belongsTo(Toko::class, 'id_toko', 'id_toko');
    }

}

