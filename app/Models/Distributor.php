<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory;

    protected $table = 'distributor';

    protected $primaryKey = 'id_distributor';

    protected $fillable = [
        'id_user',
        'nib',
        'status',
    ];
    public function user()
{
    return $this->belongsTo(User::class, 'id_user');
}
}

