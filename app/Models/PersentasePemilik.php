<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\DataIkm;

class PersentasePemilik extends Model
{
    use HasFactory;

    protected $table = 'persentase_pemilik';
    protected $primaryKey = 'id_persentase'; // Sesuai dengan migration

    protected $fillable = [
        'id_ikm',
        'pemerintah_pusat',
        'pemerintah_daerah',
        'swasta_nasional',
        'asing',
    ];

    public function dataIkm(): BelongsTo
    {
        return $this->belongsTo(DataIkm::class, 'id_ikm', 'id_ikm');
    }
}
