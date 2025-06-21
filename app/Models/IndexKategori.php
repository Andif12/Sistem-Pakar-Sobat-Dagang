<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndexKategori extends Model


{
    protected $table = 'index_kategori';
    protected $primaryKey = 'id_index_kategori';
    protected $fillable = ['nama_kategori'];
}
