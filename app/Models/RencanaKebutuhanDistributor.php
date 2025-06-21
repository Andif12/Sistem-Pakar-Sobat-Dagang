<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaKebutuhanDistributor extends Model
{
    use HasFactory;

    protected $table = 'rencana_kebutuhan_distributor';
    protected $primaryKey = 'id_rancangan';

    protected $fillable = [
        'id_barang_pelaporan',
        'tahun',
        'jumlah',
    ];
}