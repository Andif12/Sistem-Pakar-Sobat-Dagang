<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nama tabel
    protected $table = 'user';

    // Primary key custom
    protected $primaryKey = 'id_user';

    // Autoincrement aktif
    public $incrementing = true;

    // Primary key bukan UUID (string), tapi integer
    protected $keyType = 'int';

    // Timestamps aktif
    public $timestamps = true;

    // Kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'nama',
        'nik',
        'nib',
        'alamat_lengkap',
        'jenis_kelamin',
        'email',
        'telp',
        'password',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'role',
        'avatar'
    ];

    public function dataAlatUkurs()
    {
        return $this->hasMany(DataAlatUkur::class, 'id_user', 'id_user');
    }
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function uttps()
    {
        return $this->hasMany(Uttp::class, 'id_user', 'id_user');
    }
     public function forumDiskusi()
    {
        return $this->hasMany(ForumDiskusi::class, 'id_user', 'id_user');
    }
}
