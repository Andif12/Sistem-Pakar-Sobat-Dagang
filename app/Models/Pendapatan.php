<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\DataIkm;
use App\Traits\UpdatesIkmLevel;


class Pendapatan extends Model
{
    use HasFactory;
    use UpdatesIkmLevel;

    protected $table = 'pendapatan';
    protected $primaryKey = 'id_pendapatan';

    protected $fillable = [
        'id_ikm',
        'nilai',
        'sumber',
    ];

    public function dataIkm(): BelongsTo
    {
        return $this->belongsTo(DataIkm::class, 'id_ikm', 'id_ikm');
    }
}
