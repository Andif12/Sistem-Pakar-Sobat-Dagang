<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;

    protected $table = 'toko';
    protected $primaryKey = 'id_toko';
    protected $fillable = [
        'id_rancangan',
        'id_distributor',
        'nama_toko',
        'kecamatan',
        'no_register',
    ];

    public function rencana()
    {
        return $this->belongsTo(RencanaKebutuhanDistributor::class, 'id_rancangan', 'id_rancangan');
    }
}
