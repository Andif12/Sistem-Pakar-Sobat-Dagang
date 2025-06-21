<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $fillable = ['nama_barang', 'id_index_kategori'];

    public function kategori()
    {
        return $this->belongsTo(IndexKategori::class, 'id_index_kategori');
    }
}
