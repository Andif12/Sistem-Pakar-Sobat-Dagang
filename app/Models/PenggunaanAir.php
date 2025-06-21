<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\DataIkm;
use App\Traits\UpdatesIkmLevel;


class PenggunaanAir extends Model
{
    use HasFactory;
    use UpdatesIkmLevel;

    protected $table = 'penggunaan_air';
    protected $primaryKey = 'id_air';

    protected $fillable = [
        'id_ikm',
        'sumber_air',
        'banyaknya_penggunaan_m3',
        'biaya',
    ];

    public function dataIkm(): BelongsTo
    {
        return $this->belongsTo(DataIkm::class, 'id_ikm', 'id_ikm');
    }
}
