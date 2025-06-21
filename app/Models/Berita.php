<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';
    protected $primaryKey = 'id_berita';

    // Kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'id_disdag',
        'judul',
        'isi',
        'lampiran',
        'tanggal',
    ];

    // Jika kolom tanggal ingin dikelola sebagai instance Carbon
    protected $dates = ['tanggal'];

    // Jika ada relasi, tambahkan seperti berikut (misalnya relasi dengan Disdag)
    public function disdag()
    {
        return $this->belongsTo(Disdag::class, 'id_disdag');
    }
}
