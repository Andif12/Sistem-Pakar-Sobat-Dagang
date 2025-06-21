<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Disdag extends Authenticatable
{
    protected $table = 'disdag';
    protected $primaryKey = 'id_disdag';

    protected $fillable = [ 
        'nip',
        'email',
        'password',
        'telp',
        'role'
    ];
    protected $guarded = []; // atau ['password', 'nip', dst...]

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $timestamps = true;

    public function forumDiskusi()
    {
        return $this->hasMany(ForumDiskusi::class, 'id_disdag', 'id_disdag');
    }
}
