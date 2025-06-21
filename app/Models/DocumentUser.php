<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentUser extends Model
{
    use HasFactory;

    protected $table = 'document_user';
    protected $primaryKey = 'id_document';
    protected $fillable = [
        'id_permohonan',
        'npwp',
        'akta_perusahaan',
        'foto_ktp',
        'foto_usaha',
        'dokument_nib',
    ];

    public function permohonan()
    {
        return $this->belongsTo(PermohonanSurat::class, 'id_permohonan', 'id_permohonan');
    }
}
