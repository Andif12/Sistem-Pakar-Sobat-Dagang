<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class suratMetrologi extends Model
{
    use HasFactory;

     protected $table = 'surat_metrologi';
    protected $primaryKey = 'id_surat';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_surat',
        'user_id',
        'alamat_alat',
        'jenis_surat',
        'dokumen',
        'status_surat_masuk',
        'status_admin',
    ];

    public function suratBalasan(): HasOne
    {
        return $this->hasOne(suratBalasan::class, 'id_surat', 'id_surat');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
