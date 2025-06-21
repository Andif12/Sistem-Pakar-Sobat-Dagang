<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SertifikasiHalal extends Model
{
    use HasFactory;

    protected $table = 'sertifikasi_halal';

    protected $primaryKey = 'id_halal';

    // Jika primaryKey bukan auto increment dan bertipe string, tambahkan property ini:
    // public $incrementing = false;
    // protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'id_ikm',
        'nama_usaha',
        'alamat',
        'no_sertifikasi_halal',
        'tanggal_sah',
        'tanggal_exp',
        'sertifikat',
        'status',
    ];

    // Kolom tanggal agar otomatis diparse ke Carbon instance
    protected $dates = [
        'tanggal_sah',
        'tanggal_exp',
        'created_at',
        'updated_at',
    ];

    // Jika kamu ingin menambahkan relasi (misal ke User atau IKM), kamu bisa tambah seperti ini:

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'id_user');
    // }

    // public function ikm()
    // {
    //     return $this->belongsTo(Ikm::class, 'id_ikm');
    // }
}