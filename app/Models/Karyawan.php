<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\DataIkm;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';

    protected $fillable = [
        'id_ikm',
        'tenaga_kerja_tetap',
        'tenaga_kerja_tidak_tetap',
        'tenaga_kerja_laki_laki',
        'tenaga_kerja_perempuan',
        'sd',
        'smp',
        'sma_smk',
        'd1_d3',
        's1_d4',
        's2',
        's3',
    ];

    public function dataIkm(): BelongsTo
    {
        return $this->belongsTo(DataIkm::class, 'id_ikm', 'id_ikm');
    }
}
