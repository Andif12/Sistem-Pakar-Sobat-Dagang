<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndexHarga extends Model
{
    use HasFactory;

    protected $table = 'index_harga';
    protected $primaryKey = 'id_index';
    public $timestamps = true;

    protected $fillable = [
        'id_index_kategori',
        'id_barang',
        'harga',
        'tanggal',
        'lokasi',
        // 'created_at',
        // 'updated_at',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function kategori()
    {
        return $this->belongsTo(IndexKategori::class, 'id_index_kategori');
    }
}
