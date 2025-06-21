<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAlatUkur extends Model
{
    use HasFactory;

    protected $table = 'data_alat_ukur';
    protected $primaryKey = 'id_data_alat';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_uttp',
        'tanggal_exp',
        'status',
        'notifikasi_terkirim',
    ];

    /**
     * Relasi ke model Uttp
     */
    public function uttp()
    {
        return $this->belongsTo(Uttp::class, 'id_uttp', 'id_uttp');
    }
}
