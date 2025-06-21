<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\DataIkm;
use App\Traits\UpdatesIkmLevel;


class Persediaan extends Model
{
    use HasFactory;
    use UpdatesIkmLevel;

    protected $table = 'persediaan';
    protected $primaryKey = 'id_persediaan';

    protected $fillable = [
        'id_ikm',
        'jenis_persediaan',
        'awal',
        'akhir',
    ];

    public function dataIkm(): BelongsTo
    {
        return $this->belongsTo(DataIkm::class, 'id_ikm', 'id_ikm');
    }
}
