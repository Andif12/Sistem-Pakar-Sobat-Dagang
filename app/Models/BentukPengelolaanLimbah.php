<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\DataIkm;

class BentukPengelolaanLimbah extends Model
{
    use HasFactory;

    protected $table = 'bentuk_pengelolaan_limbah';
    protected $primaryKey = 'id_bentuk';

    protected $fillable = [
        'id_ikm',
        'jenis_limbah',
        'jumlah_limbah',
        'jenis_limbah_b3',
        'jumlah_limbah_b3',
        'tps_limbah_b3',
        'pihak_berizin',
        'internal_industri',
        'parameter_limbah_cair',
        'jumlah_limbah_cair',
    ];
    

    public function dataIkm(): BelongsTo
    {
        return $this->belongsTo(DataIkm::class, 'id_ikm', 'id_ikm');
    }
}
