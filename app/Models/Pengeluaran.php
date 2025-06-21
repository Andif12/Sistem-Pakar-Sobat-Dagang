<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\DataIkm;
use App\Traits\UpdatesIkmLevel;


class Pengeluaran extends Model
{
    use HasFactory;
    use UpdatesIkmLevel;

    protected $table = 'pengeluaran';
    protected $primaryKey = 'id_pengeluaran';

    protected $fillable = [
        'id_ikm',
        'upah_gaji',
        'pengeluaran_industri_distribusi',
        'pengeluaran_rnd',
        'pengeluaran_tanah',
        'pengeluaran_gedung',
        'pengeluaran_mesin',
        'lainnya',
    ];

    public function dataIkm(): BelongsTo
    {
        return $this->belongsTo(DataIkm::class, 'id_ikm', 'id_ikm');
    }
}
